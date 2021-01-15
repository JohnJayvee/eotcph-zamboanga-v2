<?php

namespace App\Laravel\Controllers\Web;

/*
 * Request Validator
 */
use App\Laravel\Models\User;
use App\Laravel\Models\Business;
use App\Laravel\Models\BusinessLine;
use App\Laravel\Requests\PageRequest;
use App\Laravel\Events\SendNewBusinessCV;
use App\Laravel\Models\BusinessTransaction;
use App\Laravel\Models\BusinessActivity;
use App\Laravel\Requests\Web\UploadRequest;
use App\Laravel\Requests\Web\BusinessRequest;
use App\Laravel\Events\SendNewBusinessCVEmail;
/*
 * Models
 */


use App\Laravel\Requests\Web\TransactionRequest;
use App\Laravel\Requests\Web\EditBusinessRequest;
use App\Laravel\Requests\Web\BusinessPermitRequest;
use Carbon,Auth,DB,Str,ImageUploader,Event,FileUploader,PDF,QrCode,Helper,Curl,Log;

class BusinessController extends Controller
{
    protected $data;
	protected $per_page;

	public function __construct(){
		parent::__construct();
		array_merge($this->data, parent::get_data());

		$this->data['business_scopes'] = ["" => "Choose Business Scope",'national' => "National",'regional' => "Regional",'municipality' => "City/Municipality",'barangay' => "Barangay"];
		$this->data['business_types'] = ["" => "Choose Business Type",'sole_proprietorship' => "Sole Proprietorship",'cooperative' => "Cooperative",'corporation' => "Corporation",'partnership' => "Partnership", 'association' => "Association"];
		$this->data['transaction_types'] = ['new' => "New Business",'renewal' => "Renewal"];
		if (Auth::guard('customer')->user()) {
			$this->data['auth'] = Auth::guard('customer')->user();
			$this->data['business_profiles'] = Business::where('customer_id',$this->data['auth']->id)->get();
		}
		$this->per_page = env("DEFAULT_PER_PAGE",10);
	}


	public function index(PageRequest $request){
		$this->data['page_title'] = "Business Profile";
		$this->data['auth'] = Auth::guard('customer')->user();
		return view('web.business.index',$this->data);
	}
	public function create(PageRequest $request){
		$this->data['page_title'] = "Create Business CV";
        $this->data['auth'] = Auth::guard('customer')->user();

        if($request->business_id_no){
            $request_body = [
                'business_id' => $request->business_id_no,
            ];
            $response = Curl::to(env('OBOSS_BUSINESS_PROFILE'))
                         ->withData($request_body)
                         ->asJson( true )
                         ->returnResponseObject()
                         ->post();

            if($response->status == "200"){
                $content = $response->content;
                session()->flash('notification-status', "success");
                session()->flash('notification-msg', "Business validated");
                session()->forget('negativelist');
                $this->data['business'] = $response->content['data'];
                $this->data['business_type_f'] = $response->content['data'];

                foreach ($this->data['business']['LineOfBusiness'] as $key => $value) {
                    if(!empty($value['Class'])){
                        $particulars = !empty($value['Particulars']) ? " (".$value['Particulars'].")" : "";
                        $this->data['lob'][] = $value['Class'].$particulars;
                    }
                }
                switch ($this->data['business']['Organization']) {
                    case 'SINGLE PROPRIETORSHIP':
                        $this->data['business_type_f'] = 'sole_proprietorship';
                        break;
                    case 'PARTNERSHIP':
                        $this->data['business_type_f'] = 'partnership';
                        break;
                    case 'CORPORATION':
                        $this->data['business_type_f'] = 'corporation';
                        break;
                    case 'COOPERATIVE':
                        $this->data['business_type_f'] = 'cooperative';
                        break;
                    case 'ASSOCIATION':
                        $this->data['business_type_f'] = 'association';
                        break;
                    default:
                        $this->data['business_type_f'] = null;
                        break;
                }
                session()->put('line_of_business', $this->data['business']['LineOfBusiness']);
            } elseif ($response->status == "400") {
                session()->put('negativelist', 1);
            }else {
                session()->flash('notification-status', "failed");
                session()->flash('notification-msg', "Business not found");
            }
        }
		return view('web.business.create',$this->data);

    }

