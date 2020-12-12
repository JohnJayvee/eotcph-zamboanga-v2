<?php
namespace App\Laravel\Listeners;

use App\Laravel\Events\SendCustomerRegistractionActiveEmail;


class SendCustomerRegistrationActiveEmailListener{

	public function handle(SendCustomerRegistractionActiveEmail $email){
		$email->job();

	}
}
