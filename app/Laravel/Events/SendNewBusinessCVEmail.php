<?php
namespace App\Laravel\Events;

use Illuminate\Queue\SerializesModels;
use Mail,Str,Helper,Carbon;

class SendNewBusinessCVEmail extends Event {


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
			$mailname = "oBOSS New Business CV Added";
            $user_email =  $value['email'];
            $this->data['businessOwner'] = $value['businessOwner'];
            $this->data['contact_number'] = $value['contact_number'];

			Mail::send('emails.new-business-cv-email', $this->data, function($message) use ($mailname,$user_email){
				$message->from('eotcph-noreply@ziaplex.biz');
				$message->to($user_email);
				$message->subject("New Business CV Added");
			});
		}





	}
}
