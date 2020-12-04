<?php

namespace App\Laravel\Controllers\Web;

/*
 * Request Validator
 */

use App\Laravel\Models\Business;
use App\Http\Controllers\Controller;

use Illuminate\Contracts\Auth\Guard;

/*
 * Models
 */
use App\Laravel\Requests\PageRequest;
use App\Laravel\Models\ApplicationBusinessPermit;
use Carbon,Auth,DB,Str,ImageUploader,Event,Session;

class ApplicationController extends Controller{

	protected $data;

	public function __construct(){
		parent::__construct();

    }

    public function create(){
        $this->data['page_title'] = "Choose Application";
        $this->data['profile'] = Business::find(session()->get('selected_business_id'));
        if (Auth::guard('customer')->user()) {
			$this->data['auth'] = Auth::guard('customer')->user();
			$this->data['business_profiles'] = Business::where('customer_id',$this->data['auth']->id)->get();
		}
		return view('web.application.create',$this->data);
    }


    public function store(PageRequest $request){
		// $auth = $request->user();

		$application_type = Str::lower($request->get('application_type'));
		session()->put('application.current_progress',1);
		session()->put('application.type',$application_type);

		switch($application_type){
			// case 'bnrs':
			// case 'business_clearance':
			// case 'business_permit':
			// case 'occupational_permit':
			// case 'bfp_certificate':
			// case 'sanitary_permit':
			// case 'bir_2303':
			// case 'bir_1921':
			// 	if(in_array($application_type, [ "bir_1921"])){
			// 		session()->flash('notification-status',"warning");
			// 		session()->flash('notification-msg',"Application not yet active. Please try again later.");
			// 		return redirect()->back();
			// 	}


			// break;
            default:
            	if($application_type != 'business_permit'){
					session()->flash('notification-status',"warning");
					session()->flash('notification-msg',"Application not yet active. Please try again later.");
					return redirect()->back();
				}
				return redirect()->route("web.business.application.{$application_type}.create");
			break;
		}

	}

}
