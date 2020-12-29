<?php

namespace App\Laravel\Controllers\System;

/*
 * Request Validator
 */
use App\Laravel\Requests\PageRequest;

/*
 * Models
 */
use App\Laravel\Requests\System\BPLORequest;
use App\Laravel\Events\SendEmailApprovedBusiness;
use App\Laravel\Models\{BusinessTransaction,Department,RegionalOffice,Application, ApplicationBusinessPermit, ApplicationRequirements, BusinessActivity, TransactionRequirements,CollectionOfFees,ApplicationBusinessPermitFile,RegulatoryFee};




use App\Laravel\Requests\System\TransactionCollectionRequest;
/* App Classes
 */
use Carbon,Auth,DB,Str,ImageUploader,Helper,Event,FileUploader,Curl;

class BusinessTransactionController extends Controller
{
    protected $data;
	protected $per_page;

	public function __construct(){
		parent::__construct();
		array_merge($this->data, parent::get_data());

		$this->data['regional_offices'] = ['' => "Choose Regional Offices"] + RegionalOffice::pluck('name', 'id')->toArray();
		$this->data['requirements'] =  ApplicationRequirements::pluck('name','id')->toArray();
		$this->data['status'] = ['' => "Choose Payment Status",'PAID' => "Paid" , 'UNPAID' => "Unpaid"];
		$this->data['approval'] = ['' => "Choose Approval Type",'1' => "Yes" , '0' => "No"];
		$this->data['fees'] =  ['' => "Choose Collection Fees"] + CollectionOfFees::pluck('collection_name','id')->toArray();
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
		$this->data['selected_bplo_approval'] = $request->get('bplo_approval');
		$this->data['selected_processing_fee_status'] = $request->get('processing_fee_status');
		$this->data['keyword'] = Str::lower($request->get('keyword'));
		$this->data['applications'] = ['' => "Choose Applications"] + Application::where('department_id',$request->get('department_id'))->where('type',"business")->pluck('name', 'id')->toArray();

		$this->data['transactions'] = BusinessTransaction::with('application_permit')->where('status',"PENDING")->where('is_resent',0)->whereHas('application_permit',function($query){
				if(strlen($this->data['keyword']) > 0){
					return $query->WhereRaw("LOWER(business_name)  LIKE  '%{$this->data['keyword']}%'")
							->orWhereRaw("LOWER(code) LIKE  '%{$this->data['keyword']}%'")
							->orWhereRaw("LOWER(application_no) LIKE  '%{$this->data['keyword']}%'");
					}
				})
				->where(function($query){
					if(strlen($this->data['selected_application_id']) > 0){
						return $query->where('application_id',$this->data['selected_application_id']);
					}

				})
				->where(function($query){
					if(strlen($this->data['selected_processing_fee_status']) > 0){
						return $query->where('payment_status',$this->data['selected_processing_fee_status']);
					}
				})
				->where(function($query){
					if(strlen($this->data['selected_bplo_approval']) > 0){
						return $query->where('for_bplo_approval',$this->data['selected_bplo_approval']);
					}
				})
				->where(function($query){
					if ($this->data['auth']->type == "processor") {
						return $query->where('is_validated',"1");
					}
				})
				->where(DB::raw("DATE(created_at)"),'>=',$this->data['start_date'])
				->where(DB::raw("DATE(created_at)"),'<=',$this->data['end_date'])
				->orderBy('created_at',"DESC")->paginate($this->per_page);

		return view('system.business-transaction.pending',$this->data);
	}

