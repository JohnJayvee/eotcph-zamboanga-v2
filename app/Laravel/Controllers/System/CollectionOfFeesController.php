<?php

namespace App\Laravel\Controllers\System;

/*
 * Request Validator
 */
use Carbon,Auth,DB,Str,Helper;
use App\Laravel\Models\Department;
/*
 * Models
 */
use App\Laravel\Models\Application;
use App\Laravel\Requests\PageRequest;
use App\Laravel\Models\CollectionOfFees;
use App\Laravel\Models\ApplicationRequirements;

/* App Classes
 */
use App\Laravel\Requests\System\ApplicationRequest;
use App\Laravel\Requests\System\CollectionFeeRequest;

class CollectionOfFeesController extends Controller
{
    protected $data;
	protected $per_page;

	public function __construct(){
		parent::__construct();
		array_merge($this->data, parent::get_data());
		$this->data['department'] = ['' => "All Department"] + Department::pluck('name','id')->toArray();
		$this->data['requirements'] =  ApplicationRequirements::pluck('name','id')->toArray();
		$this->per_page = env("DEFAULT_PER_PAGE",10);
	}

	public function  index(PageRequest $request){
		$this->data['page_title'] = "Collection of Fees";
		$auth = Auth::user();

		$this->data['collections'] = CollectionOfFees::all()->paginate($this->per_page);
		return view('system.collection-of-fees.index',$this->data);
	}

	public function  create(PageRequest $request){
		$this->data['page_title'] .= "Application - Add new record";
		return view('system.collection-of-fees.create',$this->data);
	}
	public function store(CollectionFeeRequest $request){
		DB::beginTransaction();
		try{
            $new_collection = CollectionOfFees::create($request->all());
			DB::commit();
			session()->flash('notification-status', "success");
			session()->flash('notification-msg', "New Collection Fee has been added.");
			return redirect()->route('system.collection_fees.index');
		}catch(\Exception $e){
			DB::rollback();
			session()->flash('notification-status', "failed");
			session()->flash('notification-msg', "Server Error: Code #{$e->getMessage()}");
			return redirect()->back();
		}
	}

	public function  edit(PageRequest $request,$id = NULL){
		$this->data['page_title'] .= " - Edit record";
        $this->data['collections'] = $collection = CollectionOfFees::find(1);
		return view('system.collection-of-fees.edit',$this->data);
	}

	public function  update(PageRequest $request,$id = NULL){
		DB::beginTransaction();
		try{
			$update_collection = CollectionOfFees::find($id)->update($request->all());
			DB::commit();
			session()->flash('notification-status', "success");
			session()->flash('notification-msg', "Collection had been modified.");
			return redirect()->route('system.collection-of-fees.index');
		}catch(\Exception $e){
			DB::rollback();
			session()->flash('notification-status', "failed");
			session()->flash('notification-msg', "Server Error: Code #{$e->getMessage()}");
			return redirect()->back();
		}
	}



	public function  destroy(PageRequest $request,$id = NULL){
		DB::beginTransaction();
		try{
			CollectionOfFees::find($id)->delete();
			DB::commit();
			session()->flash('notification-status', "success");
			session()->flash('notification-msg', "Collection removed successfully.");
			return redirect()->route('system.collection-of-fees.index');
		}catch(\Exception $e){
			DB::rollback();
			session()->flash('notification-status', "failed");
			session()->flash('notification-msg', "Server Error: Code #{$e->getMessage()}");
			return redirect()->back();
		}
	}
}
