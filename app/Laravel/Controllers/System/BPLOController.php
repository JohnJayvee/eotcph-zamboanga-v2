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
use App\Laravel\Models\CustomerFile;
use Carbon,Auth,DB,Str,Helper,Event;
use App\Laravel\Requests\PageRequest;
use App\Laravel\Models\CollectionOfFees;
/* App Classes
 */
use App\Laravel\Models\ApplicationRequirements;
use App\Laravel\Requests\System\BPLOUpdateRequest;
use App\Laravel\Requests\System\ApplicationRequest;
use App\Laravel\Requests\System\CollectionFeeRequest;
use App\Laravel\Events\SendCustomerRegistractionActive;
use App\Laravel\Events\SendCustomerRegistractionDecline;
use App\Laravel\Events\SendCustomerRegistractionActiveEmail;
use App\Laravel\Events\SendCustomerRegistractionDeclinedEmail;

class BPLOController extends Controller
{
    protected $data;
	protected $per_page;

	public function __construct(){
		parent::__construct();
		array_merge($this->data, parent::get_data());
		$this->data['department'] = ['' => "All Department"] + Department::pluck('name','id')->toArray();
		$this->data['requirements'] =  ApplicationRequirements::pluck('name','id')->toArray();
		$this->data['status_type'] = ['' => "Choose Status",'approved' => "Approved" ,'pending' => "Pending", 'declined' => "Decline"];
		$this->data['verified'] = ['' => "Choose Status",'1' => "Yes" , '0' => "No"];
		$this->per_page = env("DEFAULT_PER_PAGE",10);
	}

	public function  index(PageRequest $request){
		$this->data['page_title'] = "Registrants";
		$auth = Auth::user();
        $first_record = Customer::orderBy('created_at','ASC')->first();
		$start_date = $request->get('start_date',Carbon::now()->startOfMonth());

		if($first_record){
			$start_date = $request->get('start_date',$first_record->created_at ? $first_record->created_at->format("Y-m-d") :  $request->get('start_date',Carbon::now()->startOfMonth()));
        }
        $this->data['start_date'] = Carbon::parse($start_date)->format("Y-m-d");
		$this->data['end_date'] = Carbon::parse($request->get('end_date',Carbon::now()))->format("Y-m-d");
        $this->data['selected_status'] = $request->get('status');
        $this->data['selected_otp_verified'] = $request->get('otp_verified');
		$this->data['selected_processing_fee_status'] = $request->get('processing_fee_status');
		$this->data['keyword'] = Str::lower($request->keyword);
        $this->data['customer'] = Customer::where(function($query){
            if(strlen($this->data['keyword']) > 0){
                return $query->WhereRaw("LOWER(concat(fname,' ',lname))  LIKE  '%{$this->data['keyword']}%'");
                }
            })
            ->where(function($query){
                if(strlen($this->data['selected_status']) > 0){
                    return $query->where('status',$this->data['selected_status']);
                }
            })
            ->where(function($query){
                if(strlen($this->data['selected_otp_verified']) > 0){
                    return $query->where('otp_verified',$this->data['selected_otp_verified']);
                }
            })
            ->where(DB::raw("DATE(created_at)"),'>=',$this->data['start_date'])
            ->where(DB::raw("DATE(created_at)"),'<=',$this->data['end_date'])
            ->orderBy('created_at',"DESC")->paginate($this->per_page);
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

	public function update(BPLOUpdateRequest $request,$id = NULL){
		DB::beginTransaction();
		try{
            $update_customer = Customer::find($id);
            $update_customer->status = $request->get('status');
            $update_customer->remark = $request->get('remarks');
            $update_customer->otp_verified = 1;
            $update_customer->save();
            DB::commit();

        $insert[] = [
            'contact_number' => $request->contact_number,
            'email' => $update_customer->email,
            'name' => $update_customer->name,
            'remarks' => $update_customer->remark,
        ];

        if($request->status == 'approved'){
            // via SMS
            //$notification_data = new SendCustomerRegistractionActive($insert);
            //Event::dispatch('send-customer-registration-active', $notification_data);

            // via Email
            $notification_data = new SendCustomerRegistractionActiveEmail($insert);
            Event::dispatch('send-customer-registration-active-email', $notification_data);
        } else {

            //  via SMS
            //$notification_data = new SendCustomerRegistractionDecline($insert);
            //Event::dispatch('send-customer-registration-declined', $notification_data);

            // via Email
            $notification_data = new SendCustomerRegistractionDeclinedEmail($insert);
            Event::dispatch('send-customer-registration-declined-email', $notification_data);
        }

        session()->flash('notification-status', "success");
        session()->flash('notification-msg', "Registrant has been ".$request->status.'.');
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
