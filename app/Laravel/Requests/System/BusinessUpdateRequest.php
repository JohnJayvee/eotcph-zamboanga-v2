<?php namespace App\Laravel\Requests\System;

use Session,Auth;
use App\Laravel\Requests\RequestManager;

class BusinessUpdaterequest extends RequestManager{

	public function rules(){
		$id = $this->route('id')?:0;
		
		$rules = [
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
		];

		return $rules;
	}

	public function messages(){
		return [
			'required'	=> "Field is required.",
			'name.unique'	=> "The Department name is already exist.",
		];
	}
}