<?php
namespace App\Laravel\Listeners;

use App\Laravel\Events\NotifyBPLOAdminSMS;

class NotifyBPLOAdminSMSListener{

	public function handle(NotifyBPLOAdminSMS $contact_number){
		$contact_number->job();

	}
}
