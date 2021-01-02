<?php
namespace App\Laravel\Events;

use Illuminate\Queue\SerializesModels;
use Mail,Str,Helper,Carbon,Nexmo;

class NotifyBPLOAdminSMS extends Event {


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
			$otp = $value['otp'];

			// $nexmo = Nexmo::message()->send([
			// 	'to' => '+63'.(int)$phone,
			// 	'from' => 'EOTCPH' ,
			// 	'text' => "Never share your OTP with anyone & verify that you're on the oBOSS official web application. The OTP for your login is ".$otp.". If you didn't request this, please disregard this message.",
            // ]);

            $phone = '63'.(int)$phone;
			$businessOwner = $value['business_owner'];
            $sms = Helper::send_sms($phone,"Never share your OTP with anyone & verify that you're on the oBOSS official web application. The OTP for your login is ".$otp.". If you didn't request this, please disregard this message.");

		}





	}
}
