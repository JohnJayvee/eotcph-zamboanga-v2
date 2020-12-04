<?php namespace App\Laravel\Requests\Web;

use Session,Auth;
use App\Laravel\Requests\RequestManager;

class EditBusinessRequest extends RequestManager{

	public function rules(){

		$rules = [
			'email' => "required",
			'mobile_no' => "required",
			'no_male_employee' => "required|integer",
            'no_female_employee' => "required|integer",
            'male_residing_in_city' => "required|integer",
            'female_residing_in_city' => "required|integer",
            'capitalization' => "required|integer",
            'business_line' => "required",
		];


		return $rules;

	}

	public function messages(){
		return [
			'required'	=> "Field is required.",
            'integer' => "Invalid Data.",
		];

	}
}
