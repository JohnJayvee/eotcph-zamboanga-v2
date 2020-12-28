<?php

namespace App\Laravel\Events;

use App\Laravel\Models\ApplicationBusinessPermit;
use Illuminate\Queue\SerializesModels;
use Curl, Carbon;

class UploadLineOfBusinessToLocal extends Event
{
	use SerializesModels;

	/**
	 * Create a new event instance.
	 *
	 * @return void
	 */
	public function __construct(array $form_data)
	{
		$this->data = $form_data;
	}

	public function job()
	{
		$response = Curl::to(env('OBOSS_UPLOAD_LINE_OF_BUSINESS'))
			->withData($this->data)
			->asJson(true)
			->returnResponseObject()
			->post();
		$data = $this->data;
		if ($response->status == "200") {
			$transaction = ApplicationBusinessPermit::where("application_no", $data['ebriu_application_no'])->first();
			$transaction->update(['is_posted_on_local' => true]);
		}
	}
}
