<?php
namespace App\Laravel\Events;

use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;

class SendBusinessPermitConfirmation extends Event {


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
			$mailname = "oBOSS Business Permit Assessment";
            $user_email =  $value['email'];
            $this->data['fullname'] = $value['name'];

			Mail::send('emails.business-permit-assessment-confirmation', $this->data, function($message) use ($mailname,$user_email){
				$message->from('eotcph-noreply@ziaplex.biz');
				$message->to($user_email);
				$message->subject("oBOSS Business Permit Assessment");
			});
		}





	}
}
