<?php
namespace App\Laravel\Listeners;

use App\Laravel\Events\SendCustomerRegistractionDeclinedEmail;

class SendCustomerRegistrationDeclinedEmailListener{

	public function handle(SendCustomerRegistractionDeclinedEmail $email){
		$email->job();
	}
}
