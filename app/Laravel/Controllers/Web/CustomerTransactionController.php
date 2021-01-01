<?php

namespace App\Laravel\Controllers\Web;

/*
 * Request Validator
 */
use App\Laravel\Requests\PageRequest;
use App\Laravel\Requests\Web\TransactionRequest;
use App\Laravel\Requests\Web\UploadRequest;
use App\Laravel\Requests\Web\CTCRequest;
/*
 * Models
 */
use App\Laravel\Models\{Transaction,Department,RegionalOffice,ApplicationRequirements,Application, BusinessTransaction, TransactionRequirements,OtherCustomer,OtherTransaction,TaxCertificate};


/* App Classes
 */
use App\Laravel\Events\SendReference;
use App\Laravel\Events\SendApplication;
use App\Laravel\Events\SendEorUrl;

use Carbon,Auth,DB,Str,ImageUploader,Event,FileUploader,PDF,QrCode,Helper,Curl,Log,Session;

class CustomerTransactionController extends Controller
{
    protected $data;
	protected $per_page;

	public function __construct(){
		parent::__construct();
		array_merge($this->data, parent::get_data());
		$this->data['genders'] = ['' => "Choose Gender",'male' =>  "Male",'female' => "Female"];
		$this->data['cert_type'] = ['' => "Choose CTC type",'basic' =>  "Basic Community Tax",'salary' =>  "Income From Salary",'business' => "Sales From Business",'property' => "Income from real property taxes"];
		$this->data['civil_status'] = ['' => "Choose Type",'single' =>  "Single",'married' => "Married",'seperated' => "Seperated",'widow' => "Widow"];
		$this->data['department'] = ['' => "Choose Department"] + Department::pluck('name', 'id')->toArray();
		$this->data['regional_offices'] = ['' => "Choose Regional Offices"] + RegionalOffice::pluck('name', 'id')->toArray();
		$this->per_page = env("DEFAULT_PER_PAGE",10);
	}


	public function create(PageRequest $request){
		$this->data['page_title'] = "E-Submission";
		$auth = Auth::guard('customer')->user();
		$type = Session::get('key') ?: $request->get('type');
		switch ($type) {
			case 'e_submission':
				Session::forget('key');
				$this->data['all_requirements'] = ApplicationRequirements::all();
				return view('web.transaction.create',$this->data);
			break;
			case 'ctc':
				Session::forget('key');
				$this->data['other_customer'] = OtherCustomer::where('customer_id', $auth->id)->first();
				return view('web.transaction.ctc',$this->data);
				break;
			default:
				Session::forget('key');
				$this->data['other_customer'] = OtherCustomer::where('customer_id', $auth->id)->first();
				return view('web.transaction.ctc',$this->data);
			break;
		}

	}


