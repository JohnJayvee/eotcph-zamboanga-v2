<?php

namespace App\Laravel\Controllers\System;


/*
 * Request Validator
 */
use App\Laravel\Requests\PageRequest;


/*
 * Models
 */
use App\Laravel\Models\{Transaction,Department,Application, Business, BusinessTransaction};

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
			$this->data['applications'] = BusinessTransaction::orderBy('created_at',"DESC")->get();
            $this->data['pending'] = BusinessTransaction::where('status',"PENDING")->count();
            $this->data['validated'] = BusinessTransaction::where('is_validated',"1")->count();
            $this->data['for_bplo'] = BusinessTransaction::where('for_bplo_approval',"1")->count();
			$this->data['approved'] = BusinessTransaction::where('status',"APPROVED")->count();
			$this->data['declined'] = BusinessTransaction::where('status',"DECLINED")->count();
			$this->data['business_cv'] = Business::count();
			$this->data['application_today'] = BusinessTransaction::whereDate('created_at', Carbon::now())->count();
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

			$this->data['applications'] = BusinessTransaction::where('department_id',explode(",", $auth->department_id))->orderBy('created_at',"DESC")->get();
			$this->data['pending'] = BusinessTransaction::where('department_id',explode(",", $auth->department_id))->where('status',"PENDING")->count();
			$this->data['approved'] = BusinessTransaction::where('department_id',explode(",", $auth->department_id))->where('status',"APPROVED")->count();
			$this->data['declined'] = BusinessTransaction::where('department_id',explode(",", $auth->department_id))->where('status',"DECLINED")->count();
			$this->data['application_today'] = BusinessTransaction::where('department_id',explode(",", $auth->department_id))->whereDate('created_at', Carbon::now())->count();
            $this->data['validated'] = BusinessTransaction::where('department_id',explode(",", $auth->department_id))->where('is_validated',"1")->count();
            $this->data['for_bplo'] = BusinessTransaction::where('department_id',explode(",", $auth->department_id))->where('for_bplo_approval',"1")->count();
			$this->data['business_cv'] = Business::count();

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

			$this->data['applications'] = BusinessTransaction::whereIn('application_id',explode(",", $auth->application_id))->orderBy('created_at',"DESC")->get();
			$this->data['pending'] = BusinessTransaction::whereIn('application_id',explode(",", $auth->application_id))->where('status',"PENDING")->count();
			$this->data['approved'] = BusinessTransaction::whereIn('application_id',explode(",", $auth->application_id))->where('status',"APPROVED")->count();
			$this->data['declined'] = BusinessTransaction::whereIn('application_id',explode(",", $auth->application_id))->where('status',"DECLINED")->count();
			$this->data['application_today'] = BusinessTransaction::whereIn('application_id',explode(",", $auth->application_id))->whereDate('created_at', Carbon::now())->count();
            $this->data['validated'] = BusinessTransaction::whereIn('application_id',explode(",", $auth->application_id))->where('is_validated',"1")->count();
            $this->data['for_bplo'] = BusinessTransaction::whereIn('application_id',explode(",", $auth->application_id))->where('for_bplo_approval',"1")->count();
			$this->data['business_cv'] = Business::count();

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
