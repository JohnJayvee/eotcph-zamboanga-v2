<?php

namespace App\Laravel\Controllers\Web;

/*
 * Request Validator
 */
use App\Laravel\Requests\PageRequest;
use App\Laravel\Requests\Web\TransactionRequest;
use App\Laravel\Requests\Web\UploadRequest;
use App\Laravel\Requests\Web\BusinessRequest;
use App\Laravel\Models\Business;
use App\Laravel\Requests\Web\EditBusinessRequest;
/*
 * Models
 */


use Carbon,Auth,DB,Str,ImageUploader,Event,FileUploader,PDF,QrCode,Helper,Curl,Log;

class BusinessController extends Controller
{
     protected $data;
	protected $per_page;

	public function __construct(){
		parent::__construct();
		array_merge($this->data, parent::get_data());

		$this->data['business_scopes'] = ['national' => "National",'regional' => "Regional",'municipality' => "City/Municipality",'barangay' => "Barangay"];
		$this->data['business_types'] = ['sole_proprietorship' => "Sole Proprietorship",'cooperative' => "Cooperative",'corporation' => "Corporation",'partnership' => "Partnership"];
		$this->data['transaction_types'] = ['new' => "New Business",'renewal' => "Renewal"];
		if (Auth::guard('customer')->user()) {
			$this->data['auth'] = Auth::guard('customer')->user();
			$this->data['business_profiles'] = Business::where('customer_id',$this->data['auth']->id)->get();
		}
		$this->per_page = env("DEFAULT_PER_PAGE",10);
	}


	public function index(PageRequest $request){
		$this->data['page_title'] = "Business Profile";
		$this->data['auth'] = Auth::guard('customer')->user();
		return view('web.business.index',$this->data);
	}
	public function create(){
		$this->data['page_title'] = "Create Business CV";
		$this->data['auth'] = Auth::guard('customer')->user();

		return view('web.business.create',$this->data);

    }

	public function store(BusinessRequest $request){
		$auth = Auth::guard('customer')->user();

		DB::beginTransaction();
		try{
			$new_business = new Business;
			$new_business->customer_id = $auth->id;
			$new_business->business_scope = $request->get('business_scope');
			$new_business->business_type = $request->get('business_type');
			$new_business->dominant_name = $request->get('dominant_name');
			$new_business->business_name = $request->get('business_name');
            $new_business->business_line = $request->get('business_line');

			$new_business->business_id_no = $request->get('business_id_no');
			$new_business->no_of_male_employee = $request->get('no_of_male_employee');
			$new_business->no_of_female_employee = $request->get('no_of_female_employee');
			$new_business->male_residing_in_city = $request->get('male_residing_in_city');
			$new_business->female_residing_in_city = $request->get('female_residing_in_city');

			$new_business->capitalization = $request->get('capitalization');
			$new_business->region_name = $request->get('region_name');
			$new_business->town_name = $request->get('town_name');
			$new_business->region = $request->get('region');
			$new_business->town = $request->get('town');
			$new_business->brgy_name = $request->get('brgy_name');
			$new_business->brgy = $request->get('brgy');
			$new_business->zipcode = $request->get('zipcode');
			$new_business->unit_no = $request->get('unit_no');
			$new_business->street_address = $request->get('street_address');
			$new_business->email = $request->get('email');
			$new_business->website_url = $request->get('website_url');
			$new_business->mobile_no = $request->get('mobile_no');
			$new_business->telephone_no = $request->get('telephone_no');
			$new_business->tin_no = $request->get('tin_no');
			$new_business->sss_no = $request->get('sss_no');
			$new_business->philhealth_no = $request->get('philhealth_no');
			$new_business->pagibig_no = $request->get('pagibig_no');
			$new_business->save();
			DB::commit();
			session()->flash('notification-status', "success");
			session()->flash('notification-msg', "New Bureau/Office has been added.");
			return redirect()->route('web.business.index');
		}catch(\Exception $e){
			DB::rollback();
			session()->flash('notification-status', "failed");
			session()->flash('notification-msg', "Server Error: Code #{$e->getLine()}");
			return redirect()->back();
		}

	}
	public function business_profile(PageRequest $request , $id = NULL){

		$this->data['page_title'] = "Create Business CV";

		$this->data['profile'] = Business::find($id);
        session()->put('selected_business_id', $id);
		return view('web.business.profile',$this->data);
    }

    public function business_edit(){
        $this->data['page_title'] = "Edit Business CV";
		$this->data['auth'] = Auth::guard('customer')->user();
		$this->data['business'] = Business::find(session()->get('selected_business_id'));
		if(!$this->data['business']){
			session()->flash('notification-status',"warning");
			session()->flash('notification-msg',"No CV has been selected");
			return redirect()->route('frontend.business.index');
		}
		return view('web.business.edit',$this->data);
	}

	public function business_update(EditBusinessRequest $request){

        DB::beginTransaction();
		try{
			$business = Business::find(session()->get('selected_business_id'));

            $business->no_of_employee = $request->get('no_of_employee');
            $business->no_of_male_employee = $request->get('no_male_employee');
            $business->no_of_female_employee = $request->get('no_female_employee');
            $business->male_residing_in_city = $request->get('male_residing_in_city');
            $business->female_residing_in_city = $request->get('female_residing_in_city');
            $business->business_line = $request->get('business_line');
            $business->capitalization = $request->get('capitalization');
            $business->website_url = $request->get('website_url');
            $business->email = $request->get('email');
            $business->mobile_no = $request->get('mobile_no');
            $business->telephone_no = $request->get('telephone_no');
            $business->tin_no = $request->get('tin_no');
			$business->sss_no = $request->get('sss_no');
			$business->philhealth_no = $request->get('philhealth_no');
            $business->pagibig_no = $request->get('pagibig_no');

            $business->save();

			DB::commit();
			session()->flash('notification-status',"success");
            session()->flash('notification-msg',"Business information was successfully updated.");
            return redirect()->route('web.business.profile', [session()->get('selected_business_id')]);
		}catch(\Exception $e){
			DB::rollback();
			session()->flash('notification-status', "failed");
			session()->flash('notification-msg', "Server Error: Code #{$e->getMessage()}");
			return redirect()->back();
		}
	}
}
