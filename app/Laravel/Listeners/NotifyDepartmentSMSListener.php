<?php
namespace App\Laravel\Listeners;

use App\Laravel\Events\NotifyDepartmentSMS;

class NotifyDepartmentSMSListener{

	public function handle(NotifyDepartmentSMS $contact_number){
		$contact_number->job();

	}
}
