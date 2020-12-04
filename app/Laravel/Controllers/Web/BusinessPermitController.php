<?php

namespace App\Laravel\Controllers\Web;

use App\Laravel\Models\Business;
use App\Http\Controllers\Controller;
use App\Laravel\Requests\PageRequest;
use App\Laravel\Models\BusinessActivity;
use Carbon,Auth,Str,Curl,Helper, DB, Log;
use App\Laravel\Models\ApplicationBusinessPermit;
use App\Laravel\Requests\Web\BusinessPermitRequest;

class BusinessPermitController extends Controller{

	protected $data;

	public function __construct(){
		parent::__construct();
	}

	public function create(PageRequest $request){
        $this->data['page_title'] = 'Application Business Permit';
        if (Auth::guard('customer')->user()) {
			$this->data['auth'] = Auth::guard('customer')->user();
            $this->data['business_profiles'] = Business::where('customer_id',$this->data['auth']->id)->get();
            $business = Business::find(session()->get('selected_business_id'));
            $this->data['business'] = $business;
        }
        return view('web.application.business-permit', $this->data);
	}

	public function store(BusinessPermitRequest $request){
        $auth = Auth::guard('customer')->user();
        $business = Business::find(session()->get('selected_business_id'));
        $this->data['business'] = $business;

		DB::beginTransaction();
		try{
			$new_business_permit = new ApplicationBusinessPermit();
            $new_business_permit->customer_id = $auth->id;
            $new_business_permit->business_id = $business->id;
            $new_business_permit->application_date = $request->application_date;
            $new_business_permit->dti_sec_cda_registration_no = $request->dti_sec_cda_registration_no;
            $new_business_permit->dti_sec_cda_registration_date = $request->dti_sec_cda_registration_date;
            $new_business_permit->ctc_no = $request->ctc_no;
            $new_business_permit->business_tin = $request->business_tin;
            $new_business_permit->type = $request->application_type;
            $new_business_permit->frequency_of_payment = $request->frequency_of_payment;
            $new_business_permit->amendments = $request->amendments;
            $new_business_permit->tax_incentive = $request->tax_incentive;
            $new_business_permit->tradename = $request->trade_name;

            $new_business_permit->rep_lastname = $request->rep_lastname;
            $new_business_permit->rep_firstname = $request->rep_firstname;
            $new_business_permit->rep_middlename = $request->rep_middlename;
            $new_business_permit->rep_gender = $request->rep_gender;
            $new_business_permit->rep_position = $request->rep_position;
            $new_business_permit->rep_tin = $request->rep_tin;

            $new_business_permit->website_url = $request->business_website;
            $new_business_permit->business_area = $request->business_area;

            $new_business_permit->lessor_fullname = $request->lessor_fullname;
            $new_business_permit->lessor_gender = $request->lessor_gender;
            $new_business_permit->lessor_monthly_rental = $request->lessor_monthly_rental;
            $new_business_permit->lessor_rental_date = $request->lessor_rental_date;
            $new_business_permit->lessor_mobile_no = $request->lessor_mobile_no;
            $new_business_permit->lessor_tel_no = $request->lessor_tel_no;
            $new_business_permit->lessor_email = $request->lessor_email;
            $new_business_permit->lessor_unit_no = $request->lessor_unit_no;
            $new_business_permit->lessor_street_address = $request->street_address;
            $new_business_permit->lessor_brgy = $request->lessor_brgy;
            $new_business_permit->lessor_brgy_name = $request->lessor_brgy_name;
            $new_business_permit->lessor_zipcode = $request->lessor_zipcode;
            $new_business_permit->lessor_town = $request->lessor_town;
            $new_business_permit->lessor_town_name = $request->lessor_town_name;
            $new_business_permit->lessor_region = $request->lessor_region;
            $new_business_permit->lessor_region_name = $request->lessor_region_name;

            $new_business_permit->lessor_emergency_contact_fullname = $request->emergency_contact_fullname;
            $new_business_permit->lessor_emergency_contact_tel_no = $request->emergency_contact_tel_no;
            $new_business_permit->lessor_emergency_contact_mobile_no = $request->emergency_contact_mobile_no;
            $new_business_permit->lessor_emergency_contact_email = $request->emergency_contact_email;

            $new_business_permit->save();

            foreach ($request->line_of_business as $key => $v) {
                $data = [
                    'application_business_permit_id' => $new_business_permit->id,
                    'line_of_business' => $request->line_of_business [$key],
                    'no_of_unit' => $request->no_of_units [$key],
                    'capitalization' => $request->capitalization [$key],
                    'gross_sales' => $request->renew [$key],
                ];

                BusinessActivity::insert($data);
            }

			DB::commit();
			session()->flash('notification-status', "success");
			session()->flash('notification-msg', "Business Permit Added to this Business CV.");
			return redirect()->route('web.business.index');
		}catch(\Exception $e){
			DB::rollback();
			session()->flash('notification-status', "failed");
			session()->flash('notification-msg', "Server Error: Code #{$e->getMessage()}");
			return redirect()->back();
		}
	}
}
