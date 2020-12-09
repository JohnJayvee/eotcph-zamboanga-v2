<?php namespace App\Laravel\Requests\System;

use Session,Auth;
use App\Laravel\Requests\RequestManager;

class CollectionFeeRequest extends RequestManager{

	public function rules(){

		$rules = [
			'collection_name' => "required",
		];

		return $rules;
	}

	public function messages(){
		return [
            'required'	=> "Field is required.",
            'collection_name.required' => "specify a name of this new collection",
			'numeric' => "Please input a valid amount.",
			'min' => "Minimum amount is 0.",
			'integer' => "Invalid data. Please provide a valid input.",
		];
	}
}
