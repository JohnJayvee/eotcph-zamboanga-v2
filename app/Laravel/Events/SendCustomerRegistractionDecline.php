<?php
namespace App\Laravel\Events;

use Illuminate\Queue\SerializesModels;
use Mail,Str,Helper,Carbon,Nexmo;

class SendCustomerRegistractionDecline extends Event {


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
			$remarks = $value['remarks'];
			
			$phone = '+63'.(int)$phone;
			$sms = Helper::send_sms($phone,"Hello ".$fullname.",This is to inform you that your request to create an account in the oBOSS Web Application has been declined by our Admin. Please review the Remarks, \r\n\n " . $remarks." \r\n\n .If you didn't request this, please ignore this message.");

		}





	}
}
