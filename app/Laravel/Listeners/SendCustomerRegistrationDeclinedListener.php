<?php
namespace App\Laravel\Listeners;

use App\Laravel\Events\SendCustomerRegistractionDecline;

class SendCustomerRegistrationDeclinedListener{

	public function handle(SendCustomerRegistractionDecline $contact_number){
		$contact_number->job();

	}
}
