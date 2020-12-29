<?php

namespace App\Laravel\Controllers\Web;

/*
 * Request Validator
 */
use App\Laravel\Requests\PageRequest;
use App\Laravel\Models\Application;
use App\Laravel\Models\Transaction;
use App\Laravel\Models\OtherTransaction;
use App\Laravel\Models\CollectionOfFees;
use App\Laravel\Models\RegulatoryPayment;

use App\Laravel\Models\ApplicationRequirements;
/*
 * Models
 */

/* App Classes
 */
use Helper, Carbon, Session, Str,Auth,Input,DB;

class MainController extends Controller{

	protected $data;
	public function __construct () {
	}


	public function index(PageRequest $request){
        $this->data['page_title'] = "Homepage";
		return view('web.homepage',$this->data);
		// return view('web.application.form',$this->data);
	}

	public function contact(PageRequest $request){
		$this->data['page_title'] = "Contact Us";
		return view('web.page.contact',$this->data);
	}
	public function application(PageRequest $request){
		$this->data['page_title'] = "Application";

		return view('web.page.application',$this->data);
	}


	public function get_application_type(PageRequest $request){
		$id = $request->get('department_id');
		$application = Application::where('department_id',$id)->get()->pluck('name', 'id');
		$response['msg'] = "List of Application";
		$response['status_code'] = "TYPE_LIST";
		$response['data'] = $application;
		callback:


		return response()->json($response, 200);
	}

	public function get_payment_fee(PageRequest $request){
		$id = $request->get('type_id');
		$payment_amount = Application::find($id);
		$response['msg'] = "List of Application";
		$response['status_code'] = "TYPE_LIST";
		$response['data'] = [$payment_amount->processing_fee,$payment_amount->partial_amount];
		callback:

		return response()->json($response, 200);
	}

	public function get_collection_fee(PageRequest $request){
		$id = $request->get('collection_id');
		$collection = CollectionOfFees::find($id);
		$response['msg'] = "List of Collection";
		$response['status_code'] = "TYPE_LIST";
		$response['data'] = $collection;
		callback:

		return response()->json($response, 200);
	}

	public function get_requirements(PageRequest $request){
		$id = $request->get('type_id');
		$application = Application::find($id);
		$required = [];
		$requirements = ApplicationRequirements::whereIn('id',explode(",", $application->requirements_id))->get();

		foreach ($requirements as $key => $value) {
			if ($value->is_required == "yes") {
				$string = $value->name . " (Required)";
				$string_id = "file".$value->id;
				$is_required = "required";
			}else{
				$string = $value->name . " (Optional)";
				$string_id = "file".$value->id;
				$is_required = " ";
			}

			array_push($required, [$string,$string_id,$value->id,$is_required]);
		}
		$response['msg'] = "List of Requirements";
		$response['status_code'] = "TYPE_LIST";
		$response['data'] = $required;
		callback:
		return response()->json($response, 200);
	}

	public function confirmation($code = NULL){
		sleep(10);
		$this->data['page_title'] = " :: confirmation";

		$prefix = explode('-', $code);
		$code = strtolower($code);

		switch (strtoupper($prefix[0])) {
			case 'APP':
				$transaction = Transaction::whereRaw("LOWER(transaction_code)  LIKE  '%{$code}%'")->first();
				$current_transaction_code = Str::lower($transaction->transaction_code);
				break;
			case 'OT':
				$transaction = OtherTransaction::whereRaw("LOWER(processing_fee_code)  LIKE  '%{$code}%'")->first();
				$current_transaction_code = Str::lower($transaction->processing_fee_code);
				break;
			case 'RF':
				$transaction = RegulatoryPayment::whereRaw("LOWER(transaction_code)  LIKE  '%{$code}%'")->first();
				$current_transaction_code = Str::lower($transaction->transaction_code);
				break;
			default:
				$transaction = Transaction::whereRaw("LOWER(processing_fee_code)  LIKE  '%{$code}%'")->first();
				$current_transaction_code = Str::lower($transaction->processing_fee_code);
				break;
		}

		$current_transaction_code = Str::lower(session()->get('transaction.code'));

		if($current_transaction_code == $code){
			session()->forget('transaction');
			$this->data['transaction'] = $transaction;
			$this->data['prefix'] = strtoupper($prefix[0]);
			return view('web._components.message',$this->data);
		}

		session()->flash('notification-status',"warning");
		session()->flash('notification-msg',"Transaction already completed. No more action is needed.");
		return redirect()->route('web.main.index');

    }

    public function soon(){
        return view('web.coming-soon');
    }

}