	public function store(BusinessRequest $request){

        $auth = Auth::guard('customer')->user();
        DB::beginTransaction();
        try{
            $new_business = new Business;
            $new_business->customer_id = $auth->id;
            $new_business->isNew = 1;
            $new_business->business_scope = $request->get('business_scope');
            $new_business->business_type = $request->get('business_type');
            $new_business->dominant_name = $request->get('dominant_name');
            $new_business->business_name = $request->get('business_name');
            $new_business->tradename = $request->trade_name;
            $new_business->business_id_no = $request->get('business_id_no');
            $new_business->permit_no = $request->get('permit_no');
            $new_business->business_plate_no = $request->get('business_plate_no');

            $new_business->dti_sec_cda_registration_no = $request->dti_sec_cda_registration_no;
            $new_business->dti_sec_cda_registration_date = $request->dti_sec_cda_registration_date;
            $new_business->ctc_no = $request->ctc_no;
            $new_business->business_tin = $request->business_tin;
            $new_business->tax_incentive = $request->tax_incentive;

            $new_business->owner_fname = $request->owner_firstname;
            $new_business->owner_mname = $request->owner_middlename;
            $new_business->owner_lname = $request->owner_lastname;
            $new_business->owner_email = $request->owner_email;
            $new_business->owner_tin = $request->owner_tin;
            $new_business->owner_mobile_no = $request->owner_mobile_no;
            $new_business->owner_brgy = $request->owner_brgy;
            $new_business->owner_brgy_name = $request->owner_brgy_name;
            $new_business->owner_unit_no = $request->owner_unit_no;
            $new_business->owner_street = $request->owner_street;

            $new_business->rep_lastname = $request->rep_lastname;
            $new_business->rep_firstname = $request->rep_firstname;
            $new_business->rep_middlename = $request->rep_middlename;
            $new_business->rep_gender = $request->rep_gender;
            $new_business->rep_position = $request->rep_position;
            $new_business->rep_tin = $request->rep_tin;

            $new_business->website_url = $request->website_url;
            $new_business->business_area = $request->business_area;

            $new_business->lessor_fullname = $request->lessor_fullname;
            $new_business->lessor_gender = $request->lessor_gender;
            $new_business->lessor_monthly_rental = $request->lessor_monthly_rental;
            $new_business->lessor_rental_date = $request->lessor_rental_date;
            $new_business->lessor_mobile_no = $request->lessor_mobile_no;
            $new_business->lessor_tel_no = $request->lessor_tel_no;
            $new_business->lessor_email = $request->lessor_email;
            $new_business->lessor_unit_no = $request->lessor_unit_no;
            $new_business->lessor_street_address = $request->lessor_street_address;
            $new_business->lessor_brgy = $request->lessor_brgy;
            $new_business->lessor_brgy_name = $request->lessor_brgy_name;
            $new_business->lessor_region = $request->lessor_region;
            $new_business->lessor_region_name = $request->lessor_region_name;
            $new_business->lessor_town = $request->lessor_town;
            $new_business->lessor_town_name = $request->lessor_town_name;
            $new_business->lessor_zipcode = $request->lessor_zipcode;

            $new_business->emergency_contact_fullname = $request->emergency_contact_fullname;
            $new_business->emergency_contact_mobile_no = $request->emergency_contact_mobile_no;
            $new_business->emergency_contact_tel_no = $request->emergency_contact_tel_no;
            $new_business->emergency_contact_email = $request->emergency_contact_email;

            $new_business->no_of_male_employee = $request->get('no_male_employee');
            $new_business->no_of_female_employee = $request->get('no_female_employee');
            $new_business->male_residing_in_city = $request->get('male_residing_in_city');
            $new_business->female_residing_in_city = $request->get('female_residing_in_city');

            $new_business->capitalization = $request->get('capitalization');
            $new_business->region_name = $request->get('region_name');
            $new_business->town_name = $request->get('town_name');
            $new_business->region = $request->get('region');
            $new_business->town = $request->get('town');
            $new_business->brgy_name = $request->get('brgy_name');
            $new_business->brgy = $request->get('brgy');
            $new_business->zipcode = $request->get('zipcode');
            $new_business->unit_no = $request->get('unit_no');
            $new_business->street_address = $request->get('street_address');
            $new_business->email = $request->get('email');
            $new_business->mobile_no = $request->get('mobile_no');
            $new_business->telephone_no = $request->get('telephone_no');
            $new_business->tin_no = $request->get('tin_no');
            $new_business->sss_no = $request->get('sss_no');
            $new_business->philhealth_no = $request->get('philhealth_no');
            $new_business->pagibig_no = $request->get('pagibig_no');

            $new_business->save();

            $line_of_businesses = session()->get("line_of_business");
            session()->forget("line_of_business");

            if(!empty($line_of_businesses)){
                foreach ($line_of_businesses as $line_of_business) {
                    $particulars = !empty($line_of_business['Particulars']) ? " (".$line_of_business['Particulars'].")" : "";
                    $data = [
                        'business_id' => $new_business->id,
                        'name' => $line_of_business['Class'],
                        'particulars' => $line_of_business['Particulars'],
                        'account_code' => $line_of_business['AcctCode'],
                        'b_class' => $line_of_business['BClass'],
                        's_class' => $line_of_business['SClass'],
                        'x_class' => $line_of_business['XClass'],
                        'reference_code' => $line_of_business['RefCode'],
                        'gross_sales' => $line_of_business['GrossSales'],
                    ];
                    BusinessLine::insert($data);
                }
            }
            $bplo = User::where('type', 'admin')->first();
            DB::commit();
            $insert[] = [
                'email' => $bplo->email,
                'contact_number' => $bplo->contact_number,
                'businessOwner' => Auth::guard('customer')->user()->name,
            ];
            // send Email
            $notification_data = new SendNewBusinessCVEmail($insert);
            Event::dispatch('send-new-business_cv-email', $notification_data);

            // send SMS
            //$notification_data = new SendNewBusinessCV($insert);
            //Event::dispatch('send-new-business_cv', $notification_data);

            session()->flash('notification-status', "success");
            session()->flash('notification-msg', "New Business CV has been added.");
            session()->forget('status_code');
            session()->forget('negativelist');
            return redirect()->route('web.business.index');
        }catch(\Exception $e){
            DB::rollback();
            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Server Error: Code #{$e->getMessage()}");
            return redirect()->route('web.business.create')->withInput();
        }

        /*$request_body = [
            'bnn' => $request->dti_sec_cda_registration_no,
            'business_name' => $request->business_name,
        ];
        $response = Curl::to(env('BNRS_BNN'))
                ->withHeaders( [
                    "X-BNRS-API-Code: ".env('BNRS_CODE'),
                    "X-BNRS-API-Secret: ".env("BNRS_SECRET")
                ])
                ->withData($request_body)
                ->asJson( true )
                ->returnResponseObject()
                ->post();
        $content = $response->content;
        $status_code = $content['status_code'];
        // session()->put('status_code', $status_code);
        switch ($status_code) {
            case 'NO_RECORD':
                session()->flash('notification-status', "failed");
                session()->flash('notification-msg', "BNN not Found");
                return redirect()->route('web.business.create')->with('bnn-error', 'BNN not found')->withInput(request()->all());
                break;
            default:

            break;
        }*/

	}
	public function business_profile(PageRequest $request , $id = NULL){

		$this->data['page_title'] = "Create Business CV";
        $this->data['profile'] = Business::find($id);
        if(!$this->data['profile']){
            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Business CV has been deleted");
            return redirect()->route('web.business.index');
        }
        $this->data['business_transaction'] = BusinessTransaction::where('business_id', $id)->first();
        $this->data['business_line'] = BusinessLine::where('business_id', session()->get('selected_business_id'))->get();
        session()->put('selected_business_id', $id);
		return view('web.business.profile',$this->data);
    }

