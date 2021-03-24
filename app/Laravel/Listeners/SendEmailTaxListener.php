<?php 
namespace App\Laravel\Listeners;

use App\Laravel\Events\SendEmailTaxReference;

class SendEmailTaxListener{

	public function handle(SendEmailTaxReference $email){
		$email->job();

	}
}