<?php

namespace App\Laravel\Controllers\System;

/*
 * Request Validator
 */

/*
 * Models
 */


use App\Laravel\Models\{BusinessTransaction,Department,RegionalOffice,Application, ApplicationBusinessPermit, ApplicationRequirements, BusinessActivity, TransactionRequirements,CollectionOfFees,ApplicationBusinessPermitFile,BusinessFee,RegulatoryPayment,User,BusinessTaxPayment,BusinessLine};

use App\Laravel\Requests\PageRequest;
use App\Laravel\Events\NotifyDepartmentSMS;
use App\Laravel\Events\NotifyBPLOAdminEmail;
/* App Classes
 */
use App\Laravel\Requests\System\BPLORequest;
use App\Laravel\Events\NotifyDepartmentEmail;
use App\Laravel\Events\SendEmailDigitalCertificate;
use App\Laravel\Events\SendEmailApprovedBusiness;
use App\Laravel\Events\SendEmailDeclinedBusiness;
use App\Laravel\Events\SendDeclinedEmailReference;
use App\Laravel\Events\UploadLineOfBusinessToLocal;
use App\Laravel\Requests\System\TransactionCollectionRequest;
use App\Laravel\Requests\System\TransactionUpdateRequest;
use Carbon,Auth,DB,Str,ImageUploader,Helper,Event,FileUploader,Curl,PDF;
use Illuminate\Support\Facades\Log;

class BusinessTransactionController extends Controller
{
    protected $data;
	protected $per_page;