	public function  approved(PageRequest $request){
		$this->data['page_title'] = "Approved Business Transactions";

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

		$this->data['applications'] = ['' => "Choose Applications"] + Application::where('department_id',$request->get('department_id'))->where('type',"business")->pluck('name', 'id')->toArray();

		$this->data['transactions'] = BusinessTransaction::where('status',"APPROVED")->where(function($query){
				if(strlen($this->data['keyword']) > 0){
					return $query->WhereRaw("LOWER(business_name)  LIKE  '%{$this->data['keyword']}%'")
							->orWhereRaw("LOWER(code) LIKE  '%{$this->data['keyword']}%'");
					}
				})
				->where(function($query){
					if(strlen($this->data['selected_application_id']) > 0){
						return $query->where('application_id',$this->data['selected_application_id']);
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

		return view('system.business-transaction.approved',$this->data);
	}
	public function  declined(PageRequest $request){
		$this->data['page_title'] = "Declined Business Transactions";

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

		$this->data['applications'] = ['' => "Choose Applications"] + Application::where('department_id',$request->get('department_id'))->where('type',"business")->pluck('name', 'id')->toArray();

		$this->data['transactions'] = BusinessTransaction::where('status',"DECLINED")->where(function($query){
				if(strlen($this->data['keyword']) > 0){
					return $query->WhereRaw("LOWER(business_name)  LIKE  '%{$this->data['keyword']}%'")
							->orWhereRaw("LOWER(code) LIKE  '%{$this->data['keyword']}%'");
					}
				})
				->where(function($query){
					if(strlen($this->data['selected_application_id']) > 0){
						return $query->where('application_id',$this->data['selected_application_id']);
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

		return view('system.business-transaction.approved',$this->data);
	}
	public function show(PageRequest $request,$id=NULL){
		$this->data['count_file'] = TransactionRequirements::where('transaction_id',$id)->count();
		$this->data['attachments'] = TransactionRequirements::where('transaction_id',$id)->get();
		$this->data['transaction'] = $request->get('business_transaction_data');
        $requirements_id = $this->data['transaction']->requirements_id;

        $this->data['business_line'] = BusinessActivity::where('application_business_permit_id', $this->data['transaction']->business_permit_id)->get();
        $this->data['app_business_permit_file'] = ApplicationBusinessPermitFile::where('application_business_permit_id', $request->id)->get();
		$this->data['app_business_permit'] = ApplicationBusinessPermit::find($request->id)->get();

		$this->data['physical_requirements'] = ApplicationRequirements::whereIn('id',explode(",", $requirements_id))->get();

		$this->data['department'] =  Department::pluck('name','id')->toArray();
		$this->data['regulatory_fee'] = RegulatoryFee::where('transaction_id',$id)->get();

		$this->data['page_title'] = "Transaction Details";
		return view('system.business-transaction.show',$this->data);
	}

	/*public function bplo_approved (BPLORequest $request ){
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
	}*/

	public function process($id = NULL,PageRequest $request){
		$type = strtoupper($request->get('status_type'));
		DB::beginTransaction();
		try{
			$total_amount = RegulatoryFee::where('transaction_id',$id)->sum('total_amount');
			$transaction = $request->get('business_transaction_data');
			$transaction->status = $type;
			$transaction->remarks = $type == "DECLINED" ? $request->get('remarks') : NULL;
			$transaction->processor_user_id = Auth::user()->id;
			$transaction->status = $type;
			$transaction->modified_at = Carbon::now();
			$transaction->total_amount = $total_amount;
			$transaction->save();
			if ($type == "APPROVED") {
				$insert[] = [
	            	'contact_number' => $transaction->owner ? $transaction->owner->contact_number : $transaction->contact_number,
	            	'email' => $transaction->owner ? $transaction->owner->email : $transaction->email,
	                'amount' => $transaction->total_amount,
	                'ref_num' => $transaction->code,
	                'full_name' => $transaction->owner ? $transaction->owner->full_name : $transaction->business_name,
	                'application_name' => $transaction->application_name,
	                'modified_at' => Helper::date_only($transaction->modified_at)
            	];
			    $notification_data_email = new SendEmailApprovedBusiness($insert);
			    Event::dispatch('send-email-business-approved', $notification_data_email);
			}
			DB::commit();
			session()->flash('notification-status', "success");
			session()->flash('notification-msg', "Transaction has been successfully Processed.");
			return redirect()->route('system.business_transaction.'.strtolower($type));
		}catch(\Exception $e){
			DB::rollback();
			session()->flash('notification-status', "failed");
			session()->flash('notification-msg', "Server Error: Code #{$e->getLine()}");
			return redirect()->back();
		}
	}

	public function save_collection (TransactionCollectionRequest $request){
		$transaction_id = $request->get('transaction_id');
		DB::beginTransaction();

		try{
			$business_transaction = BusinessTransaction::find($transaction_id);
			$business_transaction->collection_id = $request->get('collection_id');
			$business_transaction->save();

			DB::commit();
			session()->flash('notification-status', "success");
			session()->flash('notification-msg', "Collection Breakdown has been saved.");
			return redirect()->route('system.business_transaction.show',[$transaction_id]);
		}catch(\Exception $e){
			DB::rollback();
			session()->flash('notification-status', "failed");
			session()->flash('notification-msg', "Server Error: Code #{$e->getLine()}");
			return redirect()->back();
		}
	}

	public function remarks($id = NULL,PageRequest $request){
		DB::beginTransaction();
			$transaction = $request->get('business_transaction_data');
			$auth = Auth::user();
			$array_remarks = [];
			$dept_id = [];
	 		$value = $request->get('value');


	 		if ($transaction->department_remarks) {
	 			array_push($array_remarks, ['processor_id' => $auth->id ,'id' => $auth->department->code , 'remarks' => $value]);
	 			$existing = json_decode($transaction->department_remarks);
	 			$existing_id = json_decode($transaction->department_id);

	 			if ($transaction->department_id) {
	 				$a = array_search($auth->department->code, $existing_id);
	 				if ($a !== false) {
	 					$dept_id_final = $existing_id;
		 			}else{
		 				array_push($dept_id, $auth->department->code);
		 				$dept_id_final = array_merge($existing_id , $dept_id);
		 			}
	 			}else{
	 				array_push($dept_id, $auth->department->code);
	 				$dept_id_final = $dept_id;
	 			}


	 			$final_value = array_merge($existing , $array_remarks);
	 		}else{
	 			 array_push($array_remarks, ['processor_id' => $auth->id,'id' => $auth->department->code , 'remarks' => $value]);

	 			 array_push($dept_id, $auth->department->code);

	 			 $dept_id_final = $dept_id;
	 			 $final_value = $array_remarks;
	 		}
	 		$transaction->department_id = json_encode($dept_id_final);
			$transaction->department_remarks = json_encode($final_value);
			$transaction->save();

			$it_1 = json_decode($transaction->department_involved, TRUE);
		    $it_2 = json_decode($transaction->department_id, TRUE);
		    $result_array = array_diff($it_1,$it_2);

		    if(empty($result_array)){
		    	$transaction->for_bplo_approval = 1;
		    	$transaction->save();
		    }

			DB::commit();
			session()->flash('notification-status', "success");
			session()->flash('notification-msg', "Application Remarks has been saved.");
			return redirect()->route('system.business_transaction.show',[$transaction->id]);
	}

	public function bplo_validate($id = NULL , PageRequest $request){

		DB::beginTransaction();
		try{
			$dept_code_array = explode(",", $request->get('department_code'));

			foreach ($dept_code_array as $data) {
				$department = Department::where('code',$data)->first();
				if (!$department) {
					session()->flash('notification-status', "failed");
					session()->flash('notification-msg', "No Department Found.");
					return redirect()->route('system.business_transaction.show',[$id]);
				}
			}

			$transaction = $request->get('business_transaction_data');

			$transaction->department_involved = json_encode(explode(",",$request->get('department_code')));
			$transaction->is_validated = 1;
			$transaction->save();

			DB::commit();
			session()->flash('notification-status', "success");
			session()->flash('notification-msg', "Office Code has been saved.");
			return redirect()->route('system.business_transaction.pending');

		}catch(\Exception $e){
			DB::rollback();
			session()->flash('notification-status', "failed");
			session()->flash('notification-msg', "Server Error: Code #{$e->getLine()}");
			return redirect()->back();
		}
	}

	public function assessment (PageRequest $request , $id = NULL){
		$auth = Auth::user();
		$this->data['page_title'] .= " - Assesment Details";
		$this->data['transaction'] = BusinessTransaction::find($id);

		$this->data['regulatory_fee'] = RegulatoryFee::where('transaction_id',$id)->where('office_code',$auth->department->code)->first();
		if ($this->data['regulatory_fee']) {
			$this->data['breakdown_collection'] = json_decode($this->data['regulatory_fee']->collection_of_fees);
		}
		return view('system.business-transaction.assessment',$this->data);
	}

	public function get_assessment(PageRequest $request , $id = NULL){
		DB::beginTransaction();
		try{
			$auth = Auth::user();
			$this->data['transaction'] = BusinessTransaction::find($id);

			$request_body = [
				'business_id' => $request->get('business_id'),
				'ebriu_application_no' => $request->get('application_no'),
				'year' => "2021",
				'office_code' => $request->get('office_code'),
			];
			$response = Curl::to(env('ZAMBOANGA_URL'))
			         ->withData($request_body)
			         ->asJson( true )
			         ->returnResponseObject()
			         ->post();
			if ($response->content['data'] == NULL) {
				session()->flash('notification-status', "failed");
				session()->flash('notification-msg', "No Assesment Found.");
				return redirect()->route('system.business_transaction.assessment',[$id]);
			}
			$total_amount = 0 ;
			foreach ($response->content['data'] as $key => $value) {
				$total_amount += $value['Amount'];
			}

			$existing = RegulatoryFee::where('transaction_id' ,$this->data['transaction']->id)->where('office_code',$request->get('office_code'))->first();

			if ($existing) {
				$existing->collection_of_fees = json_encode($response->content['data']);
				$existing->total_amount = Helper::money_format($total_amount);
				$existing->save();
			}else{
				$new_regulatory_fee = new RegulatoryFee();
				$new_regulatory_fee->business_id = $this->data['transaction']->business_id;
				$new_regulatory_fee->transaction_id =$this->data['transaction']->id;
				$new_regulatory_fee->collection_of_fees = json_encode($response->content['data']);
				$new_regulatory_fee->total_amount = Helper::money_format($total_amount);
				$new_regulatory_fee->status = "PENDING";
				$new_regulatory_fee->office_code = $request->get('office_code');
				$new_regulatory_fee->save();
			}

			DB::commit();
			session()->flash('notification-status', "success");
			session()->flash('notification-msg', "Record Found.");
			return redirect()->route('system.business_transaction.assessment',$id);
		}catch(\Exception $e){
			DB::rollback();
			session()->flash('notification-status', "failed");
			session()->flash('notification-msg', "Server Error: Code #{$e->getLine()}");
			return redirect()->back();
		}
	}

	public function approved_assessment(PageRequest $request , $id = NULL){
		DB::beginTransaction();
		try{
			$auth = Auth::user();
			$regulatory_fee = RegulatoryFee::where('transaction_id',$id)->where('office_code',$auth->department->code)->first();
			$regulatory_fee->status = "APPROVED";
			$regulatory_fee->save();
			DB::commit();
			session()->flash('notification-status', "success");
			session()->flash('notification-msg', "Assesment has been successfully approved.");
			return redirect()->route('system.business_transaction.assessment',$id);
		}catch(\Exception $e){
			DB::rollback();
			session()->flash('notification-status', "failed");
			session()->flash('notification-msg', "Server Error: Code #{$e->getLine()}");
			return redirect()->back();
		}
	}
}
