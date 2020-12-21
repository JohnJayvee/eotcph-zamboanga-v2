<?php
namespace App\Laravel\Listeners;

use App\Laravel\Events\SendResetPasswordLink;

class SendResetPasswordListener{

	public function handle(SendResetPasswordLink $email){
		$email->job();

	}
}
