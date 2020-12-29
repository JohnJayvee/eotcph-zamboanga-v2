<?php
namespace App\Laravel\Listeners;

use App\Laravel\Events\SendEmailDeclinedBusiness;

class SendEmailBusinessDeclineListener{

	public function handle(SendEmailDeclinedBusiness $email){
		$email->job();
	}
}
