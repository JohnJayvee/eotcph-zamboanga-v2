<?php 
namespace App\Laravel\Listeners;

use App\Laravel\Events\UploadLineOfBusinessToLocal;

class UploadLineOfBusinessToLocalListener{

	public function handle(UploadLineOfBusinessToLocal $line_of_business){
		$line_of_business->job();
	}
}