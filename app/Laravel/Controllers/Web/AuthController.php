<?php

namespace App\Laravel\Controllers\Web;

/*
 * Request Validator
 */

use App\Laravel\Models\Customer;
use App\Laravel\Listeners\SendCode;

use App\Laravel\Models\CustomerOTP;
use App\Http\Controllers\Controller;

/*
 * Models
 */
use App\Laravel\Models\CustomerFile;

use Illuminate\Contracts\Auth\Guard;
use App\Laravel\Requests\PageRequest;
use App\Laravel\Events\SendCustomerOTP;
use App\Laravel\Events\SendCustomerOTPEmail;
use App\Laravel\Requests\Web\RegisterRequest;
use Carbon,Auth,DB,Str,FileUploader,Event,Session,Helper;

class AuthController extends Controller{

	protected $data;

	public function __construct(){
		parent::__construct();

	}

	public function login($redirect_uri = NULL){
        $this->data['page_title'] = " :: Login";
        session(['link' => url()->previous()]);
		return view('web.auth.login',$this->data);
	}
	public function authenticate(PageRequest $request){

		try{
			$this->data['page_title'] = " :: Login";
			$email = $request->get('email');
			$password = $request->get('password');

			if(Auth::guard('customer')->attempt(['email' => $email,'password' => $password])){

				if(Auth::guard('customer')->attempt(['email' => $email,'password' => $password, 'status' => 'approved'])){
                    $user = Auth::guard('customer')->user();
                    session()->put('auth_id', Auth::guard('customer')->user()->id);
                    session()->flash('notification-status','success');
                    session()->flash('notification-msg',"Welcome to EOTC Portal, {$user->full_name}!");

                    return redirect()->route('web.business.index');
                } else if (Auth::guard('customer')->attempt(['email' => $email,'password' => $password, 'status' => 'declined'])){
                    session()->flash('notification-status','error');
                    session()->flash('notification-msg','Your Account has been Declined.');
                    return redirect()->back();
                } else if(Auth::guard('customer')->attempt(['email' => $email,'password' => $password, 'status' => 'pending'])){
                    session()->flash('notification-status','warning');
                    session()->flash('notification-msg','BPLO Activation Required.');
                    return redirect()->back();
                }
			}
			session()->flash('notification-status','error');
			session()->flash('notification-msg','Wrong username or password.');
			return redirect()->back();

		}catch(Exception $e){
			abort(500);
		}
	}

	public function register(){
        session()->forget('register');
        $this->data['page_title'] = " :: Create Account";

        $session_stage = session('register.progress');
        if($session_stage == '2'){
            return redirect()->route('web.register.otp');
        }
		return view('web.auth.registration',$this->data);
    }

    public function sendOTP($contact_number, $email){
        $otp = str_pad(rand('00000', 99999), 6, "0", STR_PAD_LEFT);
        $insert[] = [
            'contact_number' => $contact_number,
            'otp' => $otp,
            'email' => $email,
        ];

        $new_customer_otp = new CustomerOTP;

        $new_customer_otp->customer_mobile_no = $contact_number;
        $new_customer_otp->otp = $otp;

        $new_customer_otp->save();

        // $notification_data = new SendCustomerOTP($insert);
        // Event::dispatch('send-customer-otp', $notification_data);

        $notification_data = new SendCustomerOTPEmail($insert);
        Event::dispatch('send-customer-otp-email', $notification_data);

    }

    public function otpform(PageRequest $request){
        $this->data['page_title'] = " :: OTP";
        return view('web.auth.otp.otp', $this->data);

    }
    public function otp_submit(PageRequest $request){
        $this->data['page_title'] = " :: OTP";

        $account = CustomerOTP::where('otp',request('code'))->first();

        CustomerOTP::where('id',$account->id)->delete();
        session()->flash('notification-status', "success");
        session()->flash('notification-msg','Successfully registered.');
        session()->forget('register');
        return redirect()->route('web.login');

    }
	public function store(RegisterRequest $request){

        DB::beginTransaction();
        try{
            $new_customer = new Customer;
            $new_customer->status = 'pending';
            $new_customer->fname = $request->fname;
            $new_customer->lname = $request->lname;
            $new_customer->mname = $request->mname;
            $new_customer->email = $request->email;
            $new_customer->gender = $request->gender;
            $new_customer->contact_number = $request->contact_number;

            $new_customer->region = $request->region;
            $new_customer->region_name = $request->region_name;
            $new_customer->town = $request->town;
            $new_customer->town_name = $request->town_name;
            $new_customer->barangay = $request->brgy;
            $new_customer->barangay_name = $request->brgy_name;
            $new_customer->street_name = $request->street_name;
            $new_customer->unit_number = $request->unit_number;
            $new_customer->zipcode = $request->zipcode;
            $new_customer->birthdate = $request->birthdate;
            $new_customer->tin_no = $request->tin_no;
            $new_customer->sss_no = $request->sss_no;
            $new_customer->phic_no = $request->phic_no;
            $new_customer->password = bcrypt($request->get('password'));
            $new_customer->save();

            $customer_id = $new_customer->id;
            if(count(request('file')) > 0){
                foreach (request('file') as $key => $value) {
                    $new_file = new CustomerFile;
                    $file_type = $key;
                    $ext = $value->getClientOriginalExtension();
                    $filename = strtoupper(str_replace('-', ' ', Helper::resolve_file_name($key)). "_" . $new_customer->name) . "." . $ext;
                    $file = FileUploader::upload($value, "uploads/{$customer_id}/file", $filename);
                    $new_file->path = $file['path'];
                    $new_file->directory = $file['directory'];
                    $new_file->filename = $file['filename'];
                    $new_file->application_id = 1;
                    $new_file->type = $file_type;
                    $new_file->original_name = $value->getClientOriginalName();
                    $new_file->save();
                }
            }

            $this->sendOTP($request->contact_number, $request->email);

            DB::commit();
            session()->flash('notification-status', "success");
            session()->flash('notification-msg','Successfully registered.');
            session()->put('register.progress', 2);
            return redirect()->route('web.register.otp');
        }catch(\Exception $e){
            dd($e->getMessage());
            DB::rollback();
            session()->flash('notification-status', "failed");
            return redirect()->back();
        }
	}
	public function verify(){
		$this->data['page_title'] = " :: Verify Account";
		return view('web.auth.verify',$this->data);

	}

	public function verified($id = NULL , PageRequest $request){

		$verified_user = User::where('id',$id)->where('code',$request->get('code'))->first();

		if ($verified_user) {
			User::where('id',$id)->update(['active' => "1"]);
			session()->flash('notification-status', "success");
			session()->flash('notification-msg','Your Account has been Successfully verified.');
			return redirect()->route('web.login');
		}
		else{
			Session()->flash('notification-status', "failed");
			session()->flash('notification-msg', "Verification Failed");
			return redirect()->back();
		}

    }

    public function activate(){

        $this->data['page_title'] = " :: Activate Account";
		return view('web.auth.activate',$this->data);
    }

	public function destroy(){
		Auth::guard('customer')->logout();
		session()->forget('auth_id');
		session()->flash('notification-status','success');
		session()->flash('notification-msg','You are now signed off.');
		return redirect()->route('web.login');
	}


}
