<?php

namespace App\Laravel\Controllers\System;

/*
 * Request Validator
 */
use App\Laravel\Requests\PageRequest;

/*
 * Models
 */
use App\Laravel\Models\{BusinessTransaction,Department,RegionalOffice,Application,ApplicationRequirements,TransactionRequirements,CollectionOfFees};
use App\Laravel\Requests\System\BPLORequest;


use App\Laravel\Events\SendApprovedReference;
use App\Laravel\Events\SendDeclinedReference;

use App\Laravel\Events\SendProcessorTransaction;
use App\Laravel\Events\SendEmailProcessorTransaction;

use App\Laravel\Events\SendDeclinedEmailReference;
use App\Laravel\Events\SendApprovedEmailReference;
/* App Classes
 */
use Carbon,Auth,DB,Str,ImageUploader,Helper,Event,FileUploader;

class BusinessTransactionController extends Controller
{
    protected $data;
	protected $per_page;
	
	public function __construct(){
		parent::__construct();
		array_merge($this->data, parent::get_data());
		if (Auth::user()) {
			if (Auth::user()->type == "super_user" || Auth::user()->type == "admin") {
				$this->data['department'] = ['' => "Choose Department"] + Department::pluck('name', 'id')->toArray();
			}elseif (Auth::user()->type == "office_head" || Auth::user()->type == "processor") {
				$this->data['department'] = ['' => "Choose Department"] + Department::where('id',Auth::user()->department_id)->pluck('name', 'id')->toArray();
			}
		}else{
			$this->data['department'] = ['' => "Choose Department"] + Department::pluck('name', 'id')->toArray();
		}
		

		$this->data['regional_offices'] = ['' => "Choose Regional Offices"] + RegionalOffice::pluck('name', 'id')->toArray();
		$this->data['requirements'] =  ApplicationRequirements::pluck('name','id')->toArray();
		$this->data['status'] = ['' => "Choose Payment Status",'PAID' => "Paid" , 'UNPAID' => "Unpaid"];
		

		$this->per_page = env("DEFAULT_PER_PAGE",2);
	}

	public function  index(PageRequest $request){
		$this->data['page_title'] = "Business Transactions";
		$this->data['business_transactions'] = BusinessTransaction::orderBy('created_at',"DESC")->get(); 
		return view('system.business-transaction.index',$this->data);
	}

	public function  pending(PageRequest $request){
		$this->data['page_title'] = "Pending Business Transactions";

		$auth = Auth::user();
		$this->data['auth'] = Auth::user();

		$first_record = BusinessTransaction::orderBy('created_at','ASC')->first();
		$start_date = $request->get('start_date',Carbon::now()->startOfMonth());

		if($first_record){
			$start_date = $request->get('start_date',$first_record->created_at->format("Y-m-d"));
		}
		$this->data['start_date'] = Carbon::parse($start_date)->format("Y-m-d");
		$this->data['end_date'] = Carbon::parse($request->get('end_date',Carbon::now()))->format("Y-m-d");

		

		$this->data['selected_application_id'] = $request->get('application_id');
		$this->data['selected_processing_fee_status'] = $request->get('processing_fee_status');
		$this->data['keyword'] = Str::lower($request->get('keyword'));
		
		if ($auth->type == "office_head") {
			$this->data['applications'] = ['' => "Choose Applications"] + Application::where('department_id',$auth->department_id)->pluck('name', 'id')->toArray();
		}elseif ($auth->type == "processor") {
			$this->data['applications'] = ['' => "Choose Applications"] + Application::whereIn('id',explode(",", $auth->application_id))->pluck('name', 'id')->toArray();
		}else{
			$this->data['applications'] = ['' => "Choose Applications"] + Application::where('department_id',$request->get('department_id'))->pluck('name', 'id')->toArray();
		}

		$this->data['transactions'] = BusinessTransaction::where('status',"PENDING")->where('is_resent',0)->where(function($query){
				if(strlen($this->data['keyword']) > 0){
					return $query->WhereRaw("LOWER(business_name)  LIKE  '%{$this->data['keyword']}%'")
							->orWhereRaw("LOWER(code) LIKE  '%{$this->data['keyword']}%'");
					}
				})
				->where(function($query){
					if ($this->data['auth']->type == "processor") {
						if(strlen($this->data['selected_application_id']) > 0){
							return $query->where('application_id',$this->data['selected_application_id']);
						}else{
							return $query->whereIn('application_id',explode(",", $this->data['auth']->application_id));
						}
						
					}else{
						if(strlen($this->data['selected_application_id']) > 0){
							return $query->where('application_id',$this->data['selected_application_id']);
						}
					}
					
				})
				->where(function($query){
					if(strlen($this->data['selected_processing_fee_status']) > 0){
						return $query->where('payment_status',$this->data['selected_processing_fee_status']);
					}
				})
				->where(DB::raw("DATE(created_at)"),'>=',$this->data['start_date'])
				->where(DB::raw("DATE(created_at)"),'<=',$this->data['end_date'])
				->orderBy('created_at',"DESC")->paginate($this->per_page);

		return view('system.business-transaction.pending',$this->data);
	}


	public function show(PageRequest $request,$id=NULL){
		$this->data['count_file'] = TransactionRequirements::where('transaction_id',$id)->count();
		$this->data['attachments'] = TransactionRequirements::where('transaction_id',$id)->get();
		$this->data['transaction'] = $request->get('business_transaction_data');
		$id = $this->data['transaction']->requirements_id;
		$this->data['physical_requirements'] = ApplicationRequirements::whereIn('id',explode(",", $id))->get();
		$collection_id = Application::find($this->data['transaction']->application_id);
		$this->data['department'] =  Department::pluck('name','id')->toArray();
		$this->data['breakdown_collection'] = CollectionOfFees::find($collection_id->collection_id);
		$this->data['page_title'] = "Transaction Details";
		return view('system.business-transaction.show',$this->data);
	}

	public function bplo_approved (BPLORequest $request ){
		DB::beginTransaction();
		try{
			$transaction_id = $request->get('transaction_id');

			$transaction = BusinessTransaction::find($transaction_id);

			$transaction->department_destination = implode(",", $request->get('department_id'));
			$transaction->save();

			DB::commit();
			session()->flash('notification-status', "success");
			session()->flash('notification-msg', "Application had been modified.");
			return redirect()->route('system.business_transaction.pending');
		}catch(\Exception $e){
			DB::rollback();
			session()->flash('notification-status', "failed");
			session()->flash('notification-msg', "Server Error: Code #{$e->getLine()}");
			return redirect()->back();
		}
	}
}
