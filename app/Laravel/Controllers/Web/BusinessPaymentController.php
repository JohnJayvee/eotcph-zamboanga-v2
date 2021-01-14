<?php

namespace App\Laravel\Controllers\Web;

/*
 * Request Validator
 */
use App\Laravel\Requests\PageRequest;
use App\Laravel\Requests\Web\UploadRequest;
use App\Laravel\Requests\Web\BusinessRequest;
use App\Laravel\Models\{BusinessTransaction,Business,BusinessLine,BusinessFee,RegulatoryPayment,BusinessTaxPayment};
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
			$this->data['quarters'] = ['1' => "1st Quarter" , '2' => "2nd Quarter" , '3' => "3rd Quarter" , '4' => "4th Quarter"];

		}
		$this->per_page = env("DEFAULT_PER_PAGE",10);
	}
    public function index(PageRequest $request , $id = NULL){
        $this->data['page_title'] = "Business Payment Method";
        $this->data['auth'] = Auth::guard('customer')->user();
        $this->data['payment_type'] = $request->get('type') ?:"0";

        $this->data['profile'] = Business::find($id);
        $this->data['transaction'] = BusinessTransaction::where('business_id',$id)->first();

        if (!$this->data['transaction']) {
        	session()->flash('notification-status',"failed");
			session()->flash('notification-msg', "No Transaction For this business Found.");
			return redirect()->back();
		}
		
        $this->data['business_fee'] = BusinessFee::where('transaction_id', $this->data['transaction']->id)->where('fee_type' , $this->data['payment_type'])->where('payment_status' ,"PENDING")->get();
        
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
				'first_name' => $transaction_data->business_name,
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

	public function tax_fee (PageRequest $request, $id = NULL){
		$this->data['page_title'] = "Business Tax Payment Details";
        $this->data['auth'] = Auth::guard('customer')->user();
        $this->data['transaction_id'] = $id;
        $this->data['quarter'] = $request->get('quarter') ;
        $this->data['fee_type'] = $request->get('type') ;

        switch ($this->data['quarter']) {
        	case '1':
        		$q = [1];
        		break;
        	case '2':
        		$q = [1,2];
        		break;
        	case '3':
        		$q = [1,2,3];
        		break;
        	case '4':
        		$q = [1,2,3,4];
        		break;
        	default:
        		break;
        }

        $this->data['business_tax_payment'] = BusinessTaxPayment::where('transaction_id', $id)->whereIn('quarter' , $q)->where('fee_type',$this->data['fee_type'])->where('payment_status',"UNPAID")->get();

        return view('web.business.tax_fee',$this->data);
	}

	public function payment(PageRequest $request, $id= NULL){

		$this->data['quarter'] = $request->get('quarter');
		$this->data['fee_type'] = $request->get('type') ;

		$transaction_data = BusinessTransaction::find($id);

		$business = BusinessTaxPayment::where('transaction_id', $id)->where('quarter' , 1)->where('fee_type',$this->data['fee_type'])->where('payment_status',"UNPAID")->first();
		$quarter = BusinessTaxPayment::where('transaction_id', $id)->where('quarter' , $this->data['quarter'])->where('fee_type',$this->data['fee_type'])->where('payment_status',"UNPAID")->first();

		$code = $quarter->transaction_code;
		$dt = Carbon::parse($business->due_date);
		$due_date = "";

		if ($dt->isWeekday() == true) {
			$due_date = $dt;
		}else{
			if (str::lower($dt->format("l")) == "saturday") {
				$due_date = $dt->addDays(2);
			}else{
				$due_date = $dt->addDays(1);
			}
		}

		switch ($this->data['quarter']) {
        	case '1':
        		$q = [1];
        		break;
        	case '2':
        		$q = [1,2];
        		break;
        	case '3':
        		$q = [1,2,3];
        		break;
        	case '4':
        		$q = [1,2,3,4];
        		break;
        	default:
        		break;
        }

		$payment = BusinessTaxPayment::where('transaction_id', $id)->whereIn('quarter' , $q)->where('fee_type',$this->data['fee_type'])->where('payment_status',"UNPAID")->get();

        $total_amount = $payment->sum('amount') + $payment->sum('surcharge');

        if (($this->data['quarter'] == 4) and (Carbon::now()->format('Y-m-d') < $due_date->format('Y-m-d')) and (count($payment) == 4)) {
        	$discount = $business->amount * .10;
        	foreach ($payment as $key => $value) {
        		BusinessTaxPayment::where('transaction_id',$id)->where('fee_type',$this->data['fee_type'])->update(['discount' => $discount]);
        	}
        	$total_amount = $payment->sum('amount') + $payment->sum('surcharge') - $payment->sum('discount');
        }

		try{
			session()->put('transaction.code', $code);

			$request_body = Helper::digipep_transaction([
				'title' => $transaction_data->application_name,
				'trans_token' => $code,
				'transaction_type' => "",
				'amount' => $total_amount,
				'penalty_fee' => 0,
				'dst_fee' => 0,
				'particular_fee' => $total_amount,
				'success_url' => route('web.digipep.success',[$code]),
				'cancel_url' => route('web.digipep.cancel',[$code]),
				'return_url' => route('web.confirmation',[$code]),
				'failed_url' => route('web.digipep.failed',[$code]),
				'first_name' => $transaction_data->business_name,
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

    public function download_assessment(PageRequest $request,$id=NULL){

        $this->data['transaction'] = BusinessTransaction::find($id);
		
		BusinessFee::where("transaction_id",$this->data['transaction']->id)->where("fee_type", 0)->get();

		$this->data['regulatory_fees'] = BusinessFee::where('transaction_id', $this->data['transaction']->id)->where('fee_type', 0)->get();

		$this->data['business_tax'] = BusinessFee::where('transaction_id', $this->data['transaction']->id)->where('fee_type', 1)->first();

		$this->data['garbage_fee'] = BusinessFee::where('transaction_id', $this->data['transaction']->id)->where('fee_type', 2)->first();

		 $this->data['business_activity'] = DB::table('business_activities as activity')
                                        ->leftjoin('business_line', 'activity.application_business_permit_id', '=', 'business_line.business_id')
                                        ->select('business_line.name as bLine', 'business_line.gross_sales as bGross' ,'activity.*')
                                        ->where('activity.application_business_permit_id', $this->data['transaction']->business_id)
                                        ->groupBy('application_business_permit_id')
                                        ->get();

		/*$business_tax = DB::table('business_fee')
			->leftjoin('department', 'department.code', '=', 'business_fee.office_code')
			->select('business_fee.*','department.*')
			->where('business_fee.transaction_id', $this->data['transaction']->id)
			->where('business_fee.fee_type', 1)
			->first();
		$this->data['business_tax'] = $business_tax ;

		$this->data['garbage_fee'] = DB::table('business_fee')
			->leftjoin('department', 'department.code', '=', 'business_fee.office_code')
			->select('business_fee.*','department.*')
			->where('business_fee.transaction_id', $this->data['transaction']->id)
			->where('business_fee.fee_type', 2)
			->first();*/
		
       
                                        
      	$pdf = PDF::loadView('pdf.business-permit-assessment-details',$this->data)->setPaper('a4', 'landscape');

        return $pdf->download("business-permit-assessment-details.pdf");

      
        //return view('pdf.business-permit-assessment-details', $this->data);
    }
}
