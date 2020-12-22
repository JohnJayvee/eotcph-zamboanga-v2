<?php
namespace App\Laravel\Listeners;

use App\Laravel\Events\SendNewBusinessCVEmail;

class SendNewBusinessCVEmailListener{

	public function handle(SendNewBusinessCVEmail $email){
		$email->job();

	}
}
