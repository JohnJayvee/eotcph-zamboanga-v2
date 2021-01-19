<?php namespace App\Laravel\Requests\System;

use Session,Auth;
use App\Laravel\Requests\RequestManager;

class TransactionUpdateRequest extends RequestManager{

	public function rules(){
		$rules = [
			'transaction.business_name' => "required",
			'business_info.business_id_no' => "required",
			'business_info.tradename' => "required",
			'business_info.dti_sec_cda_registration_no' => "required",
			'business_info.dominant_name' => "required",
			'business_info.ctc_no' => "required",
			'business_info.business_tin' => "required",
			'business_info.email' => "required",
			'business_info.business_type' => "required",
			'business_info.business_scope' => "required",
			'business_info.mobile_no' => "required",
			'business_info.unit_no' => "required",
			'business_info.street_address' => "required",
			'business_info.brgy' => "required",
			'business_info.no_of_male_employee' => "required",
			'business_info.no_of_female_employee' => "required",
			'business_info.female_residing_in_city' => "required",
			'business_info.male_residing_in_city' => "required",
			'business_info.business_area' => "required",
			'business_info.capitalization' => "required",
		];

		return $rules;
	}

	public function messages(){
		return [
			'required'	=> "Field is required.",
		];
	}
}
