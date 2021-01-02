<?php
namespace App\Laravel\Events;

use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;

class SendCustomerRegistractionDeclinedEmail extends Event {


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
			$mailname = "oBOSS OTP Verification";
            $user_email =  $value['email'];
            $this->data['fullname'] = $value['name'];
			$this->data['remarks'] = $value['remarks'];
			
			Mail::send('emails.customer-registration-declined-email', $this->data, function($message) use ($mailname,$user_email){
				$message->from('eotcph-noreply@ziaplex.biz');
				$message->to($user_email);
				$message->subject("oBOSS Registration Status");
			});
		}





	}
}
