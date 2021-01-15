<?php namespace App\Laravel\Requests\Web;

use Session,Auth;
use App\Laravel\Requests\RequestManager;

class BusinessPermitRequest extends RequestManager{

	public function rules(){

		$id = $this->route('id')?:0;
		

		$rules = [
            'line_of_business.*' => 'required',
            // 'no_of_units' => 'required',
            //'no_of_units.*' => 'nullable',
            'amount.*' => 'required|numeric',
            'photo_establishment' => 'required|mimes:png,jpg,jpeg,pdf',
            'bir_itr_form' => 'required|mimes:png,jpg,jpeg,pdf',
            'agree' => 'accepted',

        ];  
      
		return $rules;

	}

	public function messages(){
		return [
            'file.*.required'	=> "Field is required.",
            'file.*.mimes' => "Invalid File",
            // 'no_of_units.*' => "No. of Unit is required",
            'amount.*' => "Gross sales is required",
            'capitalization.*' => "Capitalization is required",
            'renew.*' => "Gross is required",
            'agree.accepted' => "Please Agree Under Penalty Of Perjuary "
		];

	}
}
