<?php 
namespace App\Laravel\Events;

use Illuminate\Queue\SerializesModels;
use App\Laravel\Models\AuditTrail;
use Mail,Str,Helper,Carbon,Cache;

class AuditTrailActivity extends Event {

	use SerializesModels;

	/**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct(array $form_data){
		$this->user_id = $form_data['user_id'];
		$this->process = $form_data['process'];
		$this->remarks = $form_data['remarks'];
		$this->ip = $form_data['ip'];
		// $this->cache_expiration = Helper::get_cache_expiry();
	}

	public function job(){
		$new_log = new AuditTrail;
		$new_log->user_id = $this->user_id;
		$new_log->process = $this->process;
		$new_log->remarks = $this->remarks;
		$new_log->ip = $this->ip;
		$new_log->save();
	}

}
