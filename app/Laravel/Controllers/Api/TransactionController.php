<?php 

namespace App\Laravel\Controllers\Api;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Client;
/* Request validator
 */
use App\Laravel\Requests\PageRequest;
use App\Laravel\Requests\Api\TransactionRequest;
use App\Laravel\Events\SendEmailDigitalCertificate;

/* Models
 */
use App\Laravel\Models\{BusinessTransaction,Business,ApplicationBusinessPermit};


/* Data Transformer
 */
use App\Laravel\Transformers\{TransformerManager, TransactionTransformer,BusinessTransactionTransformer};

/* App classes
 */
use Illuminate\Support\Facades\Auth;
use Carbon,DB,Str,FileUploader,URL,Helper,ImageUploader,Event;
use Exception;
use Illuminate\Http\Request;

class TransactionController extends Controller{
	protected $response = [];
	protected $response_code;
    protected $guard = 'citizen';
    
    protected $data;

	public function __construct(){
		$this->response = array(
			"msg" => "aTotal is not equal to the details",
			"status" => FALSE,
			'status_code' => "Invalid_data"
            );
		$this->response_code = 400;
        $this->transformer = new TransformerManager;
        $this->client = new \GuzzleHttp\Client();
        $this->headers =  [
            'x-token'     => '$2a$12$Pl3qbFzblTbCLOjJipkwYuHuIZ5oqdZpafaBVyqOm43TwaGUVUh4S',
            'x-secret' => 'C4OD0MK757F5UOR89ZJE',
            'Content-Type' => 'application/json',
        ];
    }

	public function  store(TransactionRequest $request, $format = NULL){
        /*
            is "total" is going tobe computed here? or is it already an input value?
        */
        $postrequest = $this->client->post('http://staging.digipep.ziapay.ph/api/transaction/store', [
            'headers' =>  $this->headers,
            'json'  => $request->all()
            ]);
        $this->response= json_decode($postrequest->getBody(), true);
        
        callback:
        switch(Str::lower($format)){
        case 'json' :
            return response()->json($this->response, $this->response_code);
        break;
        case 'xml' :
            return response()->xml($this->response, $this->response_code);
        break;
        }
    }

    public function  show(Request $request, $format = NULL){
        $data = request()->validate([
            'qrCode' => 'required'
        ]);
        try{
        $postrequest = $this->client->post('staging.digipep.ziapay.ph/api/transaction/inquire', [
            'headers' =>  $this->headers,
            'json'  => $data
            ]);
            
        $this->response= json_decode($postrequest->getBody(), true);
        $this->response_code = 200;
        }catch(Exception $e){
            return $e->getMessage();
        }
        
        callback:
        switch(Str::lower($format)){
        case 'json' :
            return response()->json($this->response, $this->response_code);
        break;
        case 'xml' :
            return response()->xml($this->response, $this->response_code);
        break;
        }
    }

    public function list(Request $request , $format = NULL){

        $business_transactions = BusinessTransaction::where("status",'APPROVED')
                            ->orderBy('updated_at',"DESC")->get();

        $this->response['status'] = TRUE;
        $this->response['status_code'] = "TRANSACTION_LIST";
        $this->response['msg'] = "Transaction list.";
        $this->response['data'] = $this->transformer->transform($business_transactions,new BusinessTransactionTransformer,'collection');
        $this->response_code = 200;
        callback:
        switch(Str::lower($format)){
            case 'json' :
                return response()->json($this->response, $this->response_code);
            break;
            case 'xml' :
                return response()->xml($this->response, $this->response_code);
            break;
        }
    }

    public function update(Request $request,$format = NULL){
        $business_cv = Business::where('business_id_no',$request->get('id'))->first();

        $application = ApplicationBusinessPermit::where('application_no', $request->get('application_no'))->first();
        
        if (!$application || !$business_cv) {
            $this->response['status'] = FALSE;
            $this->response['status_code'] = "NO_DATA";
            $this->response['msg'] = "No Resources Found.";
            $this->response_code = 401;
            goto  callback;
        }

        $business_cv->business_plate_no = $request->get('business_plate_no');
        $business_cv->permit_no = $request->get('permit_number');
        $business_cv->save();

        $business_transactions = BusinessTransaction::where('business_permit_id',$application->id)->first();
        $business_transactions->payment_status = $request->get('status');
        $business_transactions->digital_certificate_released = "1";
        $business_transactions->save();

        if ($business_transactions->payment_status == "PAID") {
            $insert[] = [
            'email' => $business_transactions->owner ? $business_transactions->owner->email : $business_transactions->email,
            'business_name' => $business_transactions->business_info ? $business_transactions->business_info->business_name : $business_transactions->business_name,
            'business_id' => $business_transactions->business_id,
            'link' => env("APP_URL")."e-permit/".$business_transactions->business_id,
            ];

            $notification_data_email = new SendEmailDigitalCertificate($insert);
            Event::dispatch('send-digital-business-permit', $notification_data_email);
        }
        
        
        $this->response['status'] = TRUE;
        $this->response['status_code'] = "TRANSCTION_UPDATE";
        $this->response['msg'] = "Business Transaction has been modified.";
        $this->response_code = 200;
        callback:
        switch(Str::lower($format)){
            case 'json' :
                return response()->json($this->response, $this->response_code);
            break;
            case 'xml' :
                return response()->xml($this->response, $this->response_code);
            break;
        }   
    }
}


// $body = [
//     'referenceCode' => $request->referenceCode,
//     "total" => $request->total,
//     "firstname"  => $request->firstname,
//     "lastname"  => $request->lastname,
//     "subMerchantCode"  => $request->subMerchantCode,
//     "subMerchantName"  => $request->subMerchantName,
//     "title"  => $request->title,
//     "emailAddress"  => $request->emailAddress,
//     "contactNumber"  => $request->contactNumber,
//     "returnUrl"  => $request->returnUrl,
//     "successUrl"  => $request->successUrl,
//     "cancelUrl"  => $request->cancelUrl,
//     "failedUrl"  => $request->failedUrl,
//     "details" => [
//         "particularFee" => $request->details["particularFee"],
//         "penaltyFee" => $request->details["penaltyFee"],
//         "dstFee" => $request->details["dstFee"],
//     ]
// ];