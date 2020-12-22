<?php

namespace App\Laravel\Controllers\Web;

/*
 * Request Validator
 */
use App\Laravel\Requests\PageRequest;
use App\Laravel\Requests\Web\TransactionRequest;
use App\Laravel\Requests\Web\UploadRequest;
use App\Laravel\Requests\Web\BusinessRequest;
use App\Laravel\Models\{BusinessTransaction,Business,BusinessLine};
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
        $this->data['payment_type'] = $request->get('type') ?:"annually";
        $transaction = BusinessTransaction::where('business_id',$id)->first();
        $this->data['id'] = $id;

        switch ($this->data['payment_type']) {
        	case 'annually':
        		$this->data['total_amount'] = $transaction->total_amount ?: 0;
        		break;
        	case 'semi_annually':
        		$this->data['total_amount'] = $transaction->total_amount ? $transaction->total_amount / 2 : 0;
        		break;
        	case 'quarterly':
        		$this->data['total_amount'] = $transaction->total_amount ? $transaction->total_amount / 4 : 0;
        		break;
        	default:
        		break;
        }
        return view('web.business.payment',$this->data);
    }

    public function payment(PageRequest $request,$id = NULL){
    	try{
			
    		$code = 'PF-' . Helper::date_format(Carbon::now(), 'ym') . str_pad($id, 5, "0", STR_PAD_LEFT) . Str::upper(Str::random(3));
    		$business = BusinessTransaction::where('business_id', $id)->first();
			$request_body = Helper::digipep_transaction([
				'title' => "Business Permit",
				'trans_token' => $code,
				'transaction_type' => "", 
				'amount' => $request->get('amount'),
				'penalty_fee' => 0,
				'dst_fee' => 0,
				'particular_fee' => $request->get('amount'),
				'success_url' => route('web.digipep.success',[$code]),
				'cancel_url' => route('web.digipep.cancel',[$code]),
				'return_url' => route('web.confirmation',[$code]),
				'failed_url' => route('web.digipep.failed',[$code]),
				'first_name' => $business->business_name,
				'middle_name' => $business->business_name,
				'last_name' => $business->business_name,
				'contact_number' => $business->contact_number,
				'email' => $business->email
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
