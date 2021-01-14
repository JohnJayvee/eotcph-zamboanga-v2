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
use App\Laravel\Models\BusinessTransaction;
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

        $first_record = Business::orderBy('created_at','ASC')->first();
		$start_date = $request->get('start_date',Carbon::now()->startOfMonth());

		if($first_record){
			$start_date = $request->get('start_date',$first_record->created_at->format("Y-m-d"));
        }
        $this->data['start_date'] = Carbon::parse($start_date)->format("Y-m-d");
		$this->data['end_date'] = Carbon::parse($request->get('end_date',Carbon::now()))->format("Y-m-d");
        $this->data['selected_status'] = $request->status;
		$this->data['selected_processing_fee_status'] = $request->get('processing_fee_status');
		$this->data['keyword'] = Str::lower($request->keyword);

        $this->data['business'] = Business::with(['owner'])
        ->whereHas('owner',function($query){
            if(strlen($this->data['keyword']) > 0){
                return $query->WhereRaw("CONCAT(fname, ' ', mname, '', lname)  LIKE  '%{$this->data['keyword']}%'");
            }
        })
        ->orwhere(function($query){
            if(strlen($this->data['keyword']) > 0){
                return $query->where('business_name', 'like', "%{$this->data['keyword']}%")->orWhere('business_id_no', 'like', "%{$this->data['keyword']}%");
            }
        })
        ->where(DB::raw("DATE(created_at)"),'>=',$this->data['start_date'])
        ->where(DB::raw("DATE(created_at)"),'<=',$this->data['end_date'])
        ->orderBy('created_at',"DESC")->paginate($this->per_page);
        // dd($this->data);
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
        $this->data['page_title'] .= "Edit Business CV";
		$this->data['auth'] = Auth::guard('customer')->user();
        $this->data['business'] = Business::find(session()->get('selected_business_id'));

		return view('system.business-cv.edit',$this->data);
	}

	public function update(BPLOUpdateRequest $request,$id = NULL){

	}

	public function  destroy(PageRequest $request,$id = NULL){
		DB::beginTransaction();
		try{
            $transaction = BusinessTransaction::where('business_id', $id)->first();
            if($transaction){
                $transaction->deleted_by = auth()->guard('user')->user()->id;
                $transaction->save();
            }
            Business::find($id)->forceDelete();
			DB::commit();
			session()->flash('notification-status', "success");
            session()->flash('notification-msg', "The Business CV was successfully deleted.");
			return redirect()->route('system.business_cv.index');
		}catch(\Exception $e){
            DB::rollback();
            throw $e;
			session()->flash('notification-status', "failed");
			session()->flash('notification-msg', "Server Error: Code #{$e->getMessage()}");
			return redirect()->back();
		}
	}
}
