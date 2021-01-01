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
			$mailname = "Bussiness Application Permit";
			$user_email = $value['email'];
            $this->data['data'] = $value['data'];
            $pdf = PDF::loadView('pdf.business-permit',  $this->data['data']);
            $pdf->setPaper('A4', 'landscape');
			Mail::send('emails.digital-certificate-email', $this->data, function($message) use ($mailname,$user_email,$pdf){
				$message->from('eotcph-noreply@ziaplex.biz');
				$message->to($user_email);
                $message->subject("Bussiness Application Permit");
                $message->attachData($pdf->output(), "oBOSS Digital Business Permit.pdf");
			});
		}





	}
}
