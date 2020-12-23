<?php namespace App\Laravel\Requests\Web;

use Session,Auth;
use App\Laravel\Requests\RequestManager;

class BusinessPermitRequest extends RequestManager{

	public function rules(){

		$id = $this->route('id')?:0;
		$file = $this->file('file') ? count($this->file('file')) : 0;

		$rules = [
            'line_of_business.*' => 'required',
            'no_of_units.*' => 'required|integer',
            'file' => 'required',
            'file.*' => 'mimes:png,jpg,jpeg,pdf',
            'agree' => 'required',
        ];

        if ($this->get('type_of_application') == "new") {
			$rules['capitalization.*'] = "required|integer";
		}
		if ($this->get('type_of_application') == "renew") {
            $rules['renew.*'] = "required|integer";
		}
		return $rules;

	}

	public function messages(){
		return [
            'file.*'	=> "Field is required.",
            'file.mimes' => "Invalid File",
            'no_of_units.*' => "No. of Unit is required",
            'capitalization.*' => "Capitalization is required",
            'renew.*' => "Gross is required",
		];

	}
}
