<?php
namespace App\Laravel\Listeners;

use App\Laravel\Events\SendEmailDigitalCertificate;

class SendEmailDigitalCertificateListener{

	public function handle(SendEmailDigitalCertificate $email){
		$email->job();

	}
}
