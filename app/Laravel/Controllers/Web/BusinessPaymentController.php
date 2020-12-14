<?php

namespace App\Laravel\Controllers\Web;

/*
 * Request Validator
 */
use App\Laravel\Requests\PageRequest;
use App\Laravel\Requests\Web\TransactionRequest;
use App\Laravel\Requests\Web\UploadRequest;
use App\Laravel\Requests\Web\BusinessRequest;
use App\Laravel\Models\Business;
use App\Laravel\Models\BusinessLine;
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
        return view('web.business.payment',$this->data);
    }

}
