<?php
namespace App\Laravel\Listeners;

use App\Laravel\Events\SendCustomerOTP;

class SendCustomerOTPListener{

	public function handle(SendCustomerOTP $contact_number){
		$contact_number->job();

	}
}