	public function store(TransactionRequest $request){
		$temp_id = time();
		$auth = Auth::guard('customer')->user();

		DB::beginTransaction();
		try{
			$new_transaction = new Transaction;
			$new_transaction->company_name = $request->get('company_name');
			$new_transaction->email = $request->get('email');
			$new_transaction->contact_number = $request->get('contact_number');
			// $new_transaction->regional_id = $request->get('regional_id');
			// $new_transaction->regional_name = $request->get('regional_name');
			$new_transaction->customer_id = $auth->id;
			$new_transaction->fname = $auth->fname;
			$new_transaction->lname = $auth->lname;
			$new_transaction->mname = $auth->mname;
			$new_transaction->processing_fee = Helper::db_amount($request->get('processing_fee'));
			$new_transaction->partial_amount = Helper::db_amount($request->get('partial_amount') ?: 0);
			$new_transaction->application_id = $request->get('application_id');
			$new_transaction->application_name = $request->get('application_name');
			$new_transaction->department_id = $request->get('department_id');
			$new_transaction->department_name = $request->get('department_name');
			$new_transaction->payment_status = $request->get('processing_fee') > 0 ? "UNPAID" : "PAID";
			$new_transaction->transaction_status = $request->get('processing_fee') > 0 ? "PENDING" : "COMPLETED";
			$new_transaction->process_by = "customer";
			$new_transaction->save();

			$new_transaction->code = 'EOTC-' . Helper::date_format(Carbon::now(), 'ym') . str_pad($new_transaction->id, 5, "0", STR_PAD_LEFT) . Str::upper(Str::random(3));

			$new_transaction->processing_fee_code = 'PF-' . Helper::date_format(Carbon::now(), 'ym') . str_pad($new_transaction->id, 5, "0", STR_PAD_LEFT) . Str::upper(Str::random(3));

			$new_transaction->transaction_code = 'APP-' . Helper::date_format(Carbon::now(), 'ym') . str_pad($new_transaction->id, 5, "0", STR_PAD_LEFT) . Str::upper(Str::random(3));

			if ($request->get('is_check')) {
				$new_transaction->is_printed_requirements = $request->get('is_check');
				$new_transaction->document_reference_code = 'EOTC-DOC-' . Helper::date_format(Carbon::now(), 'ym') . str_pad($new_transaction->id, 5, "0", STR_PAD_LEFT) . Str::upper(Str::random(3));
			}
			$new_transaction->save();
			if($request->get('requirements_id')) {
				$req_id = explode(",", $request->get('requirements_id'));
				foreach ($req_id as $key => $image) {
					if ($request->file('file'.$image)) {
						$ext = $request->file('file'.$image)->getClientOriginalExtension();
						if($ext == 'pdf' || $ext == 'docx' || $ext == 'doc'){
							$type = 'file';
							$original_filename = $request->file('file'.$image)->getClientOriginalName();
							$upload_image = FileUploader::upload($request->file('file'.$image), "uploads/documents/transaction/{$new_transaction->transaction_code}");
						}
						$new_file = new TransactionRequirements;
						$new_file->path = $upload_image['path'];
						$new_file->directory = $upload_image['directory'];
						$new_file->filename = $upload_image['filename'];
						$new_file->type =$type;
						$new_file->original_name =$original_filename;
						$new_file->transaction_id = $new_transaction->id;
						$new_file->requirement_id = $image;
						$new_file->save();
					}

				}
			}

			DB::commit();

			if($request->get('is_check')) {
				if($new_transaction->customer) {
					$insert_data[] = [
		                'email' => $new_transaction->email,
		                'full_name' => $new_transaction->customer->full_name,
		                'company_name' => $new_transaction->company_name,
		                'department_name' => $new_transaction->department_name,
		                'application_name' => $new_transaction->application_name,
		                'ref_num' => $new_transaction->code,
		                'created_at' => Helper::date_only($new_transaction->created_at),
		                'link' => env("APP_URL")."/physical-copy/".$new_transaction->id,

		            ];
					$application_data = new SendApplication($insert_data);
				    Event::dispatch('send-application', $application_data);
				}
			}
			if($new_transaction->processing_fee > 0){
				return redirect()->route('web.pay', [$new_transaction->processing_fee_code]);
			}

			session()->flash('notification-status', "success");
			session()->flash('notification-msg','Thank you, we have received your application. Our processor in charge will process your application and will inform you of the status');
			return redirect()->route('web.transaction.history');

		}catch(\Exception $e){
			DB::rollback();
			session()->flash('notification-status', "failed");
			session()->flash('notification-msg', "Server Error: Code #{$e->getLine()}");
			return redirect()->back();
		}

	}
	public function other_store(CTCRequest $request){
		$temp_id = time();
		$auth = Auth::guard('customer')->user();
		$other_customer = OtherCustomer::where('customer_id', $auth->id)->first();
		DB::beginTransaction();

			if ($other_customer) {
				$other_customer->contact_number = $request->get('contact_number');
				$other_customer->email = $request->get('email');
				$other_customer->tin_no = $request->get('tin_no');
				$other_customer->citizenship = $request->get('citizenship');
				$other_customer->gender = $request->get('gender');
				$other_customer->birthday = $request->get('birthdate');
				$other_customer->status = $request->get('status');
				$other_customer->place_of_birth = $request->get('place_of_birth');
				$other_customer->height = $request->get('height');
				$other_customer->weight = $request->get('weight');
				$other_customer->occupation = $request->get('occupation');
				$other_customer->save();

			}else{
				$new_other_customer = new OtherCustomer;
				$new_other_customer->customer_id = $auth->id;
				$new_other_customer->firstname = $request->get('firstname');
				$new_other_customer->middlename = $request->get('middlename');
				$new_other_customer->lastname = $request->get('lastname');
				$new_other_customer->address = $request->get('address');
				$new_other_customer->tin_no = $request->get('tin_no');
				$new_other_customer->citizenship = $request->get('citizenship');
				$new_other_customer->gender = $request->get('gender');
				$new_other_customer->birthday = $request->get('birthdate');
				$new_other_customer->status = $request->get('status');
				$new_other_customer->place_of_birth = $request->get('place_of_birth');
				$new_other_customer->height = $request->get('height');
				$new_other_customer->weight = $request->get('weight');
				$new_other_customer->occupation = $request->get('occupation');
				$new_other_customer->email = $request->get('email');
				$new_other_customer->contact_number = $request->get('contact_number');
				$new_other_customer->save();
				$customer_id = $new_other_customer->id;
			}
			$customer_id = $other_customer ? $other_customer->id : $new_other_customer->id;
			$new_other_transaction = new OtherTransaction;
			$new_other_transaction->customer_id = $customer_id;
			$new_other_transaction->type = 2;
			$new_other_transaction->email = $request->get('email');
			$new_other_transaction->contact_number = $request->get('contact_number');
			$new_other_transaction->amount = $request->get('total_amount');
			$new_other_transaction->application_name = "Community Tax Certificate";
			$new_other_transaction->is_local = "no";
			$new_other_transaction->application_date = Carbon::now();
			$new_other_transaction->code = 'EOTC-' . Helper::date_format(Carbon::now(), 'ym') . str_pad($new_other_transaction->id, 5, "0", STR_PAD_LEFT) . Str::upper(Str::random(3));

			$new_other_transaction->processing_fee_code = 'OT-' . Helper::date_format(Carbon::now(), 'ym') . str_pad($new_other_transaction->id, 5, "0", STR_PAD_LEFT) . Str::upper(Str::random(3));

			$new_other_transaction->save();

				$new_tax_certificate = new TaxCertificate;
				$new_tax_certificate->transaction_id = $new_other_transaction->id;
				$new_tax_certificate->other_customer_id = $other_customer ? $other_customer->id : $new_other_customer->id;
				$new_tax_certificate->tax_type = $request->get('ctc_type');
				$new_tax_certificate->additional_tax = $request->get('additional_tax');
				$new_tax_certificate->subtotal = $request->get('subtotal');
				$new_tax_certificate->total_amount = $request->get('total_amount');

			switch ($request->get('ctc_type')) {
				case 'salary':
					$new_tax_certificate->income_salary = $request->get('income_salary');
				break;
				case 'business':
					$new_tax_certificate->business_sales = $request->get('business_sales');
				break;
				case 'salary':
					$new_tax_certificate->income_real_state = $request->get('income_real_state');
				break;
				default:
				break;
			}
			$new_tax_certificate->save();

			DB::commit();
			if($new_other_transaction->amount > 0){
				return redirect()->route('web.pay', [$new_other_transaction->processing_fee_code]);
			}
			session()->flash('notification-status', "success");
			session()->flash('notification-msg','Thank you for applying for the Community Tax Certificate. We will process your application, please wait for the payment reference number to be sent.');
			return redirect()->route('web.transaction.ctc_history');

	}
	public function history(){
		$auth_id = Auth::guard('customer')->user()->id;

		$this->data['transactions'] = Transaction::where('customer_id', $auth_id)->orderBy('created_at',"DESC")->get();
		$this->data['page_title'] = "Application history";
		return view('web.transaction.history',$this->data);

	}
	public function ctc_history(){
		$auth_id = Auth::guard('customer')->user()->id;
		$other_customer = OtherCustomer::where('customer_id' , $auth_id)->first();
		$this->data['tax_transactions'] = [];
		if ($other_customer) {
			$this->data['tax_transactions'] = OtherTransaction::where('customer_id', $other_customer->id)->where('type',2)->orderBy('created_at',"DESC")->get();
		}

		$this->data['page_title'] = "Application history";
		return view('web.transaction.taxhistory',$this->data);

	}
	public function show($id = NULL){

		$this->data['page_title'] = "Application Details";
		$this->data['transaction'] = Transaction::find($id);
		$this->data['attachments'] = TransactionRequirements::where('transaction_id',$id)->get();
		$this->data['count_file'] = TransactionRequirements::where('transaction_id',$id)->count();
		return view('web.transaction.show',$this->data);

	}
	public function ctc_show($id = NULL){

		$this->data['page_title'] = "Application Details";
		$this->data['transaction'] = OtherTransaction::find($id);
		$this->data['ctc'] = TaxCertificate::where('transaction_id',$id)->first();
		return view('web.transaction.ctc-show',$this->data);

	}


