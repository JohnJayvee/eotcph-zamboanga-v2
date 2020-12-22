<?php
namespace App\Laravel\Listeners;

use App\Laravel\Events\SendNewBusinessCV;

class SendNewBusinessCVListener{

	public function handle(SendNewBusinessCV $contact_number){
		$contact_number->job();

	}
}
