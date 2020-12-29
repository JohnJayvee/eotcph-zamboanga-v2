<?php
namespace App\Laravel\Listeners;

use App\Laravel\Events\NotifyBPLOAdminEmail;

class NotifyBPLOAdminEmailListener{

	public function handle(NotifyBPLOAdminEmail $email){
		$email->job();
	}
}
