<?php

namespace App\Laravel\Controllers\System;

/*
 * Request Validator
 */
use App\Laravel\Requests\PageRequest;
use App\Laravel\Requests\System\BlockListRequest;

/*
 * Models
 */
use App\Laravel\Models\{BlockList,Business,BusinessTransaction,ApplicationBusinessPermit};


/* App Classes
 */
use App\Laravel\Events\AuditTrailActivity;


use Carbon,Auth,DB,Str,Helper,Excel,AuditRequest,Event;

class BlockListController extends Controller
{
    protected $data;
	protected $per_page;
	
	public function __construct(){
		parent::__construct();
		array_merge($this->data, parent::get_data());
		$this->per_page = env("DEFAULT_PER_PAGE",10);
	}

	public function  index(PageRequest $request){
		$this->data['page_title'] = "Block List";
		$this->data['keyword'] = Str::lower($request->get('keyword'));

		$this->data['block_lists'] = BlockList::where(function($query){
		if(strlen($this->data['keyword']) > 0){
			return $query->WhereRaw("LOWER(business_id)  LIKE  '%{$this->data['keyword']}%'");
			}
		})->orderBy('created_at',"ASC")->paginate($this->per_page);
		return view('system.block-list.index',$this->data);
	}
	public function  create(PageRequest $request){
		$this->data['page_title'] .= " - Add new business";
		return view('system.block-list.create',$this->data);
	}

	public function store(BlockListRequest $request){
		$ip = AuditRequest::header('X-Forwarded-For');
		if(!$ip) $ip = AuditRequest::getClientIp();

		DB::beginTransaction();
		try{

			$business_id = $request->get('business_id');

			$business_exist = Business::where('business_id_no',$business_id)->first();

			if (!$business_exist) {
				session()->flash('notification-status', "warning");
				session()->flash('notification-msg', "No Business Record Found.");
				return redirect()->route('system.block_list.create');
			}


			ApplicationBusinessPermit::where('business_id',$business_exist->id)->update(['status' => "declined"]);
			BusinessTransaction::where('business_id',$business_exist->id)->update(['status' => "DECLINED" , 'remarks' => "Cannot proceed with Registration or Renewal. Reason: With pending cases. Please contact City Legal office.", "processed_at" => Carbon::now()]);

			$new_blocked = new BlockList;
			$new_blocked->business_id = $request->get('business_id');
			$new_blocked->code = $request->get('code');
			$new_blocked->save();

			$log_data = new AuditTrailActivity(['user_id' => Auth::user()->id,'process' => "BLOCKED BUSINESS", 'remarks' => Auth::user()->full_name." has blocked ".$new_blocked->business_id." Business successfully.",'ip' => $ip]);
			Event::dispatch('log-activity', $log_data);

			DB::commit();
			session()->flash('notification-status', "success");
			session()->flash('notification-msg', "Business has successfully Blocked.");
			return redirect()->route('system.block_list.index');
		}catch(\Exception $e){
			DB::rollback();
			session()->flash('notification-status', "failed");
			session()->flash('notification-msg', "Server Error: Code #{$e->getLine()}");
			return response()->json(['success'=>'errorList','message'=> $e->errors()]);

		}
	}

	public function unblock(PageRequest $request , $id = NULL){
		$ip = AuditRequest::header('X-Forwarded-For');
		if(!$ip) $ip = AuditRequest::getClientIp();

		try{
			$list = BlockList::find($id);
			$list->unblock = 0;
			$list->save();

			$log_data = new AuditTrailActivity(['user_id' => Auth::user()->id,'process' => "UNBLOCKED BUSINESS", 'remarks' => Auth::user()->full_name." has unblocked ".$list->business_id." Business successfully.",'ip' => $ip]);
			Event::dispatch('log-activity', $log_data);

			DB::commit();
			session()->flash('notification-status', "success");
			session()->flash('notification-msg', "Business has successfully Unblocked.");
			return redirect()->route('system.block_list.index');

		}catch(\Exception $e){
			DB::rollback();
			session()->flash('notification-status', "failed");
			session()->flash('notification-msg', "Server Error: Code #{$e->getLine()}");
			return response()->json(['success'=>'errorList','message'=> $e->errors()]);

		}
	}
}