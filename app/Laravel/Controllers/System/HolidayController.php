<?php

namespace App\Laravel\Controllers\System;

/*
 * Request Validator
 */
use App\Laravel\Requests\PageRequest;
use App\Laravel\Requests\System\HolidayRequest;
/*
 * Models
 */
use App\Laravel\Models\Holiday;
/* App Classes
 */

use Carbon,Auth,DB,Str,Helper;

class HolidayController extends Controller
{
    protected $data;
	protected $per_page;
	
	public function __construct(){
		parent::__construct();
		array_merge($this->data, parent::get_data());
		$this->per_page = env("DEFAULT_PER_PAGE",10);
	}

	public function  index(PageRequest $request){
		$this->data['page_title'] = "Holiday";
		$this->data['keyword'] = Str::lower($request->get('keyword'));

		$this->data['holidays'] = Holiday::where(function($query){
			if(strlen($this->data['keyword']) > 0){
				return $query->WhereRaw("LOWER(name)  LIKE  '%{$this->data['keyword']}%'");
			}
			})->orderBy('created_at',"ASC")->paginate($this->per_page);

			return view('system.holiday.index',$this->data);
	}

	public function  create(PageRequest $request){
		$this->data['page_title'] .= " - Add new record";
		return view('system.holiday.create',$this->data);
	}
	public function store(HolidayRequest $request){
		DB::beginTransaction();
		try{
			$new_holiday = new Holiday;
			$new_holiday->name = $request->get('name');
			$new_holiday->date = $request->get('date');
			$new_holiday->save();
			DB::commit();
			session()->flash('notification-status', "success");
			session()->flash('notification-msg', "New Holiday has been added.");
			return redirect()->route('system.holiday.index');
		}catch(\Exception $e){
			DB::rollback();
			session()->flash('notification-status', "failed");
			session()->flash('notification-msg', "Server Error: Code #{$e->getLine()}");
			return response()->json(['success'=>'errorList','message'=> $e->errors()]);

		}
	}

	public function  edit(PageRequest $request,$id = NULL){
		$this->data['page_title'] .= " - Edit record";
		$this->data['holiday'] = $request->get('holiday_data');
		return view('system.holiday.edit',$this->data);
	}

	public function  update(HolidayRequest $request,$id = NULL){
		DB::beginTransaction();
		try{

			$holiday = $request->get('holiday_data');
			$holiday->name = $request->get('name');
			$holiday->date = $request->get('date');
			$holiday->save();
			DB::commit();
			session()->flash('notification-status', "success");
			session()->flash('notification-msg', "Holiday had been modified.");
			return redirect()->route('system.holiday.index');
		}catch(\Exception $e){
			DB::rollback();
			session()->flash('notification-status', "failed");
			session()->flash('notification-msg', "Server Error: Code #{$e->getLine()}");
			return redirect()->back();
		}
	}

	public function  destroy(PageRequest $request,$id = NULL){
		$holiday = $request->get('holiday_data');
		DB::beginTransaction();
		try{
			$holiday->delete();
			DB::commit();
			session()->flash('notification-status', "success");
			session()->flash('notification-msg', "Holiday removed successfully.");
			return redirect()->route('system.holiday.index');
		}catch(\Exception $e){
			DB::rollback();
			session()->flash('notification-status', "failed");
			session()->flash('notification-msg', "Server Error: Code #{$e->getLine()}");
			return redirect()->back();
		}
	}
}
