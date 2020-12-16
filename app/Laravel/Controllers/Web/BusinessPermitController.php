<?php

namespace App\Laravel\Controllers\Web;

use App\Laravel\Models\Business;
use App\Http\Controllers\Controller;
use App\Laravel\Models\BusinessLine;
use App\Laravel\Requests\PageRequest;
use App\Laravel\Services\FileUploader;
use App\Laravel\Models\BusinessActivity;
use App\Laravel\Models\BusinessTransaction;
use Carbon,Auth,Str,Curl,Helper, DB, Log,Event;
use App\Laravel\Models\ApplicationBusinessPermit;
use App\Laravel\Requests\Web\BusinessPermitRequest;
use App\Laravel\Models\ApplicationBusinessPermitFile;
use App\Laravel\Events\SendBusinessPermitConfirmation;

class BusinessPermitController extends Controller{

	protected $data;

	public function __construct(){
		parent::__construct();

	}

	public function create(PageRequest $request){
        $this->data['page_title'] = 'Application Business Permit';
        if (Auth::guard('customer')->user()) {
			$this->data['auth'] = Auth::guard('customer')->user();
            $this->data['business_profiles'] = Business::where('customer_id',$this->data['auth']->id)->get();
            $business = Business::find(session()->get('selected_business_id'));
            $this->data['business'] = $business;
            $this->data['business_line'] = BusinessLine::where('business_id', session()->get('selected_business_id'))->get();

        }
        return view('web.application.business-permit', $this->data);
	}

	public function store(BusinessPermitRequest $request){
        $application_id = session()->get('application_id');
        $application_name = session()->get('application_name');
        $auth = Auth::guard('customer')->user();
        $business = Business::find(session()->get('selected_business_id'));
        $this->data['business'] = $business;
		DB::beginTransaction();
		try{
			$new_business_permit = new ApplicationBusinessPermit();
            $new_business_permit->customer_id = $auth->id;
            $new_business_permit->business_id = $business->id;
            $new_business_permit->status = 'pending';
            $new_business_permit->application_no = $request->application_no;
            $new_business_permit->type = $request->application_type;
            $new_business_permit->save();

            $new_business_transaction = new BusinessTransaction();
            $new_business_transaction->owners_id = $auth->id;
            $new_business_transaction->business_id = $business->id;
            $new_business_transaction->business_name = $business->business_name;
            $new_business_transaction->email = $auth->email;
            $new_business_transaction->contact_number = $auth->contact_number;
            $new_business_transaction->application_id = $application_id;
            $new_business_transaction->application_name = $application_name;
            $new_business_transaction->save();
            $new_business_transaction->code = 'EOTC-' . Helper::date_format(Carbon::now(), 'ym') . str_pad($new_business_transaction->id, 5, "0", STR_PAD_LEFT) . Str::upper(Str::random(3));

            $new_business_transaction->document_reference_code = 'EOTC-DOC-' . Helper::date_format(Carbon::now(), 'ym') . str_pad($new_business_transaction->id, 5, "0", STR_PAD_LEFT) . Str::upper(Str::random(3));
            $new_business_transaction->save();
            foreach ($request->line_of_business as $key => $v) {
                $data = [
                    'application_business_permit_id' => $new_business_permit->id,
                    'line_of_business' => $request->line_of_business [$key],
                    'no_of_unit' => $request->no_of_units [$key],
                    'capitalization' => $request->capitalization [$key],
                    'gross_sales' => $request->renew [$key],
                ];

                BusinessActivity::insert($data);
            }

            $permit_id = $new_business_transaction->id;
            if(count(request('file')) > 0){
                foreach (request('file') as $key => $value) {
                    $new_file = new ApplicationBusinessPermitFile;
                    $file_type = $key;
                    $ext = $value->getClientOriginalExtension();
                    $filename = strtoupper(str_replace('-', ' ', Helper::resolve_file_name($key)). "_" . 'Business Permit') . "." . $ext;
                    $file = FileUploader::upload($value, "uploads/{$permit_id}/file", $filename);
                    $new_file->path = $file['path'];
                    $new_file->directory = $file['directory'];
                    $new_file->filename = $file['filename'];
                    $new_file->application_business_permit_id = $permit_id;
                    $new_file->type = $file_type;
                    $new_file->original_name = $value->getClientOriginalName();
                    $new_file->save();
                }
            }
            DB::commit();

            $insert[] = [
                'email' => $auth->email,
                'name' => $auth->name
            ];

            $notification_data = new SendBusinessPermitConfirmation($insert);
            Event::dispatch('send-business-permit-assessment-confirmation', $notification_data);
            session()->put('successmodal', 1);
            session()->forget('application_id');
            session()->forget('application_name');
			session()->flash('notification-status', "success");
			session()->flash('notification-msg', "Business Permit Added to this Business CV.");
            return redirect()->route('web.business.application.business_permit.create');

		}catch(\Exception $e){
			DB::rollback();
			session()->flash('notification-status', "failed");
			session()->flash('notification-msg', "Server Error: Code #{$e->getMessage()}");
			return redirect()->back();
		}
	}
}
