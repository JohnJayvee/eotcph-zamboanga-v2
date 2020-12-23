<?php
namespace App\Laravel\Events;

use Illuminate\Queue\SerializesModels;
use Mail,Str,Helper,Carbon,Nexmo;

class SendNewBusinessCV extends Event {


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
			$businessOwner = $value['businessOwner'];

			$nexmo = Nexmo::message()->send([
				'to' => '+63'.(int)$phone,
				'from' => 'EOTCPH' ,
				'text' => "Hello BPLO Admin! ".$businessOwner." has added a new Business CV.",
            ]);

            // $phone = '63'.(int)$phone;
			// $businessOwner = $value['businessOwner'];
            // $sms = Helper::send_sms($phone,"Hello BPLO Admin! ".$businessOwner." has added a new Business CV.");

		}





	}
}