	public function payment(PageRequest $request, $code = NULL){
		$this->data['auth'] = Auth::guard('customer')->user();

		$user = Auth::guard('customer')->user()->id;
		$code = $request->has('code') ? $request->get('code') : $code;
		$prefix = explode('-', $code)[0];
		$code = strtolower($code);
		$amount = 0;
		$status = NULL;
		switch (strtoupper($prefix)) {
			case 'APP':
				$transaction = Transaction::whereRaw("LOWER(transaction_code)  =  '{$code}'")->first();
				break;
			case 'OT':
				$transaction = OtherTransaction::whereRaw("LOWER(processing_fee_code)  =  '{$code}'")->first();
				break;
			default:
				$transaction = Transaction::whereRaw("LOWER(processing_fee_code)  =  '{$code}'")->first();
				break;
		}

		if(!$transaction){
			session()->flash('notification-status',"failed");
			session()->flash('notification-msg',"Record not found");
			return redirect()->back();
		}

		$prefix = strtoupper($prefix);

		if($prefix == "APP" AND $transaction->application_transaction_status != "PENDING") {
			session()->flash('notification-status',"warning");
			session()->flash('notification-msg', "Transaction can not be modified anymore. No more action needed.");
			return redirect()->back();
		}

		if($prefix == "PF" AND $transaction->transaction_status != "PENDING" || $prefix == "OT" AND $transaction->transaction_status != "PENDING") {
			session()->flash('notification-status',"warning");
			session()->flash('notification-msg', "Transaction can not be modified anymore. No more action needed.");
			return redirect()->back();
		}

		if($transaction->processing_fee > 0 AND $transaction->payment_status != "PAID" AND $prefix == "APP") {
			session()->flash('notification-status',"warning");
			session()->flash('notification-msg', "You need to settle first the processing fee.");
			return redirect()->back();
		}

		if($transaction->status == "PENDING" AND $prefix == "APP") {
			session()->flash('notification-status',"warning");
			session()->flash('notification-msg', "The processor has not yet validated your application.");
			return redirect()->back();
		}

		$this->data['transaction'] = $transaction;
		$this->data['code'] = $code;
		return view('web.transaction.db-pay', $this->data);
	}

