<?php
namespace App\Laravel\Listeners;

use App\Laravel\Events\SendCustomerRegistractionActive;

class SendCustomerRegistrationActiveListener{

	public function handle(SendCustomerRegistractionActive $contact_number){
		$contact_number->job();

	}
}
