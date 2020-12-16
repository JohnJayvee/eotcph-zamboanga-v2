<?php

namespace App\Laravel\Controllers\System;

/*
 * Request Validator
 */
use App\Laravel\Models\Customer;
use App\Laravel\Models\Department;
/*
 * Models
 */
use App\Laravel\Models\Application;
use Carbon,Auth,DB,Str,Helper,Event;
use App\Laravel\Requests\PageRequest;
use App\Laravel\Models\CollectionOfFees;
use App\Laravel\Models\ApplicationRequirements;
/* App Classes
 */
use App\Laravel\Requests\System\ApplicationRequest;
use App\Laravel\Requests\System\CollectionFeeRequest;
use App\Laravel\Events\SendCustomerRegistractionActive;
use App\Laravel\Events\SendCustomerRegistractionDecline;
use App\Laravel\Events\SendCustomerRegistractionActiveEmail;
use App\Laravel\Events\SendCustomerRegistractionDeclinedEmail;
use App\Laravel\Models\CustomerFile;

class BPLOController extends Controller
{
    protected $data;
	protected $per_page;

	public function __construct(){
		parent::__construct();
		array_merge($this->data, parent::get_data());
		$this->data['department'] = ['' => "All Department"] + Department::pluck('name','id')->toArray();
		$this->data['requirements'] =  ApplicationRequirements::pluck('name','id')->toArray();
		$this->per_page = env("DEFAULT_PER_PAGE",10);
	}

	public function  index(PageRequest $request){
		$this->data['page_title'] = "Registrants";
		$auth = Auth::user();

        $this->data['customer'] = Customer::all()->paginate($this->per_page);
        // dd($this->data);
		return view('system.bplo.index',$this->data);
	}

	public function  create(PageRequest $request){
		$this->data['page_title'] .= "Application - Add new record";
		return view('system.collection-of-fees.create',$this->data);
	}
	public function store(CollectionFeeRequest $request){
		// DB::beginTransaction();
		// try{
        //     $new_collection = CollectionOfFees::create($request->all());
		// 	DB::commit();
		// 	session()->flash('notification-status', "success");
		// 	session()->flash('notification-msg', "New Collection Fee has been added.");
		// 	return redirect()->route('system.collection_fees.index');
		// }catch(\Exception $e){
		// 	DB::rollback();
		// 	session()->flash('notification-status', "failed");
		// 	session()->flash('notification-msg', "Server Error: Code #{$e->getMessage()}");
		// 	return redirect()->back();
		// }
	}

	public function  edit(PageRequest $request,$id = NULL){
		$this->data['page_title'] .= " - Edit record";
        $this->data['customer'] = $customer = Customer::find($id);
        $this->data['customer_file'] = $customer_file = CustomerFile::where('application_id', $customer->id)->get();
        // dd($this->data);
		return view('system.bplo.edit',$this->data);
	}

	public function update(PageRequest $request,$id = NULL){
		DB::beginTransaction();
		try{
            $update_customer = Customer::find($id);
            $update_customer->status = $request->status;
            $update_customer->save();
            DB::commit();

        $insert[] = [
            'contact_number' => $request->contact_number,
            'email' => $update_customer->email,
            'name' => $update_customer->name,
        ];

        if($request->status == 'approved'){

            // via SMS
            // $notification_data = new SendCustomerRegistractionActive($insert);
            // Event::dispatch('send-customer-registration-active', $notification_data);

            // via Email
            $notification_data = new SendCustomerRegistractionActiveEmail($insert);
            Event::dispatch('send-customer-registration-active-email', $notification_data);
        } else {

            //  via SMS
            // $notification_data = new SendCustomerRegistractionDecline($insert);
            // Event::dispatch('send-customer-registration-declined', $notification_data);

            // via Email
            $notification_data = new SendCustomerRegistractionDeclinedEmail($insert);
            Event::dispatch('send-customer-registration-declined-email', $notification_data);
        }

        session()->flash('notification-status', "success");
        session()->flash('notification-msg', "Registrant has been.".$request->status);
        return redirect()->route('system.bplo.index');

		}catch(\Exception $e){
        DB::rollback();
        session()->flash('notification-status', "failed");
        session()->flash('notification-msg', "Server Error: Code #{$e->getMessage()}");
        return redirect()->back();
		}
	}



	public function  destroy(PageRequest $request,$id = NULL){
		DB::beginTransaction();
		try{
			Customer::find($id)->delete();
			DB::commit();
			session()->flash('notification-status', "success");
			session()->flash('notification-msg', "Collection removed successfully.");
			return redirect()->route('system.bplo.index');
		}catch(\Exception $e){
			DB::rollback();
			session()->flash('notification-status', "failed");
			session()->flash('notification-msg', "Server Error: Code #{$e->getMessage()}");
			return redirect()->back();
		}
	}
}