	public function pay(PageRequest $request, $code = null){
		/*$insert[] = [
                'contact_number' => $new_transaction->contact_number,
                'ref_num' => $new_transaction->code
            ];
		$notification_data = new SendReference($insert);
	    Event::dispatch('send-sms', $notification_data);

		$insert_data[] = [
            'email' => $new_transaction->email,
            'name' => $new_transaction->customer->full_name,
            'company_name' => $new_transaction->company_name,
            'department' => $new_transaction->department->name,
            'purpose' => $new_transaction->type->name,
            'ref_num' => $new_transaction->code
        ];
		$application_data = new SendApplication($insert_data);
	    Event::dispatch('send-application', $application_data);*/

		$code = $request->has('code') ? $request->get('code') : $code;
		$prefix = explode('-', $code)[0];

		$code = strtolower($code);
		$amount = 0;
		$status = NULL;
		switch (strtoupper($prefix)) {
			case 'APP':
				$transaction = Transaction::whereRaw("LOWER(transaction_code)  =  '{$code}'")->first();
				break;
			case 'OT':
				$transaction = OtherTransaction::whereRaw("LOWER(processing_fee_code)  =  '{$code}'")->first();
				break;
			default:
				$transaction = Transaction::whereRaw("LOWER(processing_fee_code)  =  '{$code}'")->first();
				break;
		}

		if(!$transaction){
			session()->flash('notification-status',"failed");
			session()->flash('notification-msg',"Record not found");
			return redirect()->back();
		}

		$prefix = strtoupper($prefix);

		if($prefix == "APP" AND $transaction->application_transaction_status != "PENDING") {
			session()->flash('notification-status',"warning");
			session()->flash('notification-msg', "Transaction can not be modified anymore. No more action needed.");
			return redirect()->back();
		}

		if($prefix == "PF" AND $transaction->transaction_status != "PENDING" || $prefix == "OT" AND $transaction->transaction_status != "PENDING") {
			session()->flash('notification-status',"warning");
			session()->flash('notification-msg', "Transaction can not be modified anymore. No more action needed.");
			return redirect()->back();
		}

		if($transaction->processing_fee > 0 AND $transaction->payment_status != "PAID" AND $prefix == "APP") {
			session()->flash('notification-status',"warning");
			session()->flash('notification-msg', "You need to settle first the processing fee.");
			return redirect()->back();
		}

		if($transaction->status == "PENDING" AND $prefix == "APP") {
			session()->flash('notification-status',"warning");
			session()->flash('notification-msg', "The processor has not yet validated your application.");
			return redirect()->back();
		}
		//$amount = $prefix == 'APP' ?  Helper::db_amount($transaction->amount - $transaction->partial_amount) : Helper::db_amount($transaction->processing_fee + $transaction->partial_amount);
		$amount = $prefix == 'APP' || $prefix == 'OT' ? $transaction->amount : $transaction->processing_fee;
		if ($amount == 0) {
			$transaction->application_payment_status = $amount > 0 ? "UNPAID" : "PAID";
			$transaction->application_transaction_status =  $amount > 0 ? "PENDING" : "COMPLETED";
			$transaction->save();
			session()->flash('notification-status', "success");
			session()->flash('notification-msg','Thank you, Your Transaction is completed');
			return redirect()->route('web.transaction.history');
		}
		$customer = $transaction->customer;

		try{
			session()->put('transaction.code', $code);

			$request_body = Helper::digipep_transaction([
				'title' => $transaction->application_name,
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
				'first_name' => $transaction->company_name ? $transaction->company_name : $transaction->customer->firstname,
				'middle_name' => $transaction->company_name ? " " : $transaction->customer->middlename,
				'last_name' => $transaction->company_name ? " " : $transaction->customer->lastname,
				'contact_number' => $transaction->contact_number,
				'email' => $transaction->email
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


	// public function pdf(){
	// 	QrCode::size(500)->format('png')->generate('HDTuto.com', public_path('web/img/qrcode.png'));

	// 	$this->data['qrcode'] =  QrCode::generate('MyNotePaper');
	// 	$pdf = PDF::loadView('emails.sample',$this->data)->setPaper('A4', 'portrait');
 //        return $pdf->stream('sample.pdf');
	// }

	public function upload(PageRequest $request , $code = NULL){
		$code = $request->has('code') ? $request->get('code') : $code;
		$transaction = BusinessTransaction::where('code', $code)->first();

		if(!$transaction){
			session()->flash('notification-status',"failed");
			session()->flash('notification-msg',"Record record not found.");
			return redirect()->route('web.main.index');
		}

		$this->data['transaction'] = $transaction;

		return view('web.page.upload', $this->data);
	}

	public function store_documents(UploadRequest $request , $code = NULL){

		$code = $request->has('code') ? $request->get('code') : $code;
		$transaction = Transaction::where('code', $code)->first();

		if(!$transaction){
			session()->flash('notification-status',"failed");
			session()->flash('notification-msg',"Record record not found.");
			return redirect()->route('web.main.index');
		}

		try{
			DB::beginTransaction();

			$transaction->status = "PENDING";
			$transaction->is_resent = 1;
			$transaction->save();
			$file_id = [];

			//store transaction requirement
			if($request->get('requirement_id')) {
				$req_id = $request->get('requirement_id');
				foreach ($req_id as $key => $image) {
					if ($request->file('file'.$image)) {
						$ext = $request->file('file'.$image)->getClientOriginalExtension();
						if($ext == 'pdf' || $ext == 'docx' || $ext == 'doc'){
							$type = 'file';
							$original_filename = $request->file('file'.$image)->getClientOriginalName();
							$upload_image = FileUploader::upload($request->file('file'.$image), "uploads/documents/transaction/{$transaction->transaction_code}");
						}
						$new_file = new TransactionRequirements;
						$new_file->path = $upload_image['path'];
						$new_file->directory = $upload_image['directory'];
						$new_file->filename = $upload_image['filename'];
						$new_file->type =$type;
						$new_file->original_name =$original_filename;
						$new_file->transaction_id = $transaction->id;
						$new_file->requirement_id = $image;
						$new_file->save();
					}

				}
			}
			DB::commit();

			session()->flash('notification-status',"success");
			session()->flash('notification-msg',"Documents was successfully submitted. Please wait for the processor validate your application. You will received an email once application is approved containing your reference code for payment.");
			return redirect()->route('web.main.index');

		}catch(\Exception $e){
			DB::rollBack();

			session()->flash('notification-status',"failed");
			session()->flash('notification-msg',"Server Error. Please try again.".$e->getMessage());
			return redirect()->back();
		}
	}

	public function request_eor(PageRequest $request){
		$code = $request->has('code') ? $request->get('code') : $code;
		$prefix = explode('-', $code)[0];
		$email = $request->get('email');
		$code = strtolower($code);
		$status = NULL;


		switch (strtoupper($prefix)) {
			case 'APP':
				$transaction = Transaction::whereRaw("LOWER(transaction_code)  =  '{$code}'")->first();
				break;
			case 'OT':
				$transaction = OtherTransaction::whereRaw("LOWER(processing_fee_code)  =  '{$code}'")->first();
				break;
			default:
				$transaction = Transaction::whereRaw("LOWER(processing_fee_code)  =  '{$code}'")->first();
				break;
		}

		if(!$transaction){
			session()->flash('notification-status',"failed");
			session()->flash('notification-msg',"Record not found");
			return redirect()->back();
		}else if ($email == NULL) {
			session()->flash('notification-status',"failed");
			session()->flash('notification-msg',"Please Enter your Email Address");
			return redirect()->back();
		}
		try{
			$full_name = $transaction->fname ." ". $transaction->mname ." " . $transaction->lname;
			$insert[] = [
	        	'email' => $email ? $email : $transaction->email,
	            'ref_num' => $code,
	            'full_name' => $transaction->customer ? $transaction->customer->full_name : $full_name,
	            'eor_url' => $prefix == "pf" ? $transaction->eor_url : $transaction->application_eor_url,
	    	];

			$notification_data = new SendEorUrl($insert);
		    Event::dispatch('send-eorurl', $notification_data);

		    session()->flash('notification-status', "success");
			session()->flash('notification-msg','Your request to get a new copy of EOR was successfully sent to your email. Thank you!.');
			return redirect()->route('web.main.index');
	    }catch(\Exception $e){
			DB::rollBack();

			session()->flash('notification-status',"failed");
			session()->flash('notification-msg',"Server Error. Please try again.".$e->getMessage());
			return redirect()->back();
		}
	}

	public function show_pdf(PageRequest $request , $id){

		$this->data['transaction'] = Transaction::find($id);
		$this->data['attachments'] = TransactionRequirements::where('transaction_id',$id)->where('status',"declined")->get();

		$pdf = PDF::loadView('pdf.declined',$this->data);
		return $pdf->stream("declined.pdf");

	}

	public function physical_pdf(PageRequest $request , $id){

		$this->data['transaction'] = Transaction::find($id);


		$pdf = PDF::loadView('pdf.physical',$this->data);
		return $pdf->stream("physical.pdf");

	}

	public function certificate(PageRequest $request , $id){

		$this->data['transaction'] = Transaction::find($id);
		$pdf = PDF::loadView('pdf.certificate',$this->data);
		return $pdf->stream("certificate.pdf");

	}
}
