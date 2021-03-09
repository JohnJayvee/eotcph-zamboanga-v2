<?php namespace App\Laravel\Requests\System;

use Session,Auth;
use App\Laravel\Requests\RequestManager;

class BlockListRequest extends RequestManager{

	public function rules(){
		$rules = [
			'business_id' => "required",
		];
		return $rules;
	}

	public function messages(){
		return [
			'required'	=> "Field is required.",
		];
	}
}