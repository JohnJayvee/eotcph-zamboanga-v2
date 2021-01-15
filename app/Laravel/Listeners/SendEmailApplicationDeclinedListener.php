<?php
namespace App\Laravel\Listeners;

use App\Laravel\Events\SendEmailDeclinedApplication;

class SendEmailApplicationDeclinedListener{

	public function handle(SendEmailDeclinedApplication $email){
		$email->job();
	}
}
