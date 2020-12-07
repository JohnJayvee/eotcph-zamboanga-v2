<?php
namespace App\Laravel\Listeners;

use App\Laravel\Events\SendCustomerOTPEmail;

class SendCustomerOTPEmailListener{

	public function handle(SendCustomerOTPEmail $email){
		$email->job();

	}
}
