<?php 
namespace App\Laravel\Listeners;

use App\Laravel\Events\AuditTrailActivity;

class AuditTrailActivityListener{
	public function handle(AuditTrailActivity $log){
		$log->job();
	}
}