	public function __construct(){
		parent::__construct();
		array_merge($this->data, parent::get_data());

        $this->data['business_scopes'] = ["" => "Choose Business Scope",'national' => "National",'regional' => "Regional",'municipality' => "City/Municipality",'barangay' => "Barangay"];
		$this->data['business_types'] = ["" => "Choose Business Type",'sole_proprietorship' => "Sole Proprietorship",'cooperative' => "Cooperative",'corporation' => "Corporation",'partnership' => "Partnership"];
		$this->data['regional_offices'] = ['' => "Choose Regional Offices"] + RegionalOffice::pluck('name', 'id')->toArray();
		$this->data['requirements'] =  ApplicationRequirements::pluck('name','id')->toArray();
		$this->data['status'] = ['' => "Choose Payment Status",'PAID' => "Paid" , 'UNPAID' => "Unpaid"];
		$this->data['approval'] = ['' => "Choose Approval Type",'1' => "Yes" , '0' => "No"];
		$this->data['processor'] = ['' => "Choose Validation",'1' => "Validated" , '0' => "Not Yet"];
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
		$this->data['selected_processor'] = $request->get('processor');
		$this->data['selected_processing_fee_status'] = $request->get('processing_fee_status');
		$this->data['keyword'] = Str::lower($request->get('keyword'));
        $this->data['applications'] = ['' => "Choose Applications"] + Application::where('department_id',$request->get('department_id'))->where('type',"business")->pluck('name', 'id')->toArray();

		$this->data['transactions'] = BusinessTransaction::with('application_permit')->with('owner')->where('status',"PENDING")->where('is_resent',0)->whereHas('application_permit',function($query){
				if(strlen($this->data['keyword']) > 0){
					return $query->WhereRaw("LOWER(business_name)  LIKE  '%{$this->data['keyword']}%'")
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
					if(strlen($this->data['selected_processor']) > 0){
						return $query->where('is_validated',$this->data['selected_processor']);
					}
                })
                ->where(function($query) use($auth){
					if(strlen($auth->department_id) > 0 && !in_array($auth->type, ['admin', 'super_user'])){
						return $query->where('is_validated', '1');
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
		$this->data['app_business_permit'] = ApplicationBusinessPermit::where('business_id' , $this->data['transaction']->business_id)->get();

        $this->data['app_business_permit_file'] = ApplicationBusinessPermitFile::where('application_business_permit_id', $this->data['transaction']->id)->get();


		$this->data['physical_requirements'] = ApplicationRequirements::whereIn('id',explode(",", $requirements_id))->get();

		$this->data['department'] =  Department::pluck('name','id')->toArray();

		$this->data['regulatory_fee'] = BusinessFee::where('transaction_id',$id)->where('fee_type' , 0)->get();
		$this->data['garbage_fee'] = BusinessFee::where('transaction_id',$id)->where('fee_type' , 2)->get();
        $this->data['business_tax'] = BusinessFee::where('transaction_id',$id)->where('fee_type' , 1)->get();
        $this->update_status($id);
		$this->data['page_title'] = "Transaction Details";
		return view('system.business-transaction.show',$this->data);
    }

    public function edit(PageRequest $request,$id=NULL)
    {
        $this->retrieve_lobs();
        $this->data['count_file'] = TransactionRequirements::where('transaction_id',$id)->count();
		$this->data['attachments'] = TransactionRequirements::where('transaction_id',$id)->get();
		$this->data['transaction'] = $request->get('business_transaction_data');

        $requirements_id = $this->data['transaction']->requirements_id;

        $this->data['business_line'] = BusinessActivity::where('application_business_permit_id', $this->data['transaction']->business_permit_id)->get();
        $this->data['existing'] = [];
        if(count($this->data['business_line']) > 0){
            foreach ($this->data['business_line'] as $key => $value) {
                $this->data['existing'][$value->b_class."---".$value->s_class."---".($value->x_class ? $value->x_class:"0")."---".$value->account_code] = $value->line_of_business;
            }
        }

		$this->data['app_business_permit'] = ApplicationBusinessPermit::where('business_id' , $this->data['transaction']->business_id)->get();

        $this->data['app_business_permit_file'] = ApplicationBusinessPermitFile::where('application_business_permit_id', $this->data['transaction']->id)->get();


		$this->data['physical_requirements'] = ApplicationRequirements::whereIn('id',explode(",", $requirements_id))->get();

		$this->data['department'] =  Department::pluck('name','id')->toArray();

		$this->data['regulatory_fee'] = BusinessFee::where('transaction_id',$id)->where('fee_type' , 0)->get();
		$this->data['garbage_fee'] = BusinessFee::where('transaction_id',$id)->where('fee_type' , 2)->get();
        $this->data['business_tax'] = BusinessFee::where('transaction_id',$id)->where('fee_type' , 1)->get();
        // $this->update_status($id);
		$this->data['page_title'] = "Transaction Details";
		return view('system.business-transaction.edit',$this->data);
    }

    public function update(TransactionUpdateRequest $request,$id=NULL)
    {
        // dd(request()->all());
        $this->retrieve_lobs();
        $transaction = $request->get('business_transaction_data');
        DB::beginTransaction();
        try{

            $owner_transaction_details = array('email' => request('owner.email'), 'contact_number' => request('owner.contact_number'));
            $business_info = array_merge(request('business_info'), request('transaction'));

            $transaction->fill(array_merge( request('transaction'),  $owner_transaction_details))->save();
            $transaction->business_info->fill($business_info)->save();
            $transaction->owner->fill(request('owner'))->save();

            // retrieve all lines of business by transaction
            // if empty  disregard
            $permit_business_lines = BusinessActivity::where('application_business_permit_id', $transaction->business_permit_id)->get();
            $list_of_line_of_business_save_to_local = array();

            // handle edit of existing line of businesses
            if($permit_business_lines){
                $lob_array = [];
                foreach ($permit_business_lines  as $business_l) {
                    $lob_array[$business_l->id] = $business_l->b_class."---".$business_l->s_class."---".($business_l->x_class ? $business_l->x_class:"0")."---".$business_l->account_code;
                }

                if(!empty($lob_array)){
                    if(request('editables')){
                        foreach ($lob_array as $key_business => $editable_lob) {
                            if(in_array($editable_lob, request('editables.old_line'))){
                                $line_key = array_search($editable_lob, request('editables.old_line'));
                                $lob_code =$this->data['line_of_businesses_coded'][request('editables.business_line')[$line_key]];

                                $line = BusinessActivity::where('id', $key_business)->first();
                                $line->gross_sales = request('editables.amount')[$line_key];
                                $line->no_of_unit = request('editables.no_of_units')[$line_key];
                                $line->particulars = strtoupper(request('editables.particulars')[$line_key]);

                                $line->line_of_business = $lob_code['Class'];
                                $line->b_class =  $lob_code['BClass'];
                                $line->s_class =  $lob_code['SClass'];
                                $line->x_class =  $lob_code['XClass'] ?? 0 ;
                                $line->account_code =  $lob_code['AcctCode'];
                                $line->reference_code =  $lob_code['RefCode'];
                                $line->save();


                                $data = [
                                    'application_business_permit_id' => $transaction->application_permit->id,
                                    'line_of_business' => $lob_code['Class'],
                                    'no_of_unit' =>  request('editables.no_of_units')[$line_key],
                                    'capitalization' => $transaction->application_permit->type == "new" ? $request->amount [$line_key] : ($request->is_new [$line_key] ? request('editables.amount')[$line_key] : 0),
                                    'gross_sales' => request('editables.amount')[$line_key],
                                    'reference_code' => $lob_code ['RefCode'],
                                    'b_class' => $lob_code ['BClass'],
                                    's_class' => $lob_code ['SClass'],
                                    'x_class' => $lob_code ['XClass'] ?? 0 ,
                                    'account_code' => $lob_code ['AcctCode'] ,
                                    'particulars' => strtoupper(request('editables.particulars')[$line_key])
                                ];

                                info('updated - ', ['key_line' => $line_key, 'data' => $line]);
                                array_push($list_of_line_of_business_save_to_local, $data);
                            }else{
                                if(!in_array($editable_lob, request('editables.business_line'))){
                                    info('deleted - ', ['data' => $key_business]);
                                    BusinessActivity::where('id', $key_business)->delete();
                                }
                            }
                        }
                    }else{
                        // all existing business lines has been requested for deletion
                        foreach ($permit_business_lines as $permit_to_delete) {
                            $permit_to_delete->delete();
                        }
                        info('Deleted All LOB');
                    }
                }
            }

            if(request('business_line')){
                foreach (request('business_line') as $key_business => $lob_request) {
                    $lob_code = $this->data['line_of_businesses_coded'][$lob_request];
                    /**
                     * 0 = line of business name
                     * 1 = reference code
                     * 2 = b class
                     * 3 = s class
                     * 4 = x class
                     * 5 = account code
                     * 6 = particular
                     */
                    $data = [
                        'application_business_permit_id' => $transaction->application_permit->id,
                        'line_of_business' => $transaction->application_permit->type == "renew" && !$request->is_new [$key_business] ? $lob_code['Class'] : $request->line_of_business [$key_business],
                        'no_of_unit' => $request->no_of_units [$key_business],
                        'capitalization' => $transaction->application_permit->type == "new" ? $request->amount [$key_business] : ($request->is_new [$key_business] ? $request->amount [$key_business] : 0),
                        'gross_sales' => $transaction->application_permit->type == "renew" && !$request->is_new [$key_business] ? $request->amount [$key_business] : 0,
                        'reference_code' => $lob_code ['RefCode'],
                        'b_class' => $lob_code ['BClass'],
                        's_class' => $lob_code ['SClass'],
                        'x_class' => $lob_code ['XClass'] ?? 0 ,
                        'account_code' => $lob_code ['AcctCode'] ,
                        'particulars' => strtoupper($request->particulars [$key_business]) ?? ''
                    ];
                    BusinessActivity::insert($data);
                    array_push($list_of_line_of_business_save_to_local, $data);

                }
            }

            $request_body = [
                'business_id' => $transaction->business_info->business_id_no,
                'ebriu_application_no' =>   $transaction->application_permit->application_no,
                'year' => Carbon::now()->year,
                'line_of_business' => $list_of_line_of_business_save_to_local
            ];

            $line_of_business_data = new UploadLineOfBusinessToLocal($request_body);
            Event::dispatch('upload-line-of-business-to-local', $line_of_business_data);

            DB::commit();

            session()->flash('notification-status', "success");
            session()->flash('notification-msg', "Changes has been saved");
            return redirect(route('system.business_transaction.show', ['id' => $id]));
        }catch(\Throwable $e){
            DB::rollback();
            Log::error('TRANSACTION_EDIT_FAILED', ['message' => $e->getMessage()]);
            session()->flash('notification-status', "failed");
			session()->flash('notification-msg', "Server Error: Code #{$e->getLine()}");
			return redirect()->back();
        }

    }

    public function retrieve_lobs()
    {
        $response = Curl::to(env('OBOSS_GET_LINE_OF_BUSINESS'))
        ->withData($this->data)
        ->asJson(true)
        ->returnResponseObject()
        ->get();

        if ($response->status == "200") {
            foreach($response->content['data'] as $key => $lob){
                $this->data['line_of_businesses'][$lob['BClass']."---".$lob['SClass']."---".($lob['XClass'] ? $lob['XClass']:"0")."---".$lob['AcctCode']] = $lob['Class'];
                $this->data['line_of_businesses_coded'][$lob['BClass']."---".$lob['SClass']."---".($lob['XClass'] ? $lob['XClass']:"0")."---".$lob['AcctCode']] = $lob;
                if(!empty($lob['Class'])){
                    $particulars = !empty($lob['Particulars']) ? " (".$lob['Particulars'].")" : "";
                    $this->data['lob'][] = $lob['Class'].$particulars;
                }
            }
        }else{
            Log::error('API_GET_LOB_FAILED', ['response' => $response]);
        }
    }

    public function update_status($id = null)
    {
        $business_transaction = BusinessTransaction::find($id);
        $business_transaction->isNew = null;
        $business_transaction->save();
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
		$d1 = new Carbon('01/20');
		$d2 = new Carbon('04/20');
		$d3 = new Carbon('07/20');
		$d4 = new Carbon('10/20');

		$type = strtoupper($request->get('status_type'));
		DB::beginTransaction();
		try{
			$transaction = $request->get('business_transaction_data');
			$transaction->status = $type;
			$transaction->remarks = $type == "DECLINED" ? $request->get('remarks') : NULL;
			$transaction->processor_user_id = Auth::user()->id;
			$transaction->status = $type;
			$transaction->modified_at = Carbon::now();
            $transaction->save();

            $transaction->application_permit->status =  strtolower($type);
            $transaction->application_permit->save();

			if ($type == "APPROVED") {
				$regulatory_fee = BusinessFee::where('transaction_id', $id)->where('fee_type' , 0)->get();
			    $business_tax = BusinessFee::where('transaction_id', $id)->where('fee_type' , 1)->first();
			    $garbage_fee = BusinessFee::where('transaction_id', $id)->where('fee_type' , 2)->get();
				if (!$regulatory_fee || !$business_tax || !$garbage_fee ) {

					session()->flash('notification-status', "failed");
					session()->flash('notification-msg', "Cannot approved transaction with incomplete assessment");
					return redirect()->route('system.business_transaction.show',[$id]);
				}
			   

			    if ($regulatory_fee) {
			    	$business_fee_id = [];
			    	$total_amount = 0;
			    	foreach ($regulatory_fee as $key => $value) {
			    		array_push($business_fee_id, $value->id);
			    		$total_amount += Helper::db_amount($value->amount);

			    	}
			    	$new_regulatory_payment = new RegulatoryPayment();
			    	$new_regulatory_payment->business_fee_id = implode(",", $business_fee_id);
			    	$new_regulatory_payment->transaction_id = $id;
			    	$new_regulatory_payment->amount = $total_amount;
			    	$new_regulatory_payment->save();
			    	$new_regulatory_payment->transaction_code = 'RF-' . Helper::date_format(Carbon::now(), 'ym') . str_pad($new_regulatory_payment->id, 5, "0", STR_PAD_LEFT) . Str::upper(Str::random(3));
			    	$new_regulatory_payment->save();
			    }
			    if ($business_tax) {
			    	$amount = $business_tax->amount / 4 ;
			    	for ($i=0; $i < 4; $i++) {
			    		switch ($i + 1) {
			    			case '1':
			    				$due_date = Carbon::now()->year.$d1->format('-m-d');
			    				break;
			    			case '2':
			    				$due_date = Carbon::now()->year.$d2->format('-m-d');
			    				break;
			    			case '3':
			    				$due_date = Carbon::now()->year.$d3->format('-m-d');
			    				break;
			    			case '4':
			    				$due_date = Carbon::now()->year.$d4->format('-m-d');
			    				break;
			    			default:
			    				break;
			    		}
			    		$business_tax_payment  = new BusinessTaxPayment();
			    		$business_tax_payment->business_fee_id =  $business_tax->id;
			    		$business_tax_payment->transaction_id = $id;
			    		$business_tax_payment->quarter = $i + 1;
			    		$business_tax_payment->fee_type = 1;
			    		$business_tax_payment->amount = $amount;
			    		$business_tax_payment->surcharge = $amount * .25;
			    		$business_tax_payment->due_date = $due_date;
			    		$business_tax_payment->save();
				    	$business_tax_payment->transaction_code = 'BT-' . Helper::date_format(Carbon::now(), 'ym') . str_pad($business_tax_payment->id, 5, "0", STR_PAD_LEFT) . Str::upper(Str::random(3));
				    	$business_tax_payment->save();
			    	}
			    }
			    if ($garbage_fee) {
			    	$amount = $business_tax->amount / 4 ;
			    	for ($i=0; $i < 4; $i++) {
			    		switch ($i + 1) {
			    			case '1':
			    				$due_date = Carbon::now()->year.$d1->format('-m-d');
			    				break;
			    			case '2':
			    				$due_date = Carbon::now()->year.$d2->format('-m-d');
			    				break;
			    			case '3':
			    				$due_date = Carbon::now()->year.$d3->format('-m-d');
			    				break;
			    			case '4':
			    				$due_date = Carbon::now()->year.$d4->format('-m-d');
			    				break;
			    			default:
			    				break;
			    		}
			    		$business_tax_payment  = new BusinessTaxPayment();
			    		$business_tax_payment->business_fee_id =  $business_tax->id;
			    		$business_tax_payment->transaction_id = $id;
			    		$business_tax_payment->quarter = $i + 1;
			    		$business_tax_payment->fee_type = 2;
			    		$business_tax_payment->amount = $amount;
			    		$business_tax_payment->surcharge = $amount * .25;
			    		$business_tax_payment->due_date = $due_date;
			    		$business_tax_payment->save();
				    	$business_tax_payment->transaction_code = 'GF-' . Helper::date_format(Carbon::now(), 'ym') . str_pad($business_tax_payment->id, 5, "0", STR_PAD_LEFT) . Str::upper(Str::random(3));
				    	$business_tax_payment->save();
			    	}
			    }

			    $insert[] = [
	            	'contact_number' => $transaction->owner ? $transaction->owner->contact_number : $transaction->contact_number,
	            	'email' => $transaction->owner ? $transaction->owner->email : $transaction->email,
	                'amount' => $transaction->total_amount,
	                'ref_num' => $transaction->code,
	                'full_name' => $transaction->owner ? $transaction->owner->full_name : $transaction->business_name,
	                'application_name' => $transaction->application_name,
                    'modified_at' => Helper::date_only($transaction->modified_at),
                    'business_id' => $transaction->business_id,
            	];
			    $notification_data_email = new SendEmailApprovedBusiness($insert);
			    Event::dispatch('send-email-business-approved', $notification_data_email);

			} else {
                $insert = [];
                foreach(json_decode($transaction->department_remarks) as $value) {
                    $insert[] = [
                        'contact_number' => $transaction->owner ? $transaction->owner->contact_number : $transaction->contact_number,
                        'email' => $transaction->owner ? $transaction->owner->email : $transaction->email,
                        'amount' => $transaction->total_amount,
                        'ref_num' => $transaction->code,
                        'full_name' => $transaction->owner ? $transaction->owner->full_name : $transaction->business_name,
                        'application_name' => $transaction->application_name,
                        'modified_at' => Helper::date_only($transaction->modified_at),
                        'department_name' => Helper::department_name($value->id),
                        'remarks' =>  $transaction->remarks,
                    ];
                }

                $notification_data_email = new SendEmailDeclinedBusiness($insert);
                Event::dispatch('send-email-business-declined', $notification_data_email);
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

    public function digital_cerficate(PageRequest $request,$id=NULL){
        $this->data['transaction'] = BusinessTransaction::find($id);
        $transaction = BusinessTransaction::find($id);
        $this->data['business_line'] = BusinessActivity::where('application_business_permit_id', 1)->get();
        $this->data['regulatory_fee'] = BusinessFee::where('transaction_id',1)->where('fee_type' , 0)->get();
        $this->data['business_tax'] = BusinessFee::where('transaction_id',1)->where('fee_type' , 1)->get();
        $insert[] = [
            'data' => $this->data,
            'email' => $transaction->owner ? $transaction->owner->email : $transaction->email,
        ];
        $notification_data_email = new SendEmailDigitalCertificate($insert);
        Event::dispatch('send-digital-business-permit', $notification_data_email);
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
            $department = User::whereIn('department_id', explode(",",$request->get('department_code')))->get();
            $insert = [];
            foreach ($department as $departments ) {
                $insert[] = [
                    'contact_number' => $departments->contact_number,
                    'email' => $departments->email,
                    'department_name' => $departments->department->name,
                    'application_no' => $transaction->application_permit->application_no,
                ];
            }
            // Send via SMS
            //$notification_data = new NotifyDepartmentSMS($insert);
            //Event::dispatch('notify-departments-sms', $notification_data);

            // send via Email
            $notification_data = new NotifyDepartmentEmail($insert);
            Event::dispatch('notify-departments-email', $notification_data);
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

		$this->data['business_fees'] = BusinessFee::where('transaction_id',$id)->where('office_code',$auth->department->code)->get();

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
				'office_code' => "99",
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

			$regulatory_array = [];
			$business_array = [];
			$garbage_array = [];

			foreach ($response->content['data'] as $key => $value) {
				if ($value['FeeType'] == 0 ) {
					array_push($regulatory_array, $value);
				}
				if ($value['FeeType'] == 1 ) {
					array_push($business_array, $value);
				}
				if ($value['FeeType'] == 2) {
					array_push($garbage_array, $value);
				}
			}
			if (count($regulatory_array) > 0) {
				$total_amount = 0 ;
				foreach ($regulatory_array as $key => $value) {
					$total_amount += Helper::db_amount($value['Amount']);
				}
				$existing = BusinessFee::where('transaction_id' ,$this->data['transaction']->id)->where('fee_type' , 0)->first();
				if ($existing) {
					$existing->delete();
				}else{
					$new_business_fee = new BusinessFee();
					$new_business_fee->business_id = $this->data['transaction']->business_id;
					$new_business_fee->transaction_id =$this->data['transaction']->id;
					$new_business_fee->collection_of_fees = json_encode($regulatory_array);
					$new_business_fee->amount = Helper::db_amount($total_amount);
					$new_business_fee->status = "PENDING";
					$new_business_fee->office_code = $request->get('office_code');
					$new_business_fee->fee_type = 0;
					$new_business_fee->save();
				}
			}

			if (count($business_array) > 0) {
				$total_amount = 0 ;
				foreach ($business_array as $key => $value) {
					$total_amount += Helper::db_amount($value['Amount']);
				}
				$existing = BusinessFee::where('transaction_id' ,$this->data['transaction']->id)->where('fee_type' , 1)->first();
				if ($existing) {
					$existing->delete();
				}else{
					$new_business_fee = new BusinessFee();
					$new_business_fee->business_id = $this->data['transaction']->business_id;
					$new_business_fee->transaction_id =$this->data['transaction']->id;
					$new_business_fee->collection_of_fees = json_encode($business_array);
					$new_business_fee->amount = Helper::db_amount($total_amount);
					$new_business_fee->status = "PENDING";
					$new_business_fee->office_code = $request->get('office_code');
					$new_business_fee->fee_type = 1;
					$new_business_fee->save();
				}

			}

			if (count($garbage_array) > 0) {
				$total_amount = 0 ;
				foreach ($garbage_array as $key => $value) {
					$total_amount += Helper::db_amount($value['Amount']);
				}
				$existing = BusinessFee::where('transaction_id' ,$this->data['transaction']->id)->where('fee_type' , 2)->first();
				if ($existing) {
					$existing->delete();
				}else{
					$new_business_fee = new BusinessFee();
					$new_business_fee->business_id = $this->data['transaction']->business_id;
					$new_business_fee->transaction_id =$this->data['transaction']->id;
					$new_business_fee->collection_of_fees = json_encode($garbage_array);
					$new_business_fee->amount = Helper::db_amount($total_amount);
					$new_business_fee->status = "PENDING";
					$new_business_fee->office_code = $request->get('office_code');
					$new_business_fee->fee_type = 2;
					$new_business_fee->save();
				}

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
			$regulatory_fee = BusinessFee::find($id);
			if (!$regulatory_fee->amount) {
				session()->flash('notification-status', "failed");
				session()->flash('notification-msg', "No Amount Found");
				return redirect()->back();
			}
			$regulatory_fee->status = "APPROVED";
			$regulatory_fee->save();
			DB::commit();
			session()->flash('notification-status', "success");
			session()->flash('notification-msg', "Assesment has been successfully approved.");
			return redirect()->route('system.business_transaction.assessment',$regulatory_fee->transaction_id);
		}catch(\Exception $e){
			DB::rollback();
			session()->flash('notification-status', "failed");
			session()->flash('notification-msg', "Server Error: Code #{$e->getLine()}");
			return redirect()->back();
		}
	}

	public function update_department(PageRequest $request , $id = NULL){
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
			$transaction->save();

			DB::commit();
			session()->flash('notification-status', "success");
			session()->flash('notification-msg', "Office Code has been updated.");
			return redirect()->route('system.business_transaction.show',[$id]);

		}catch(\Exception $e){
			DB::rollback();
			session()->flash('notification-status', "failed");
			session()->flash('notification-msg', "Server Error: Code #{$e->getLine()}");
			return redirect()->back();
		}
	}

	public function release(PageRequest $request , $id = NULL){
		DB::beginTransaction();
		try{
			$transaction = $request->get('business_transaction_data');
			$transaction->digital_certificate_released = "1";
			$transaction->save();

			$insert[] = [
	        	'email' => $transaction->owner ? $transaction->owner->email : $transaction->email,
	            'business_name' => $transaction->business_info ? $transaction->business_info->business_name : $transaction->business_name,
	            'business_id' => $transaction->business_id,
	            'link' => env("APP_URL")."e-permit/".$transaction->business_id,
	    	];

		    $notification_data_email = new SendEmailDigitalCertificate($insert);
		    Event::dispatch('send-digital-business-permit', $notification_data_email);

		    DB::commit();
			session()->flash('notification-status', "success");
			session()->flash('notification-msg', "Certificate has been successfully released.");
			return redirect()->route('system.business_transaction.show',[$id]);
		}catch(\Exception $e){
			DB::rollback();
			session()->flash('notification-status', "failed");
			session()->flash('notification-msg', "Server Error: Code #{$e->getLine()}");
			return redirect()->back();
		}
	}
}
