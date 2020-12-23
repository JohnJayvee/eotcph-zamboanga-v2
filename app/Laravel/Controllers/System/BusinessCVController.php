<?php

namespace App\Laravel\Controllers\System;

/*
 * Request Validator
 */

/*
 * Models
 */

use App\Laravel\Models\Business;
use App\Laravel\Models\BusinessLine;
use Carbon,Auth,DB,Str,Helper,Event;
use App\Laravel\Requests\PageRequest;
/* App Classes
 */

class BusinessCVController extends Controller
{
    protected $data;
	protected $per_page;

	public function __construct(){
		parent::__construct();
		array_merge($this->data, parent::get_data());
		$this->per_page = env("DEFAULT_PER_PAGE",10);
	}

	public function  index(PageRequest $request){
		$this->data['page_title'] = "Business CV";
		$auth = Auth::user();

        $this->data['business'] = Business::orderBy('created_at',"DESC")->paginate($this->per_page);
		return view('system.business-cv.index',$this->data);
    }

    public function show(PageRequest $request, $id = null)
    {
        $business_cv =  Business::find($id);
        $this->update_status($id);
        $this->data['profile'] = $business_cv;
        $this->data['page_title'] = "Business CV";
        $this->data['business_line'] = BusinessLine::where('business_id', $id)->get();
        return view('system.business-cv.show', $this->data);
    }

    public function update_status($id = null)
    {
        $Business_cv = Business::find($id);
        $Business_cv->isNew = null;
        $Business_cv->save();
    }

	public function  create(PageRequest $request){
		$this->data['page_title'] .= "Application - Add new record";
		return view('system.collection-of-fees.create',$this->data);
    }
	public function store(PageReques $request){

	}

	public function  edit(PageRequest $request,$id = NULL){
		$this->data['page_title'] .= " - Edit record";

		return view('system.business-cv.edit',$this->data);
	}

	public function update(BPLOUpdateRequest $request,$id = NULL){

	}

	public function  destroy(PageRequest $request,$id = NULL){
		DB::beginTransaction();
		try{
			Customer::find($id)->delete();
			DB::commit();
			session()->flash('notification-status', "success");
			session()->flash('notification-msg', "Collection removed successfully.");
			return redirect()->route('system.bplo.index');
		}catch(\Exception $e){
			DB::rollback();
			session()->flash('notification-status', "failed");
			session()->flash('notification-msg', "Server Error: Code #{$e->getMessage()}");
			return redirect()->back();
		}
	}
}
