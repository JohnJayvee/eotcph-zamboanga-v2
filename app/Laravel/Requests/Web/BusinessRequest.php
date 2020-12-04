<?php namespace App\Laravel\Requests\Web;

use Session,Auth;
use App\Laravel\Requests\RequestManager;

class BusinessRequest extends RequestManager{

	public function rules(){

		$id = $this->route('id')?:0;
		$file = $this->file('file') ? count($this->file('file')) : 0;

		$rules = [
			'business_scope' => "required",
			'business_type' => "required",
			'dominant_name' => "required",
			'business_name' => "required",
			'business_line' => "required",
			'capitalization' => "required",
			'region' => "required",
			'town' => "required",
			'brgy' => "required",
			'unit_no' => "required",
			'street_address' => "required",
			'email' => "required",
			'mobile_no' => "required",
			'telephone_no' => "required",

		];


		return $rules;
		
	}

	public function messages(){
		return [
			'required'	=> "Field is required.",

		];

	}
}