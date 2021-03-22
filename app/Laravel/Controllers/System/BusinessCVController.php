<?php

namespace App\Laravel\Controllers\System;

/*
 * Request Validator
 */

/*
 * Models
 */

use App\Laravel\Models\Business;
use App\Laravel\Models\BusinessLine;
use App\Laravel\Models\BusinessTransaction;
use Carbon,Auth,DB,Str,Helper,Event;
use App\Laravel\Requests\PageRequest;
use App\Laravel\Requests\System\BusinessUpdaterequest;

/* App Classes
 */

class BusinessCVController extends Controller
{
    protected $data;
	protected $per_page;

	public function __construct(){
		parent::__construct();
		array_merge($this->data, parent::get_data());
		$this->per_page = env("DEFAULT_PER_PAGE",10);
	}

	public function  index(PageRequest $request){
		$this->data['page_title'] = "Business CV";
		$auth = Auth::user();

        $first_record = Business::orderBy('created_at','ASC')->first();
		$start_date = $request->get('start_date',Carbon::now()->startOfMonth());

		if($first_record){
			$start_date = $request->get('start_date',$first_record->created_at->format("Y-m-d"));
        }
        $this->data['start_date'] = Carbon::parse($start_date)->format("Y-m-d");
		$this->data['end_date'] = Carbon::parse($request->get('end_date',Carbon::now()))->format("Y-m-d");
        $this->data['selected_status'] = $request->status;
		$this->data['selected_processing_fee_status'] = $request->get('processing_fee_status');
		$this->data['keyword'] = Str::lower($request->keyword);

        $this->data['business'] = Business::with(['owner'])
        ->whereHas('owner',function($query){
            if(strlen($this->data['keyword']) > 0){
                return $query->WhereRaw("CONCAT(fname, ' ', mname, '', lname)  LIKE  '%{$this->data['keyword']}%'");
            }
        })
        ->orwhere(function($query){
            if(strlen($this->data['keyword']) > 0){
                return $query->where('business_name', 'like', "%{$this->data['keyword']}%")->orWhere('business_id_no', 'like', "%{$this->data['keyword']}%");
            }
        })
        ->where(DB::raw("DATE(created_at)"),'>=',$this->data['start_date'])
        ->where(DB::raw("DATE(created_at)"),'<=',$this->data['end_date'])
        ->orderBy('created_at',"DESC")->paginate($this->per_page);
        // dd($this->data);
		return view('system.business-cv.index',$this->data);
    }

    public function show(PageRequest $request, $id = null)
    {
        $business_cv =  Business::find($id);
        $this->update_status($id);
        $this->data['profile'] = $business_cv;
        $this->data['page_title'] = "Business CV";
        $this->data['business_line'] = BusinessLine::where('business_id', $id)->get();
        return view('system.business-cv.show', $this->data);
    }

    public function update_status($id = null)
    {
        $Business_cv = Business::find($id);
        $Business_cv->isNew = null;
        $Business_cv->save();
    }

	public function  create(PageRequest $request){
		$this->data['page_title'] .= "Application - Add new record";
		return view('system.collection-of-fees.create',$this->data);
    }
	public function store(PageReques $request){

	}

	public function  edit(PageRequest $request,$id = NULL){
        $this->data['page_title'] .= "Edit Business CV";
        $this->data['business'] = Business::find($id);

		return view('system.business-cv.edit',$this->data);
	}

	public function update(BusinessUpdaterequest $request,$id = NULL){

        $business = Business::find($id);
        $business->tradename = $request->trade_name;

        $business->dti_sec_cda_registration_no = $request->dti_sec_cda_registration_no;
        $business->dti_sec_cda_registration_date = $request->dti_sec_cda_registration_date;
        $business->ctc_no = $request->ctc_no;
        $business->business_tin = $request->business_tin;
        $business->tax_incentive = $request->tax_incentive;

        $business->owner_fname = $request->owner_fname;
        $business->owner_mname = $request->owner_mname;
        $business->owner_lname = $request->owner_lname;
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

        session()->flash('notification-status', "success");
        session()->flash('notification-msg', "The Business CV was successfully updated.");
        return redirect()->route('system.business_cv.index');

	}

	public function  destroy(PageRequest $request,$id = NULL){
		DB::beginTransaction();
		try{
            $transaction = BusinessTransaction::where('business_id', $id)->first();
            if($transaction){
                $transaction->deleted_by = auth()->guard('user')->user()->id;
                $transaction->save();
            }
            Business::find($id)->forceDelete();
			DB::commit();
			session()->flash('notification-status', "success");
            session()->flash('notification-msg', "The Business CV was successfully deleted.");
			return redirect()->route('system.business_cv.index');
		}catch(\Exception $e){
            DB::rollback();
            throw $e;
			session()->flash('notification-status', "failed");
			session()->flash('notification-msg', "Server Error: Code #{$e->getMessage()}");
			return redirect()->back();
		}
	}
}