    public function business_edit(){
        $this->data['page_title'] = "Edit Business CV";
		$this->data['auth'] = Auth::guard('customer')->user();
		$this->data['business'] = Business::find(session()->get('selected_business_id'));
		if(!$this->data['business']){
			session()->flash('notification-status',"warning");
			session()->flash('notification-msg',"No CV has been selected");
			return redirect()->route('frontend.business.index');
        }
		return view('web.business.edit',$this->data);
	}

	public function business_update(PageRequest $request){

        DB::beginTransaction();
		try{
			$business = Business::find(session()->get('selected_business_id'));
            // $business->business_scope = $request->get('business_scope');
            // $business->business_type = $request->get('business_type');
            // $business->dominant_name = $request->get('dominant_name');
            // $business->business_name = $request->get('business_name');
            // $business->business_id_no = $request->get('BusinessID');
            $business->tradename = $request->trade_name;
            $business->dti_sec_cda_registration_no = $request->dti_sec_cda_registration_no;
            $business->dti_sec_cda_registration_date = $request->dti_sec_cda_registration_date;
            $business->ctc_no = $request->ctc_no;
            $business->business_tin = $request->business_tin;
            $business->tax_incentive = $request->tax_incentive;


            $business->owner_fname = $request->owner_firstname;
            $business->owner_mname = $request->owner_middlename;
            $business->owner_lname = $request->owner_lastname;
            $business->owner_email = $request->owner_email;
            $business->owner_tin = $request->owner_tin;
            $business->owner_mobile_no = $request->owner_mobile_no;
            $business->owner_brgy = $request->owner_brgy;
            $business->owner_brgy_name = $request->owner_brgy_name;
            $business->owner_unit_no = $request->owner_unit_no;
            $business->owner_street = $request->owner_street;

            $business->rep_lastname = $request->rep_lastname;
            $business->rep_firstname = $request->rep_firstname;
            $business->rep_middlename = $request->rep_middlename;
            $business->rep_gender = $request->rep_gender;
            $business->rep_position = $request->rep_position;
            $business->rep_tin = $request->rep_tin;

            $business->website_url = $request->website_url;
            $business->business_area = $request->business_area;

            $business->lessor_fullname = $request->lessor_fullname;
            $business->lessor_gender = $request->lessor_gender;
            $business->lessor_monthly_rental = $request->lessor_monthly_rental;
            $business->lessor_rental_date = $request->lessor_rental_date;
            $business->lessor_mobile_no = $request->lessor_mobile_no;
            $business->lessor_tel_no = $request->lessor_tel_no;
            $business->lessor_email = $request->lessor_email;
            $business->lessor_unit_no = $request->lessor_unit_no;
            $business->lessor_street_address = $request->lessor_street_address;
            $business->lessor_brgy = $request->lessor_brgy;
            $business->lessor_brgy_name = $request->lessor_brgy_name;
            $business->lessor_region = $request->lessor_region;
            $business->lessor_region_name = $request->lessor_region_name;
            $business->lessor_town = $request->lessor_town;
            $business->lessor_town_name = $request->lessor_town_name;
            $business->lessor_zipcode = $request->lessor_zipcode;

            $business->emergency_contact_fullname = $request->emergency_contact_fullname;
            $business->emergency_contact_mobile_no = $request->emergency_contact_mobile_no;
            $business->emergency_contact_tel_no = $request->emergency_contact_tel_no;
            $business->emergency_contact_email = $request->emergency_contact_email;

            $business->no_of_male_employee = $request->get('no_male_employee');
            $business->no_of_female_employee = $request->get('no_female_employee');
            $business->male_residing_in_city = $request->get('male_residing_in_city');
            $business->female_residing_in_city = $request->get('female_residing_in_city');

            $business->capitalization = $request->get('capitalization');
            $business->region_name = $request->get('region_name');
            $business->town_name = $request->get('town_name');
            $business->region = $request->get('region');
            $business->town = $request->get('town');
            $business->brgy_name = $request->get('brgy_name');
            $business->brgy = $request->get('brgy');
            $business->zipcode = $request->get('zipcode');
            $business->unit_no = $request->get('unit_no');
            $business->street_address = $request->get('street_address');
            $business->email = $request->get('email');
            $business->mobile_no = $request->get('mobile_no');
            $business->telephone_no = $request->get('telephone_no');
            $business->tin_no = $request->get('tin_no');
            $business->sss_no = $request->get('sss_no');
            $business->philhealth_no = $request->get('philhealth_no');
            $business->pagibig_no = $request->get('pagibig_no');
            $business->save();

			DB::commit();
			session()->flash('notification-status',"success");
            session()->flash('notification-msg',"Business information was successfully updated.");
            return redirect()->route('web.business.profile', [session()->get('selected_business_id')]);
		}catch(\Exception $e){
			DB::rollback();
			session()->flash('notification-status', "failed");
			session()->flash('notification-msg', "Server Error: Code #{$e->getMessage()}");
			return redirect()->back();
		}
	}

