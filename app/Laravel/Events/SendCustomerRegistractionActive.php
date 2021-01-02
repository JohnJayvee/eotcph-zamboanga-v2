<?php
namespace App\Laravel\Events;

use Illuminate\Queue\SerializesModels;
use Mail,Str,Helper,Carbon,Nexmo;

class SendCustomerRegistractionActive extends Event {


	use SerializesModels;

	/**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct(array $form_data)
	{
		$this->data = $form_data;
		// $this->email = $form_data['insert'];
	}

	public function job(){


		foreach($this->data as $index =>$value){
			$phone = $value['contact_number'];
			$fullname = $value['name'];

			$phone = '+63'.(int)$phone;
			$sms = Helper::send_sms($phone,"Hello ".$fullname.", This is to inform you that your account is now active. You may now login using the email and password you provided on the Sign Up Application. If you didn't request this, please ignore this message.");
		}





	}
}
