<?php 

namespace App\Laravel\Controllers\Frontend;

use App\Laravel\Requests\PageRequest;
use App\Laravel\Requests\Frontend\{ProfileRequest, AvatarRequest};
use App\Laravel\Requests\Frontend\Profile\EmploymentRequest;
use App\Laravel\Requests\Frontend\PasswordRequest;
use App\Laravel\Requests\Frontend\AddressRequest;

use App\Laravel\Models\User;

use Carbon,Auth,DB,Curl,Str,Helper,Mail,ImageUploader;

class ProfileController extends Controller{

	protected $data;
	
	public function __construct(){
		parent::__construct();
		array_merge($this->data, parent::get_data());
		$this->data['citizenships'] = ['PH' => "Philippines - Filipino"];
		$this->data['civil_statuses'] = ['single' => "Single",'married' => "Married",'separated' =>  "Separated",'widowed' => "Widowed",'divorced' => "Divorced"];
	}

	public function index(){
		$this->data['auth'] = Auth::user();
		return view('frontend.profile.index',$this->data);
	}

	public function password(){
		$this->data['auth'] = Auth::user();
		return view('frontend.profile.password',$this->data);
	}

	public function update_password(PasswordRequest $request){
		$user = Auth::user();
		$user->password = bcrypt($request->get('password'));
		$user->save();

		session()->flash('notification-status','success');
		session()->flash('notification-msg','Passoword successfully modified.');

		return redirect()->route('frontend.profile.index');
	}

	public function edit(){
		$this->data['auth'] = Auth::user();
		return view('frontend.profile.edit',$this->data);
	}

	public function update(ProfileRequest $request){
		$user = Auth::user();
		// $user->fill($request->all());
		$user->firstname = Str::upper($request->get('firstname'));
		$user->middlename = Str::upper($request->get('middlename'));
		$user->lastname = Str::upper($request->get('lastname'));
		$user->gender = Str::upper($request->get('gender'));
		$user->suffix = Str::upper($request->get('suffix'));
		$user->birthdate = Helper::date_db($request->get('birthdate'));
		$user->civil_status = $request->get('civil_status');
		$user->citizenship = $request->get('citizenship');

		$user->mobile_no = $request->get('mobile_no');
		$user->tel_no = $request->get('tel_no');

		if(strlen($user->firstname) > 0 AND strlen($user->lastname) > 0 AND strlen($user->gender) > 0 AND strlen($user->birthdate) > 0 AND strlen($user->mobile_no) > 0){
			$user->personal_completed_at = Carbon::now();
		}else{
			$user->personal_completed_at = DB::raw("NULL");
		}


		$user->save();

		session()->flash('notification-status','success');
		session()->flash('notification-msg','Personal Information successfully modified.');

		return redirect()->route('frontend.profile.index');
	}

	public function edit_address(){
		$this->data['auth'] = Auth::user();
		return view('frontend.profile.edit-address',$this->data);
	}

	public function update_address(AddressRequest $request){
		$user = Auth::user();
		$user->house_no = $request->get('house_no');
		$user->street_address = $request->get('street_address');
		$user->region = $request->get('region');
		$user->region_name = $request->get('region_name');
		$user->province = $request->get('province');
		$user->province = $request->get('province_name');
		$user->town = $request->get('town');
		$user->town_name = $request->get('town_name');
		$user->zipcode = $request->get('zipcode');
		$user->brgy = $request->get('brgy');
		$user->brgy_name = $request->get('brgy_name');

		if(strlen($user->region) > 0 AND strlen($user->town) > 0 AND strlen($user->zipcode) > 0 AND strlen($user->brgy) > 0 AND strlen($user->street_address) > 0){
			$user->address_completed_at = Carbon::now();
		}else{
			$user->address_completed_at = DB::raw("NULL");
		}

		$user->save();

		session()->flash('notification-status','success');
		session()->flash('notification-msg','Address Information successfully modified.');

		return redirect()->route('frontend.profile.index');
	}

	public function edit_employment(){
		$this->data['auth'] = Auth::user();
		return view('frontend.profile.edit-employment',$this->data);
	}

	public function update_employment(EmploymentRequest $request){
		$user = Auth::user();
		$user->sss_no = $request->get('sss_no');
		$user->philhealth_no = $request->get('philhealth_no');
		$user->pagibig_no = $request->get('pagibig_no');
		$user->tin_no = $request->get('tin_no');


		if(strlen($user->sss_no) > 0 AND strlen($user->philhealth_no) > 0 AND strlen($user->pagibig_no) > 0 AND strlen($user->tin_no) > 0){
			$user->employment_completed_at = Carbon::now();
		}else{
			$user->employment_completed_at = DB::raw("NULL");
		}

		$user->save();

		session()->flash('notification-status','success');
		session()->flash('notification-msg','Employment Information successfully modified.');

		return redirect()->route('frontend.profile.index');
	}

	public function verify(PageRequest $request){
		$auth = $request->user();
		$token = base64_encode($auth->email);

		$data = ['token' => $token];
		Mail::send('emails.verify', $data, function($message) use($auth){
			$message->from(env('MAIL_ADDRESS','noreply@domain.com'));
			$message->to($auth->email);
			$message->subject('Email Verification [PBRS]');
		});

		session()->flash('notification-status','success');
		session()->flash('notification-msg','Email verification request was successfully sent to your email.');
		return redirect()->back();
	}

	public function verified($token = NULL){
		$token = base64_decode($token);
	
		$user = User::where('email', Str::lower($token))->first();

		if(!$user){
			session()->flash('notification-status','warning');
			session()->flash('notification-msg','Inavlid token.');
			return redirect()->route('frontend.profile.index');
		}	

		if($user->email_verified_at){
			session()->flash('notification-status',"failed");
			session()->flash('notification-msg',"Account already verified. No more action is needed.");
			return redirect()->route('frontend.profile.index');
		}

		$user->email_verified_at = Carbon::now();
		$user->save();

		session()->flash('notification-status',"success");
		session()->flash('notification-msg',"Account email successfully verified. Thank you for verifying your account.");
		return redirect()->route('frontend.profile.index');
	}

	public function edit_avatar(){
		$this->data['auth'] = Auth::user();
		return view('frontend.profile.upload',$this->data);
	}

	public function update_avatar(AvatarRequest $request){
		$auth = $request->user();

		$file = ImageUploader::upload($request->file('file'), "uploads/images/profile");
        $auth->path = $file['path'];
        $auth->directory = $file['directory'];
        $auth->filename = $file['filename'];

        $auth->save();

        session()->flash('notification-status',"success");
		session()->flash('notification-msg',"Avatar was successfully updated.");
		return redirect()->route('frontend.dashboard');
	}
}	