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

			$nexmo = Nexmo::message()->send([
				'to' => '+63'.(int)$phone,
				'from' => 'EOTCPH' ,
				'text' => "Hello ".$fullname.",This is to inform you that your request to create an account in the oBOSS Web Application has been declined by our Admin. Please review the Information, Government IDs, and the Existing Business Permit you have uploaded during the Account Creation Process.If you didn't request this, please ignore this message.",
			]);

		}





	}
}
