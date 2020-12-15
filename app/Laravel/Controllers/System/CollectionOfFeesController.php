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
        // dd($this->data);
		return view('system.collection-of-fees.index',$this->data);
	}

	public function  create(PageRequest $request){
		$this->data['page_title'] .= "Application - Add new record";
		return view('system.collection-of-fees.create',$this->data);
	}
	public function store(CollectionFeeRequest $request){
		DB::beginTransaction();

		try{
            $new_collection = new CollectionOfFees();
            $new_collection->collection_name = $request->get('collection_name');
            $new_collection->permit_fee = Helper::money_format($request->get('permit_fee'));
            $new_collection->electrical_fee = Helper::money_format($request->get('electrical_fee'));
            $new_collection->plumbing_fee = Helper::money_format($request->get('plumbing_fee'));
            $new_collection->mechanical_fee = Helper::money_format($request->get('mechanical_fee'));
            $new_collection->signboard_fee = Helper::money_format($request->get('signboard_fee'));
            $new_collection->zoning_fee = Helper::money_format($request->get('zoning_fee'));
            $new_collection->certification_fee_cvo = Helper::money_format($request->get('certification_fee_cvo'));
            $new_collection->health_certificate_fee = Helper::money_format($request->get('health_certificate_fee'));
            $new_collection->certification_fee_tetuan = Helper::money_format($request->get('certification_fee_tetuan'));
            $new_collection->garbage_fee = Helper::money_format($request->get('garbage_fee'));
            $new_collection->inspection_fee = Helper::money_format($request->get('inspection_fee'));
            $new_collection->sanitary_inspection_fee = Helper::money_format($request->get('sanitary_inspection_fee'));
            $new_collection->sticker = Helper::money_format($request->get('sticker'));
            $total = $new_collection->permit_fee +  $new_collection->electrical_fee +
            +  $new_collection->plumbing_fee +  $new_collection->mechanical_fee +  $new_collection->signboard_fee
            +  $new_collection->zoning_fee +  $new_collection->certification_fee_cvo +  $new_collection->health_certificate_fee
            +  $new_collection->certification_fee_tetuan +  $new_collection->garbage_fee +  $new_collection->garbage_fee +  $new_collection->inspection_fee + $new_collection->sanitary_inspection_fee
            +  $new_collection->sticker;
            $new_collection->total_amount =  Helper::money_format($total);
            $new_collection->save();
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
