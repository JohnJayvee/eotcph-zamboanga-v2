<?php namespace App\Laravel\Requests\Web;

use Session,Auth;
use App\Laravel\Requests\RequestManager;

class BusinessRequest extends RequestManager{

	public function rules(){

		$id = $this->route('id')?:0;
            $file = $this->file('file') ? count($this->file('file')) : 0;
            
		$rules = [
                  "business_id_no" => "required|unique:business,business_id_no",
                  "business_scope" => "required",
                  "business_type" => "required",
                  "dominant_name" => "required",
                  "business_name" => "required",
                  "trade_name" => "required",
                  "dti_sec_cda_registration_no" => "required",
                  "dti_sec_cda_registration_date" => "required",
                  "ctc_no" => "required",
                  "business_tin" => "required",
                  "business_area" => "required",
                  "no_male_employee" => "required|integer",
                  "no_female_employee" =>"required|integer",
                  "male_residing_in_city" =>"required|integer",
                  "female_residing_in_city" => "required|integer",
                  "capitalization" => "required|integer",
                  "brgy" => "required",
                  "unit_no" => "required",
                  "street_address" => "required",
                  "email" => "required|email:rfc,dns",
                  "mobile_no" => "required|max:10|phone:PH",
                  // "tax_incentive" => "required",
                  //"rep_lastname" => "required",
                  //"rep_firstname" => "required",
                  // "rep_middlename" => "required",
                  //"rep_gender" => "required",
                  //"rep_position" => "required",
                  //"rep_tin" => "required",
                  //"website_url" => "url|nullable",
                  //"lessor_fullname" => "required",
                  //"lessor_gender" => "required",
                  //"lessor_monthly_rental" => "required",
                  //"lessor_rental_date" => "required",
                  //"lessor_mobile_no" => "required|max:10|phone:PH",
                  // "lessor_tel_no" => "integer",
                  //"lessor_email" => "email:rfc,dns",
                  //"lessor_unit_no" => "required",
                  //"lessor_street_address" => "required",
                  //"lessor_brgy_name" => "required",
                  //"lessor_region_name" => "required",
                  //"lessor_town_name" => "required",
                  //"lessor_zipcode" => "required",
                  // "emergency_contact_fullname" => "required",
                  //"emergency_contact_mobile_no" => "max:10|phone:PH|nullable",
                  // "emergency_contact_tel_no" => "integer",
                  //"emergency_contact_email" => "email:rfc,dns|nullable",
                  // "telephone_no" => "required|integer",
                  // "tin_no" => "integer",
                  // "sss_no" => "integer",
                  // "philhealth_no" => "integer",
                  // "pagibig_no" => "integer",
                  "valid_business" => 'bnn',

		];


		return $rules;

	}

	public function messages(){
		return [
            'required'	=> "Field is required.",
            'business_id_no.unique' => "Sorry, please re-check your BID. This BID is already taken. If you believe you did not register this BID, please contact the BPLO.",
            'integer' => "Invalid Data.",
            'bnn' => "BNN not Found",
		];

	}
}
