<?php 
namespace App\Laravel\Listeners;

use App\Laravel\Events\SendEmailApprovedBusiness;

class SendEmailBusinessApprovedListener{

	public function handle(SendEmailApprovedBusiness $email){
		$email->job();
	}
}