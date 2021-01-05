<?php namespace App\Laravel\Requests\Web;

use Session,Auth;
use App\Laravel\Requests\RequestManager;

class RegisterRequest extends RequestManager{

	public function rules(){

		$id = $this->route('id')?:0;
		$rules = [
			'fname' => "required",
			'lname' => "required",
			'gender' => "required",
			// 'region' => "required",
			// 'town' => "required",
			'brgy' => "required",
			'street_name' => "required",
			'unit_number' => "required",
			'zipcode' => "required",
			'birthdate' => "required",
			'contact_number' => "required|max:10|phone:PH",
			'email'	=> "required|unique:customer,email,{$id}",
            'password'	=> "required|password_format|confirmed",
            'file' => 'required',
            'file.*' => 'mimes:jpeg,jpg,png,JPEG,PNG|max:5000',
		];

		return $rules;
	}

	public function messages(){
		return [
			'required'	=> "Field is required.",
			'contact_number.phone' => "Please provide a valid PH mobile number.",
            'password_format' => "Password must be 6-20 alphanumeric and some allowed special characters only.",
            'file.mimes' => "Invalid File",
            'max' => 'This file is greater than allowed file size.',
            'file.required' => "Field is required.",
		];
	}
}
