<?php namespace App\Laravel\Requests\System;

use Session,Auth;
use App\Laravel\Requests\RequestManager;

class BPLOUpdateRequest extends RequestManager{

	public function rules(){

        $rules = [];
        if($this->get('status') == 'declined'){
			$rules['remark'] = "required";
		}
		return $rules;
	}

	public function messages(){
		return [
			'required'	=> "Field is required.",

		];
	}
}
