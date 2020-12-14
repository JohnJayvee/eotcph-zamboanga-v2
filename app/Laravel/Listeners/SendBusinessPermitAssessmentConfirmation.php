<?php
namespace App\Laravel\Listeners;

use App\Laravel\Events\SendBusinessPermitConfirmation;

class SendBusinessPermitAssessmentConfirmation{

	public function handle(SendBusinessPermitConfirmation $email){
		$email->job();
	}
}
