<?php
namespace App\Laravel\Events;

use Illuminate\Queue\SerializesModels;
use Mail,Str,Helper,Carbon;

class SendEmailTaxReference extends Event {


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
			$mailname = "Community Tax Certificate";
			$user_email = $value['email'];
			$this->data['ref_num'] = $value['ref_num'];
			$this->data['amount'] = $value['amount'];
			$this->data['full_name'] = $value['full_name'];
			$this->data['tin_no'] = $value['tin_no'];
			$this->data['tax_type'] = $value['tax_type'];
			$this->data['basic_community'] = $value['basic_community'];
			$this->data['additional_tax'] = $value['additional_tax'];
			$this->data['subtotal'] = $value['subtotal'];
			$this->data['total_amount'] = $value['total_amount'];
			
			Mail::send('emails.email-tax', $this->data, function($message) use ($mailname,$user_email){
				$message->from('eotcph-noreply@ziaplex.biz');
				$message->to($user_email);
				$message->subject("Community Tax Certificate");
			});
		}





	}
}
