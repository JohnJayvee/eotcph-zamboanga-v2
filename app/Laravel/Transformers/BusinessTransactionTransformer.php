<?php 

namespace App\Laravel\Transformers;

use Input,Str;
use JWTAuth, Carbon, Helper;
use App\Laravel\Models\BusinessTransaction;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use League\Fractal\TransformerAbstract;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Laravel\Transformers\MasterTransformer;

class BusinessTransactionTransformer extends TransformerAbstract{

	protected $availableIncludes = [
    ];


	public function transform(BusinessTransaction $businesstransaction) {

	    return [
	     	'business_id_no' => $businesstransaction->business_info->business_id_no,
	     	'application_number' => $businesstransaction->application_permit->application_no,
	     	
	     ];
	}
}