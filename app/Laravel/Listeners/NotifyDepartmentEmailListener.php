<?php
namespace App\Laravel\Listeners;

use App\Laravel\Events\NotifyDepartmentEmail;

class NotifyDepartmentEmailListener{

	public function handle(NotifyDepartmentEmail $email){
		$email->job();
	}
}
