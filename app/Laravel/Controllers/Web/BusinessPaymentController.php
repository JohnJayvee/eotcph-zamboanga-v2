<?php

namespace App\Laravel\Controllers\Web;

/*
 * Request Validator
 */
use App\Laravel\Requests\PageRequest;
use App\Laravel\Requests\Web\TransactionRequest;
use App\Laravel\Requests\Web\UploadRequest;
use App\Laravel\Requests\Web\BusinessRequest;
use App\Laravel\Models\{BusinessTransaction,Business,BusinessLine,BusinessFee,RegulatoryPayment};
use App\Laravel\Requests\Web\EditBusinessRequest;
/*
 * Models
 */


use Carbon,Auth,DB,Str,ImageUploader,Event,FileUploader,PDF,QrCode,Helper,Curl,Log;

class BusinessPaymentController extends Controller
{	
	protected $data;
	protected $per_page;

	public function __construct(){
		parent::__construct();
		array_merge($this->data, parent::get_data());

		if (Auth::guard('customer')->user()) {
			$this->data['auth'] = Auth::guard('customer')->user();
			$this->data['business_profiles'] = Business::where('customer_id',$this->data['auth']->id)->get();
		}
		$this->per_page = env("DEFAULT_PER_PAGE",10);
	}
    public function index(PageRequest $request , $id = NULL){
        $this->data['page_title'] = "Business Payment Method";
        $this->data['auth'] = Auth::guard('customer')->user();
        $this->data['profile'] = Business::find($id);

        $this->data['transaction'] = BusinessTransaction::where('business_id',$id)->first();

        $this->data['payment_type'] = $request->get('type') ?:"regulatory_fee";
        

        switch ($this->data['payment_type']) {
        	case 'regulatory_fee':
        		$this->data['regulatory_fee'] = BusinessFee::where('business_id', $id)->where('fee_type' , 0)->get();
        		break;
        	case 'business_tax':
       			$this->data['business_tax'] = BusinessFee::where('business_id', $id)->where('fee_type' , 1)->get();
        		break;
        	default:
        		# code...
        		break;
        }

        return view('web.business.payment',$this->data);
    }


    public function regulatory_payment(PageRequest $request, $id = null){
    	$transaction_data = BusinessTransaction::find($id);
		$transaction = RegulatoryPayment::where('transaction_id' , $id)->first();
		$prefix = explode('-', $transaction->transaction_code)[0];
		$code = $transaction->transaction_code;
		$amount = $transaction->amount;
		$prefix = strtoupper($prefix);

		if(!$transaction){
			session()->flash('notification-status',"failed");
			session()->flash('notification-msg',"Record not found");
			return redirect()->back();
		}
		if($prefix == "RF" AND $transaction->transaction_status != "PENDING") {
			session()->flash('notification-status',"warning");
			session()->flash('notification-msg', "Transaction can not be modified anymore. No more action needed.");
			return redirect()->back();
		}
		try{
			session()->put('transaction.code', $code);

			$request_body = Helper::digipep_transaction([
				'title' => $transaction_data->application_name,
				'trans_token' => $code,
				'transaction_type' => "", 
				'amount' => $amount,
				'penalty_fee' => 0,
				'dst_fee' => 0,
				'particular_fee' => $amount,
				'success_url' => route('web.digipep.success',[$code]),
				'cancel_url' => route('web.digipep.cancel',[$code]),
				'return_url' => route('web.confirmation',[$code]),
				'failed_url' => route('web.digipep.failed',[$code]),
				'first_name' => $transaction->business_name,
				'middle_name' => $transaction_data->business_name,
				'last_name' => $transaction_data->business_name,
				'contact_number' => $transaction_data->contact_number,
				'email' => $transaction_data->email
			]);  
			$response = Curl::to(env('DIGIPEP_CHECKOUT_URL'))
			 		->withHeaders( [
			 			"X-token: ".env('DIGIPEP_TOKEN'),
			 			"X-secret: ".env("DIGIPEP_SECRET")
			 		  ])
			         ->withData($request_body)
			         ->asJson( true )
			         ->returnResponseObject()
			         ->post();	
			 
			if($response->status == "200"){
				$content = $response->content;

				return redirect()->away($content['checkoutUrl']);
			}else{
				Log::alert("DIGIPEP Request System Error ($code): ", array($response));
				session()->flash('notification-status',"failed");
				session()->flash('notification-msg',"There's an error while connecting to our online payment. Please try again.");
				return redirect()->back();
			}

		}catch(\Exception $e){
			DB::rollBack();
			
			session()->flash('notification-status',"failed");
			session()->flash('notification-msg',"Server Error. Please try again.".$e->getMessage());
			return redirect()->back();
		}
	}
}
