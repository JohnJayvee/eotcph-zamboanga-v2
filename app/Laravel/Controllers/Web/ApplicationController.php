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
use App\Laravel\Models\Application;
use App\Laravel\Models\BusinessActivity;
use Carbon,Auth,DB,Str,ImageUploader,Event,Session;

class ApplicationController extends Controller{

	protected $data;

	public function __construct(){
		parent::__construct();
		$this->data['permit_types'] =  Application::where('type',"business")->pluck('name', 'id')->toArray();
    }

    public function create(){

        $business_id = session()->get('selected_business_id');
        $this->data['page_title'] = "Choose Application";
        $this->data['profile'] = Business::find(session()->get('selected_business_id'));
        if (Auth::guard('customer')->user()) {
			$this->data['auth'] = Auth::guard('customer')->user();
            $this->data['business_profiles'] = Business::where('customer_id',$this->data['auth']->id)->get();
		}
		return view('web.application.create',$this->data);
    }


    public function store(PageRequest $request){
        $business_id = session()->get('selected_business_id');


    	$application = Application::find($request->get('application_type'));
        session()->put('application.transaction_type',$request->transaction_type);
		session()->put('application.current_progress',1);
		session()->put('application.type',$application->permit_type);
        session()->put('application_name',$application->name);

        // $application_business_permit = ApplicationBusinessPermit::where('business_id', $business_id)->where('status', 'pending')->first();
        // if($application_business_permit->status == 'pending'){
        //     session()->flash('notification-status',"warning");
        //     session()->flash('notification-msg',"You have a pending Application");
        //     return redirect()->back();
        // }
		switch($application->permit_type){
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
            	if($application->permit_type != 'business_permit'){
					session()->flash('notification-status',"warning");
					session()->flash('notification-msg',"Application not yet active. Please try again later.");
					return redirect()->back();
				}
				return redirect()->route("web.business.application.{$application->permit_type}.create");
			break;
		}

	}

}
