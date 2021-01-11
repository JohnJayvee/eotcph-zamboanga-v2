<?php
namespace App\Laravel\Events;

use Illuminate\Queue\SerializesModels;
use Mail,Str,Helper,Carbon,PDF;

class SendEmailDigitalCertificate extends Event {


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
			$mailname = "Digital Certificate";
			$user_email = $value['email'];
			$this->data['business_name'] = $value['business_name'];
			$this->data['business_id'] = $value['business_id'];
			$this->data['link'] = $value['link'];
            // $pdf = PDF::loadView('pdf.business-declined', $this->data);
			Mail::send('emails.digital-certificate-email', $this->data, function($message) use ($mailname,$user_email){
				$message->from('eotcph-noreply@ziaplex.biz');
				$message->to($user_email);
                $message->subject("Digital Certificate");
                // $message->attachData($pdf->output(), "Document Reference Number.pdf");
			});
		}





	}
}
