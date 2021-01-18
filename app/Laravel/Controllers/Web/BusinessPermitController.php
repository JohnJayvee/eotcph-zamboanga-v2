<?php

namespace App\Laravel\Controllers\Web;

use App\Laravel\Models\User;
use App\Laravel\Models\Business;
use Carbon\Carbon as CarbonCarbon;
use App\Http\Controllers\Controller;
use App\Laravel\Models\BusinessLine;
use App\Laravel\Requests\PageRequest;
use App\Laravel\Services\FileUploader;
use App\Laravel\Models\BusinessActivity;
use App\Laravel\Events\NotifyBPLOAdminSMS;
use App\Laravel\Events\NotifyDepartmentSMS;
use App\Laravel\Models\BusinessTransaction;
use App\Laravel\Events\NotifyBPLOAdminEmail;
use App\Laravel\Events\NotifyDepartmentEmail;
use Carbon,Auth,Str,Curl,Helper, DB, Log,Event;
use App\Laravel\Models\ApplicationBusinessPermit;
use App\Laravel\Events\UploadLineOfBusinessToLocal;
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
        $auth = Auth::guard('customer')->user();
        $business = Business::find(session()->get('selected_business_id'));
        $this->data['business'] = $business;

        
         $permits = ApplicationBusinessPermit::where('customer_id', Auth::guard('customer')->user()->id)->where('business_id', $business->id)->where('created_at', 'LIKE', now()->format('Y') .'-%')->where('type', 'renew')->where('status', 'pending')->count();
         if($permits >= 1){
            session()->flash('notification-status',"warning");
            session()->flash('notification-msg',"Sorry, you still have a Pending application for approval. Please wait for BPLO Admin's Feedback.");
            return redirect()->back();
        }
		DB::beginTransaction();
		try{
			$new_business_permit = new ApplicationBusinessPermit();
            $new_business_permit->customer_id = $auth->id;
            $new_business_permit->business_id = $business->id;
            $new_business_permit->status = 'pending';
            $new_business_permit->application_no = strtoupper($request->application_no);
            $new_business_permit->type = $request->type_of_application;
            $new_business_permit->permit_no = $business->permit_no;
            $new_business_permit->save();
            $new_business_permit->application_no = date('y').'-'.str_pad($new_business_permit->id, 5, "0", STR_PAD_LEFT).'-E';
            $new_business_permit->save();

            $new_business_transaction = new BusinessTransaction();
            $new_business_transaction->isNew = 1;
            $new_business_transaction->owners_id = $auth->id;
            $new_business_transaction->business_id = $business->id;
            $new_business_transaction->business_name = $business->business_name;
            $new_business_transaction->email = $auth->email;
            $new_business_transaction->contact_number = $auth->contact_number;
            $new_business_transaction->application_id = session('application_id');
            $new_business_transaction->application_name = session('application_name');
            $new_business_transaction->application_date = Carbon::now();
            $new_business_transaction->business_permit_id = $new_business_permit->id;
            $new_business_transaction->save();
            $new_business_transaction->code = 'EOTC-' . Helper::date_format(Carbon::now(), 'ym') . str_pad($new_business_transaction->id, 5, "0", STR_PAD_LEFT) . Str::upper(Str::random(3));

            $new_business_transaction->document_reference_code = 'EOTC-DOC-' . Helper::date_format(Carbon::now(), 'ym') . str_pad($new_business_transaction->id, 5, "0", STR_PAD_LEFT) . Str::upper(Str::random(3));
            $new_business_transaction->save();

            $list_of_line_of_business_save_to_local = array();
            foreach ($request->line_of_business as $key => $v) {
                $account_code = explode("---", $request->account_code [$key]);
                /**
                 * 0 = line of business name
                 * 1 = reference code
                 * 2 = b class
                 * 3 = s class
                 * 4 = x class
                 * 5 = account code
                 * 6 = particular
                 */
                $data = [
                    'application_business_permit_id' => $new_business_permit->id,
                    'line_of_business' => $new_business_permit->type == "renew" && !$request->is_new [$key] ? $account_code[0] : $request->line_of_business [$key],
                    'no_of_unit' => $request->no_of_units [$key],
                    'capitalization' => $new_business_permit->type == "new" ? $request->amount [$key] : ($request->is_new [$key] ? $request->amount [$key] : 0),
                    'gross_sales' => $new_business_permit->type == "renew" && !$request->is_new [$key] ? $request->amount [$key] : 0,
                    'reference_code' => $account_code [1],
                    'b_class' => $account_code [2],
                    's_class' => $account_code [3],
                    'x_class' => $account_code [4],
                    'account_code' => $account_code [5],
                    'particulars' => $account_code [6]
                ];
                BusinessActivity::insert($data);
                $data = array_merge($data, array("particulars"=>$account_code [6]));
                array_push($list_of_line_of_business_save_to_local, $data);
            }

            $permit_id = $new_business_transaction->id;

            $attachment_count = 0 ;

            if ($request->has('bir_itr_form')) {
                $attachment_count++;
                $file_type = "bir_itr_form";
                $image = request('bir_itr_form');
                $ext = $image->getClientOriginalExtension();
                $filename = strtoupper(str_replace('-', ' ', Helper::resolve_file_name($file_type)). "_" . 'Business Permit') . "." . $ext;
                $file = FileUploader::upload($image, "uploads/{$permit_id}/file", $filename);
                $new_file = new ApplicationBusinessPermitFile;
                $new_file->path = $file['path'];
                $new_file->directory = $file['directory'];
                $new_file->filename = $file['filename'];
                $new_file->application_business_permit_id = $permit_id;
                $new_file->type = $file_type;
                $new_file->original_name = $image->getClientOriginalName();
                $new_file->save();
            }
            if ($request->has('photo_establishment')) {
                $attachment_count++;
                $new_file = new ApplicationBusinessPermitFile;
                $file_type = "photo_establishment";
                $image = request('photo_establishment');
                $ext = $image->getClientOriginalExtension();
                $filename = strtoupper(str_replace('-', ' ', Helper::resolve_file_name($file_type)). "_" . 'Business Permit') . "." . $ext;
                $file = FileUploader::upload($image, "uploads/{$permit_id}/file", $filename);
                $new_file->path = $file['path'];
                $new_file->directory = $file['directory'];
                $new_file->filename = $file['filename'];
                $new_file->application_business_permit_id = $permit_id;
                $new_file->type = $file_type;
                $new_file->original_name = $image->getClientOriginalName();
                $new_file->save();
            }
            DB::commit();
            
            $new_business_transaction->attachment_count = $attachment_count;
            $new_business_transaction->save();

            $insert[] = [
                'email' => $auth->email,
                'name' => $auth->name
            ];

            $request_body = [
                'business_id' => $business->business_id_no,
                'ebriu_application_no' =>  $new_business_permit->application_no,
                'year' => Carbon::now()->year,
                'line_of_business' => $list_of_line_of_business_save_to_local
            ];

            $bplo = User::where('type', 'admin')->first();
            $insert_department[] = [
                'email' => $bplo->email,
                'contact_number' => $bplo->contact_number,
                'business_owner' => Auth::guard('customer')->user()->name,
                'application_no' => $request->application_no,
            ];
            
            $line_of_business_data = new UploadLineOfBusinessToLocal($request_body);
            Event::dispatch('upload-line-of-business-to-local', $line_of_business_data);

            $notification_data = new SendBusinessPermitConfirmation($insert);
            Event::dispatch('send-business-permit-assessment-confirmation', $notification_data);

            // Send event to BPLO Admin

            // Send via SMS
            //$notification_data = new NotifyBPLOAdminSMS($insert_department);
            //Event::dispatch('notify-bplo-admin-sms', $notification_data);

            // send via Email
            $notification_data = new NotifyBPLOAdminEmail($insert_department);
            Event::dispatch('notify-bplo-admin-email', $notification_data);
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
