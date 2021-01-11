<?php

namespace App\Laravel\Events;

use App\Laravel\Models\ApplicationBusinessPermit;
use Illuminate\Queue\SerializesModels;
use Curl, Carbon;
use Illuminate\Support\Facades\Log;

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
            info('UPLOAD_TO_LOCAL_SUCCESS');
			$transaction = ApplicationBusinessPermit::where("application_no", $data['ebriu_application_no'])->first();
			$transaction->update(['is_posted_on_local' => true]);
		}else{
            Log::error('UPLOAD_LOB_FAILED', ['data' => $data , 'response' => $response]);
        }
	}
}
