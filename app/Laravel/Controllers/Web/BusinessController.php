<?php

namespace App\Laravel\Controllers\Web;

/*
 * Request Validator
 */
use App\Laravel\Requests\PageRequest;
use App\Laravel\Requests\Web\TransactionRequest;
use App\Laravel\Requests\Web\UploadRequest;
use App\Laravel\Requests\Web\BusinessRequest;
use App\Laravel\Models\Business;
use App\Laravel\Models\BusinessLine;
use App\Laravel\Requests\Web\EditBusinessRequest;
/*
 * Models
 */


use Carbon,Auth,DB,Str,ImageUploader,Event,FileUploader,PDF,QrCode,Helper,Curl,Log;

class BusinessController extends Controller
{
     protected $data;
	protected $per_page;

	public function __construct(){
		parent::__construct();
		array_merge($this->data, parent::get_data());

		$this->data['business_scopes'] = ['national' => "National",'regional' => "Regional",'municipality' => "City/Municipality",'barangay' => "Barangay"];
		$this->data['business_types'] = ['sole_proprietorship' => "Sole Proprietorship",'cooperative' => "Cooperative",'corporation' => "Corporation",'partnership' => "Partnership"];
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

                $this->data['business'] = $response->content['data'];
                foreach ($this->data['business']['LineOfBusiness'] as $key => $value) {
                    if(!empty($value['Particulars'])){
                        $this->data['lob'][] = $value['Particulars'];
                    }
                }
            } else {
                session()->flash('notification-status', "failed");
                session()->flash('notification-msg', "Business not found");
            }
        }
		return view('web.business.create',$this->data);

    }

	public function store(PageRequest $request){
		$auth = Auth::guard('customer')->user();

		DB::beginTransaction();
		try{
			$new_business = new Business;
			$new_business->customer_id = $auth->id;
			$new_business->business_scope = $request->get('business_scope');
			$new_business->business_type = $request->get('business_type');
			$new_business->dominant_name = $request->get('dominant_name');
			$new_business->business_name = $request->get('business_name');
            $new_business->tradename = $request->trade_name;
            $new_business->business_id_no = $request->get('BusinessID');

            $new_business->dti_sec_cda_registration_no = $request->dti_sec_cda_registration_no;
            $new_business->dti_sec_cda_registration_date = $request->dti_sec_cda_registration_date;
            $new_business->ctc_no = $request->ctc_no;
            $new_business->business_tin = $request->business_tin;
            $new_business->tax_incentive = $request->tax_incentive;

            $new_business->rep_lastname = $request->rep_lastname;
            $new_business->rep_firstname = $request->rep_firstname;
            $new_business->rep_middlename = $request->rep_middlename;
            $new_business->rep_gender = $request->rep_gender;
            $new_business->rep_position = $request->rep_position;
            $new_business->rep_tin = $request->rep_tin;

            $new_business->website_url = $request->business_website;
            $new_business->business_area = $request->business_area;

            $new_business->lessor_fullname = $request->lessor_fullname;
            $new_business->lessor_gender = $request->lessor_gender;
            $new_business->lessor_monthly_rental = $request->lessor_monthly_rental;
            $new_business->lessor_rental_date = $request->lessor_rental_date;
            $new_business->lessor_mobile_no = $request->lessor_mobile_no;
            $new_business->lessor_tel_no = $request->lessor_tel_no;
            $new_business->lessor_email = $request->lessor_email;
            $new_business->lessor_unit_no = $request->lessor_unit_no;
            $new_business->lessor_street_address = $request->street_address;
            $new_business->lessor_brgy = $request->lessor_brgy;
            $new_business->lessor_brgy_name = $request->lessor_brgy_name;
            $new_business->lessor_zipcode = $request->lessor_zipcode;

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


            foreach ($request->business_line as $key => $v) {
                $data = [
                    'business_id' => $new_business->id,
                    'name' => $request->business_line[$key],
                ];
                BusinessLine::insert($data);
            }
			DB::commit();
			session()->flash('notification-status', "success");
			session()->flash('notification-msg', "New Bureau/Office has been added.");
			return redirect()->route('web.business.index');
		}catch(\Exception $e){
			DB::rollback();
			session()->flash('notification-status', "failed");
			session()->flash('notification-msg', "Server Error: Code #{$e->getLine()}");
			return redirect()->back();
		}

	}
	public function business_profile(PageRequest $request , $id = NULL){

		$this->data['page_title'] = "Create Business CV";

		$this->data['profile'] = Business::find($id);
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

	public function business_update(EditBusinessRequest $request){

        DB::beginTransaction();
		try{
			$business = Business::find(session()->get('selected_business_id'));

            $business->no_of_male_employee = $request->get('no_male_employee');
            $business->no_of_female_employee = $request->get('no_female_employee');
            $business->male_residing_in_city = $request->get('male_residing_in_city');
            $business->female_residing_in_city = $request->get('female_residing_in_city');
            $business->business_line = $request->get('business_line');
            $business->capitalization = $request->get('capitalization');
            $business->website_url = $request->get('website_url');
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

   
}
