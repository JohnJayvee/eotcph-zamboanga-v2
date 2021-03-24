<?php
namespace App\Laravel\Events;

use Illuminate\Queue\SerializesModels;
use Mail,Str,Helper,Carbon;

class SendEmailViolationReference extends Event {


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
			$mailname = "Violation";
			$user_email = $value['email'];
			$this->data['ref_num'] = $value['ref_num'];
			$this->data['amount'] = $value['amount'];
			$this->data['full_name'] = $value['full_name'];
			$this->data['violation_name'] = $value['violation_name'];
			$this->data['violation_place'] = $value['violation_place'];
			$this->data['violation_date'] = $value['violation_date'];
			$this->data['ticket_no'] = $value['ticket_no'];

			Mail::send('emails.email-violation', $this->data, function($message) use ($mailname,$user_email){
				$message->from('eotcph-noreply@ziaplex.biz');
				$message->to($user_email);
				$message->subject("Violation Details");
			});
		}





	}
}
