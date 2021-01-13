<?php

namespace App\Laravel\Controllers\System;

use Auth, Session,Carbon, Helper,Route, Request,Str;

use App\Laravel\Controllers\Controller as BaseController;
use  App\Laravel\Models\{AttendanceOvertime,AttendanceLeave, Business, BusinessTransaction, Transaction};

class Controller extends BaseController{

	protected $data;

	public function __construct(){
		self::set_system_routes();
		self::set_date_today();
		self::set_current_route();
		self::set_badges();
		self::set_auth();
		self::get_new_cv_count();
		self::get_new_cv();
		self::get_business_permit_count();
		self::get_business_permit_cv();

	}

	public function get_data(){
		$this->data['page_title'] = env("APP_NAME","");
		return $this->data;
	}

	public function set_auth(){
		$this->data['auth'] = Auth::user();
	}

	public function set_system_routes(){
		$this->data['routes'] = [
			'dashboard' => "system.dashboard"
		];
	}

	public function set_badges(){
		$auth = Auth::user();

		if($auth){
		$this->data['counter'] = [
			'pending' => Transaction::where('status','PENDING')->where('is_resent',0)->count(),
			'approved' => Transaction::where('status','APPROVED')->count(),
			'declined' => Transaction::where('status','DECLINED')->count(),
			'resent' => Transaction::where('status',"PENDING")->where('is_resent',1)->count()
			// 'pending_leave' =>  AttendanceLeave::where('employee_id',$auth->id)->where('status','for_approval')->count(),

			// 'all_pending_overtime' => AttendanceOvertime::where('status','for_approval')->count(),
			// 'all_pending_leave' => AttendanceLeave::where('status','for_approval')->count(),

		];

			// $this->data['counter']['for_approval'] = $this->data['counter']['pending_overtime']+$this->data['counter']['pending_leave'];

			// $this->data['counter']['all_pending'] = $this->data['counter']['all_pending_overtime']+$this->data['counter']['all_pending_leave'];
		}

	}

	public function set_suffixes(){
		$this->data['suffixes'] = [
			'' => "--Select Suffix--", 'JR' => "Jr/Junior", 'SR' => "Sr/Senior", 'I' => "I", 'II' => "II", 'III' => "III",'IV' => "IV",'V' => "V",'VI' => "VI",'VII' => "VII",'VIII' => "VIII",'IX' => "IX",'X' => "X",
		];
	}


	public function set_current_route(){
		 $this->data['current_route'] = Route::currentRouteName();
	}

	public function set_date_today(){
		$this->data['date_today'] = Helper::date_db(Carbon::now());
    }

    public function get_new_cv_count(){
        $business = Business::where('isNew', '1')->count();
        $business_transaction = BusinessTransaction::where('isNew', '1')->count();
        $for_approval = BusinessTransaction::where('for_bplo_approval', '1')->count();

        $notifications = $business + $business_transaction + $for_approval;
        $this->data['new_notification_count'] = $notifications;

    }

    public function get_new_cv(){
        $business = Business::where('isNew', '1');
        $business_transaction = BusinessTransaction::where('isNew', '1');
        $for_approval = BusinessTransaction::where('for_bplo_approval', '1');

        $notifications = $business->get()->merge($business_transaction->get())->merge($for_approval->get())->sortByDesc('created_at');
        $this->data['new_business_cv'] = $notifications;
        $this->data['notif_count'] = $business->count() +  $business_transaction->where('for_bplo_approval', '!=' ,'1')->count() + $for_approval->where('isNew', '1')->count();
        // dd($this->data);
    }

    public function get_business_permit_count(){
        $this->data['new_business_permit_cv_count'] = BusinessTransaction::where('isNew', '1')->count();
    }

    public function get_business_permit_cv(){
        $this->data['new_business_permit_cv'] = BusinessTransaction::where('isNew', '1')->get();
    }



}
