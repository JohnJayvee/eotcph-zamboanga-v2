<?php

namespace App\Laravel\Controllers\System;

/*
 * Request Validator
 */
use App\Laravel\Requests\PageRequest;
use App\Laravel\Requests\System\DepartmentRequest;
use App\Laravel\Requests\System\UploadRequest;
/*
 * Models
 */
use App\Laravel\Models\Department;
/* App Classes
 */
use App\Laravel\Events\AuditTrailActivity;
use App\Laravel\Models\Imports\DepartmentImport;


use Carbon,Auth,DB,Str,Helper,Excel,AuditRequest,Event;

class DepartmentController extends Controller
{
    protected $data;
	protected $per_page;
	
	public function __construct(){
		parent::__construct();
		array_merge($this->data, parent::get_data());
		$this->per_page = env("DEFAULT_PER_PAGE",10);
	}

	public function  index(PageRequest $request){
		$this->data['page_title'] = "Department";
		$this->data['keyword'] = Str::lower($request->get('keyword'));

		$this->data['departments'] = Department::where(function($query){
		if(strlen($this->data['keyword']) > 0){
			return $query->WhereRaw("LOWER(name)  LIKE  '%{$this->data['keyword']}%'");
			}
		})->orderBy('created_at',"ASC")->paginate($this->per_page);
		return view('system.department.index',$this->data);
	}

	public function  create(PageRequest $request){
		$this->data['page_title'] .= " - Add new record";
		return view('system.department.create',$this->data);
	}
	public function store(DepartmentRequest $request){
		$ip = AuditRequest::header('X-Forwarded-For');
		if(!$ip) $ip = AuditRequest::getClientIp();

		DB::beginTransaction();
		try{
			$new_department = new Department;
			$new_department->name = $request->get('name');
			$new_department->code = $request->get('code');
			$new_department->save();

			$log_data = new AuditTrailActivity(['user_id' => Auth::user()->id,'process' => "CREATE DEPARTMENT", 'remarks' => Auth::user()->full_name." has created ".$new_department->name." department successfully.",'ip' => $ip]);
			Event::dispatch('log-activity', $log_data);

			DB::commit();
			session()->flash('notification-status', "success");
			session()->flash('notification-msg', "New Department has been added.");
			return redirect()->route('system.department.index');
		}catch(\Exception $e){
			DB::rollback();
			session()->flash('notification-status', "failed");
			session()->flash('notification-msg', "Server Error: Code #{$e->getLine()}");
			return response()->json(['success'=>'errorList','message'=> $e->errors()]);

		}
	}

	public function  edit(PageRequest $request,$id = NULL){
		$this->data['page_title'] .= " - Edit record";
		$this->data['department'] = $request->get('department_data');
		return view('system.department.edit',$this->data);
	}

	public function  update(DepartmentRequest $request,$id = NULL){
		$ip = AuditRequest::header('X-Forwarded-For');
		if(!$ip) $ip = AuditRequest::getClientIp();

		DB::beginTransaction();
		try{

			$department = $request->get('department_data');
			$department->name = $request->get('name');
			$department->save();

			$log_data = new AuditTrailActivity(['user_id' => Auth::user()->id,'process' => "EDIT DEPARTMENT", 'remarks' => Auth::user()->full_name." has modified ".$department->name." department successfully.",'ip' => $ip]);
			Event::dispatch('log-activity', $log_data);

			DB::commit();
			session()->flash('notification-status', "success");
			session()->flash('notification-msg', "Department had been modified.");
			return redirect()->route('system.department.index');
		}catch(\Exception $e){
			DB::rollback();
			session()->flash('notification-status', "failed");
			session()->flash('notification-msg', "Server Error: Code #{$e->getLine()}");
			return redirect()->back();
		}
	}

	public function  destroy(PageRequest $request,$id = NULL){
		$ip = AuditRequest::header('X-Forwarded-For');
		if(!$ip) $ip = AuditRequest::getClientIp();

		$department = $request->get('department_data');
		DB::beginTransaction();
		try{
			$department->delete();

			$log_data = new AuditTrailActivity(['user_id' => Auth::user()->id,'process' => "REMOVED DEPARTMENT", 'remarks' => Auth::user()->full_name." has deleted ".$department->name." department successfully.",'ip' => $ip]);
			Event::dispatch('log-activity', $log_data);

			DB::commit();
			session()->flash('notification-status', "success");
			session()->flash('notification-msg', "Department removed successfully.");
			return redirect()->route('system.department.index');
		}catch(\Exception $e){
			DB::rollback();
			session()->flash('notification-status', "failed");
			session()->flash('notification-msg', "Server Error: Code #{$e->getLine()}");
			return redirect()->back();
		}
	}

	public function  upload(PageRequest $request){
		$this->data['page_title'] .= " - Bulk Upload Department";
		return view('system.department.upload-department',$this->data);
	}

	public function upload_department(UploadRequest $request) 
	{	
		try {
		    Excel::import(new DepartmentImport, request()->file('file'));

		    session()->flash('notification-status', "success");
			session()->flash('notification-msg', "Importing data was successful.");
			return redirect()->route('system.department.index');
		} catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
		     $failures = $e->failures();
		     
		     foreach ($failures as $failure) {
		         $failure->row(); // row that went wrong
		         $failure->attribute(); // either heading key (if using heading row concern) or column index
		         $failure->errors(); // Actual error messages from Laravel validator
		         $failure->values(); // The values of the row that has failed.
		     }
		   
		    session()->flash('notification-status', "failed");
			session()->flash('notification-msg', "Something went wrong.");
			return redirect()->route('system.department.index');
		}
	    
	}

	
}
