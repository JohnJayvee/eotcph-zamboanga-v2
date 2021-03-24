<?php 
namespace App\Laravel\Listeners;

use App\Laravel\Events\SendEmailViolationReference;

class SendEmailViolationListener{

	public function handle(SendEmailViolationReference $email){
		$email->job();

	}
}