    public function history(PageRequest $request,$id = NULL){
        $this->data['page_title'] = "Business Profile";
        $this->data['auth'] = Auth::guard('customer')->user();

        $this->data['business_history'] =  BusinessTransaction::where('business_id', $id)->orderBy('created_at',"DESC")->get();

        return view('web.business.history',$this->data);
    }

    public function e_permit(PageRequest $request , $id = NULL){

        $this->data['d1']  = new Carbon('12/31');
        $this->data['business_transaction'] = BusinessTransaction::where('business_id', $id)->where('digital_certificate_released',"1")->first();

        if ($this->data['business_transaction']) {

            $this->data['business'] = Business::find($this->data['business_transaction']->business_id);
            $this->data['business_lines'] = BusinessActivity::where('application_business_permit_id', $this->data['business_transaction']->business_permit_id)->get();
            $pdf = PDF::loadView('pdf.e-permit',$this->data)->setPaper('a4', 'landscape');
            return $pdf->stream("e-permit.pdf");
        }else{
            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "You dont have access for this process");
            return redirect()->route('web.main.index');
        }


    }

     public function e_permit_view(PageRequest $request , $id = NULL){

        $this->data['d1']  = new Carbon('12/31');
        $this->data['business_transaction'] = BusinessTransaction::where('id', $id)->where('digital_certificate_released',"1")->first();

        if ($this->data['business_transaction']) {
            $this->data['business'] = Business::find($this->data['business_transaction']->business_id);
            $this->data['business_lines'] = BusinessActivity::where('application_business_permit_id', $this->data['business_transaction']->business_permit_id)->get();
            $pdf = PDF::loadView('pdf.e-permit',$this->data)->setPaper('a4', 'landscape');
            return $pdf->stream("e-permit.pdf");
        }else{
            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "You dont have access for this process");
            return redirect()->route('web.main.index');
        }


    }

    public function delete(PageRequest $request, $id = null)
    {
        DB::beginTransaction();
        try{
            $transaction = BusinessTransaction::where('business_id', $id)->first();
            if($transaction){
                $transaction->deleted_by = "customer";
                $transaction->save();
            }

            Business::find($id)->forceDelete();

            DB::commit();
            session()->flash('notification-status',"success");
            session()->flash('notification-msg',"The Business CV was successfully deleted. Don't worry, you can still re-use your Business ID (BID) to create a new Business CV.");
            return redirect()->route('web.business.index');
        }catch(\Throwable $e){
            DB::rollback();
            session()->flash('notification-status',"failed");
            session()->flash('notification-msg',"Server Error: Code #{$e->getMessage()}");
            return redirect()->route('web.business.index');
        }

    }

}
