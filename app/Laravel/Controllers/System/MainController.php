<?php

namespace App\Laravel\Controllers\System;


/*
 * Request Validator
 */
use App\Laravel\Requests\PageRequest;


/*
 * Models
 */
use App\Laravel\Models\{Transaction,Department,Application, Business, BusinessTransaction,Customer};

/* App Classes
 */
use Carbon,Auth,DB,Str;

class MainController extends Controller{

	protected $data;

	public function __construct(){
		parent::__construct();
		array_merge($this->data, parent::get_data());
	}

	public function dashboard(PageRequest $request){
		$auth = $request->user();
		$this->data['page_title'] .= "Dashboard";

		if (in_array($auth->type, ["admin", "super_user"])) {

			$this->data['registrants_total'] = Customer::count();
			$this->data['registrants_pending'] = Customer::where('status','pending')->count();
			$this->data['registrants_approved'] = Customer::where('status','approved')->count();
			$this->data['registrants_declined'] = Customer::where('status','declined')->count();

			$this->data['business_cv'] = Business::count();

			$this->data['total_validated'] = BusinessTransaction::where('is_validated', 1)->count();
			$this->data['total_for_validation'] = BusinessTransaction::where('is_validated', 0)->count();

			$this->data['total_transactions'] = BusinessTransaction::count();
            $this->data['pending_transactons'] = BusinessTransaction::where('status',"PENDING")->count();
			$this->data['approved_transactons'] = BusinessTransaction::where('status',"APPROVED")->count();
			$this->data['declined_transactons'] = BusinessTransaction::where('status',"DECLINED")->count();

			$this->data['total_for_cto'] = BusinessTransaction::where('is_validated', 1)->count();
			$this->data['actioned'] = BusinessTransaction::Wherehas('with_fee')->count();
			$this->data['pending_assessment'] = BusinessTransaction::where('is_validated', 1)->doesnthave('with_fee')->count();


			$this->data['paid_transactons'] = BusinessTransaction::where('payment_status',"PAID")->count();
			$this->data['unpaid_transactons'] = BusinessTransaction::where('payment_status',"UNPAID")->count();


			//$this->data['validated'] = BusinessTransaction::where('is_validated',"1")->count();
            //$this->data['for_bplo'] = BusinessTransaction::where('for_bplo_approval',"1")->count();

			$this->data['application_today'] = BusinessTransaction::whereDate('created_at', Carbon::now())->count();

			$this->data['applications'] = BusinessTransaction::orderBy('created_at',"DESC")->get();
			$this->data['labels'] = Department::pluck('name')->toArray();
			$this->data['transaction_per_department'] = Department::withCount('assignTransaction')->pluck('assign_transaction_count')->toArray();
            $departments = BusinessTransaction::orderBy('created_at',"ASC")->first();

            //NOTE:: ignore processing fee as specified
			// $transaction_query = BusinessTransaction::groupBy('department_id')->select("department_id", DB::raw('SUM(processing_fee + amount) AS amount_sum'));

		 	// $this->data['amount_per_application'] = Department::leftjoin(DB::raw("({$transaction_query->toSql()}) AS tq"), 'tq.department_id', '=', 'department.id')->mergeBindings($transaction_query->getQuery())
			// 				->select('department.*', 'amount_sum')->get();

			// $this->data['total_amount'] = BusinessTransaction::select(DB::raw('sum(processing_fee + amount) as total'))->first();

			$chart_data = [];
			$per_month_date = [];
	    	$per_month_application =[];

	    	$approved_year_start = Carbon::now()->startOfYear()->subMonth();
	    	$declined_year_start = Carbon::now()->startOfYear()->subMonth();

			foreach(range(1,12) as $index => $value){
				$approved = BusinessTransaction::whereRaw("MONTH(created_at) = '".$approved_year_start->addMonth()->format('m')."' AND YEAR(created_at) = '".Carbon::now()->format('Y')."'")->where('status','APPROVED');
				$total_approved = $approved->count();

				$declined = BusinessTransaction::whereRaw("MONTH(created_at) = '".$declined_year_start->addMonth()->format('m')."' AND YEAR(created_at) = '".Carbon::now()->format('Y')."'")->where('status','DECLINED');
				$total_declined = $declined->count();

				array_push($per_month_application, ["month"=>$approved_year_start->format("M"),"approved"=>$total_approved,"declined"=>$total_declined]);
			}

			$this->data['per_month_application'] = json_encode($per_month_application);
			$this->data['label_data'] = json_encode($this->data['labels']);
			$this->data['chart_data'] = json_encode($this->data['transaction_per_department']);

		}elseif ($auth->type == "office_head") {

			$this->data['registrants_total'] = Customer::count();
			$this->data['registrants_pending'] = Customer::where('status','pending')->count();
			$this->data['registrants_approved'] = Customer::where('status','approved')->count();
			$this->data['registrants_declined'] = Customer::where('status','declined')->count();

			$this->data['business_cv'] = Business::count();

			$this->data['total_validated'] = BusinessTransaction::where('department_id',explode(",", $auth->department_id))->where('is_validated', 1)->count();
			$this->data['total_for_validation'] = BusinessTransaction::where('department_id',explode(",", $auth->department_id))->where('is_validated', 0)->count();

			$this->data['total_transactions'] = BusinessTransaction::where('department_id',explode(",", $auth->department_id))->count();
            $this->data['pending_transactons'] = BusinessTransaction::where('department_id',explode(",", $auth->department_id))->where('status',"PENDING")->count();
			$this->data['approved_transactons'] = BusinessTransaction::where('department_id',explode(",", $auth->department_id))->where('status',"APPROVED")->count();
			$this->data['declined_transactons'] = BusinessTransaction::where('department_id',explode(",", $auth->department_id))->where('status',"DECLINED")->count();

			$this->data['total_for_cto'] = BusinessTransaction::where('department_id',explode(",", $auth->department_id))->where('is_validated', 1)->count();
			$this->data['actioned'] = BusinessTransaction::where('department_id',explode(",", $auth->department_id))->Wherehas('with_fee')->count();
			$this->data['pending_assessment'] = BusinessTransaction::where('department_id',explode(",", $auth->department_id))->where('is_validated', 1)->doesnthave('with_fee')->count();


			$this->data['paid_transactons'] = BusinessTransaction::where('department_id',explode(",", $auth->department_id))->where('payment_status',"PAID")->count();
			$this->data['unpaid_transactons'] = BusinessTransaction::where('department_id',explode(",", $auth->department_id))->where('payment_status',"UNPAID")->count();

			$this->data['labels'] = Application::where('department_id',explode(",", $auth->department_id))->pluck('name')->toArray();
			$this->data['transaction_per_application'] = Application::where('department_id',explode(",", $auth->department_id))->withCount('assignAppTransaction')->pluck('assign_app_transaction_count')->toArray();

			// $transaction_query = Transaction::groupBy('application_id')->select("application_id", DB::raw('SUM(processing_fee + amount) AS amount_sum'));

		 	// $this->data['amount_per_application'] = Application::where('department_id',$auth->department_id)->leftjoin(DB::raw("({$transaction_query->toSql()}) AS tq"), 'tq.application_id', '=', 'application.id')->mergeBindings($transaction_query->getQuery())
			// 				->select('application.*', 'amount_sum')->get();

			// $this->data['total_amount'] = Transaction::where('department_id' , $auth->department_id)->select(DB::raw('sum(processing_fee + amount) as total'))->first();

			$chart_data = [];
			$per_month_date = [];
	    	$per_month_application =[];

	    	$approved_year_start = Carbon::now()->startOfYear()->subMonth();
	    	$declined_year_start = Carbon::now()->startOfYear()->subMonth();

			foreach(range(1,12) as $index => $value){
				$approved = BusinessTransaction::where('department_id',explode(",", $auth->department_id))->whereRaw("MONTH(created_at) = '".$approved_year_start->addMonth()->format('m')."' AND YEAR(created_at) = '".Carbon::now()->format('Y')."'")->where('status','APPROVED');
				$total_approved = $approved->count();

				$declined = BusinessTransaction::where('department_id',explode(",", $auth->department_id))->whereRaw("MONTH(created_at) = '".$declined_year_start->addMonth()->format('m')."' AND YEAR(created_at) = '".Carbon::now()->format('Y')."'")->where('status','DECLINED');
				$total_declined = $declined->count();

				array_push($per_month_application, ["month"=>$approved_year_start->format("M"),"approved"=>$total_approved,"declined"=>$total_declined]);
			}

			$this->data['per_month_application'] = json_encode($per_month_application);

			$this->data['label_data'] = json_encode($this->data['labels']);
			$this->data['chart_data'] = json_encode($this->data['transaction_per_application']);

		}elseif ($auth->type == "processor") {

			$this->data['registrants_total'] = Customer::count();
			$this->data['registrants_pending'] = Customer::where('status','pending')->count();
			$this->data['registrants_approved'] = Customer::where('status','approved')->count();
			$this->data['registrants_declined'] = Customer::where('status','declined')->count();

			$this->data['business_cv'] = Business::count();

			$this->data['total_validated'] = BusinessTransaction::whereIn('application_id',explode(",", $auth->application_id))->where('is_validated', 1)->count();
			$this->data['total_for_validation'] = BusinessTransaction::whereIn('application_id',explode(",", $auth->application_id))->where('is_validated', 0)->count();

			$this->data['total_transactions'] = BusinessTransaction::whereIn('application_id',explode(",", $auth->application_id))->count();
            $this->data['pending_transactons'] = BusinessTransaction::whereIn('application_id',explode(",", $auth->application_id))->where('status',"PENDING")->count();
			$this->data['approved_transactons'] = BusinessTransaction::whereIn('application_id',explode(",", $auth->application_id))->where('status',"APPROVED")->count();
			$this->data['declined_transactons'] = BusinessTransaction::whereIn('application_id',explode(",", $auth->application_id))->where('status',"DECLINED")->count();

			$this->data['total_for_cto'] = BusinessTransaction::whereIn('application_id',explode(",", $auth->application_id))->where('is_validated', 1)->count();
			$this->data['actioned'] = BusinessTransaction::whereIn('application_id',explode(",", $auth->application_id))->Wherehas('with_fee')->count();
			$this->data['pending_assessment'] = BusinessTransaction::whereIn('application_id',explode(",", $auth->application_id))->where('is_validated', 1)->doesnthave('with_fee')->count();


			$this->data['paid_transactons'] = BusinessTransaction::whereIn('application_id',explode(",", $auth->application_id))->where('payment_status',"PAID")->count();
			$this->data['unpaid_transactons'] = BusinessTransaction::whereIn('application_id',explode(",", $auth->application_id))->where('payment_status',"UNPAID")->count();


			$this->data['labels'] = Application::where('department_id',$auth->department_id)->pluck('name')->toArray();

			$this->data['transaction_per_application'] = Application::whereIn('id',explode(",", $auth->application_id))->withCount('assignAppTransaction')->pluck('assign_app_transaction_count')->toArray();

			// $transaction_query = Transaction::groupBy('application_id')->select("application_id", DB::raw('SUM(processing_fee + amount) AS amount_sum'));

		 // 	$this->data['amount_per_application'] = Application::whereIn('id',explode(",", $auth->application_id))->leftjoin(DB::raw("({$transaction_query->toSql()}) AS tq"), 'tq.application_id', '=', 'application.id')->mergeBindings($transaction_query->getQuery())
			// 				->select('application.*', 'amount_sum')->get();

			// $this->data['total_amount'] = Transaction::whereIn('application_id' ,explode(",", $auth->application_id))->select(DB::raw('sum(processing_fee + amount) as total'))->first();

			$chart_data = [];
			$per_month_date = [];
	    	$per_month_application =[];

	    	$approved_year_start = Carbon::now()->startOfYear()->subMonth();
	    	$declined_year_start = Carbon::now()->startOfYear()->subMonth();

			foreach(range(1,12) as $index => $value){
				$approved = BusinessTransaction::whereIn('application_id',explode(",", $auth->application_id))->whereRaw("MONTH(created_at) = '".$approved_year_start->addMonth()->format('m')."' AND YEAR(created_at) = '".Carbon::now()->format('Y')."'")->where('status','APPROVED');
				$total_approved = $approved->count();

				$declined = BusinessTransaction::whereIn('application_id',explode(",", $auth->application_id))->whereRaw("MONTH(created_at) = '".$declined_year_start->addMonth()->format('m')."' AND YEAR(created_at) = '".Carbon::now()->format('Y')."'")->where('status','DECLINED');
				$total_declined = $declined->count();

				array_push($per_month_application, ["month"=>$approved_year_start->format("M"),"approved"=>$total_approved,"declined"=>$total_declined]);
			}

			$this->data['per_month_application'] = json_encode($per_month_application);
			$this->data['label_data'] = json_encode($this->data['labels']);
			$this->data['chart_data'] = json_encode($this->data['transaction_per_application']);

		}



		return view('system.dashboard',$this->data);
	}


}
