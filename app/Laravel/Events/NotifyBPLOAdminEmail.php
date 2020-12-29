<?php
namespace App\Laravel\Events;

use Illuminate\Queue\SerializesModels;
use Mail,Str,Helper,Carbon;

class NotifyBPLOAdminEmail extends Event {


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
			$mailname = "oBOSS Business Transaction";
            $user_email = $value['email'];
            $this->data['business_owner'] = $value['business_owner'];
            $this->data['application_no'] = $value['application_no'];

			Mail::send('emails.bplo-admin-notify', $this->data, function($message) use ($mailname,$user_email){
				$message->from('eotcph-noreply@ziaplex.biz');
				$message->to($user_email);
				$message->subject("Business Permit Transaction");
			});
		}





	}
}
