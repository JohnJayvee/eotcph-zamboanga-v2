<?php

namespace App\Laravel\Controllers\Web;

/*
 * Request Validator
 */

use App\Laravel\Models\Customer;
use App\Laravel\Listeners\SendCode;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;

/*
 * Models
 */
use App\Laravel\Requests\PageRequest;

use App\Laravel\Events\SendCustomerOTP;
use App\Laravel\Events\SendCustomerOTPEmail;
use App\Laravel\Models\CustomerOTP;
use App\Laravel\Requests\Web\RegisterRequest;
use Carbon,Auth,DB,Str,ImageUploader,Event,Session;

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

				$user = Auth::guard('customer')->user();
				session()->put('auth_id', Auth::guard('customer')->user()->id);
				session()->flash('notification-status','success');
				session()->flash('notification-msg',"Welcome to EOTC Portal, {$user->full_name}!");

				return redirect()->route('web.business.index');
			}
			session()->flash('notification-status','error');
			session()->flash('notification-msg','Wrong username or password.');
			return redirect()->back();

		}catch(Exception $e){
			abort(500);
		}
	}

	public function register(){
        // session()->put('register.progress', 1);
		$this->data['page_title'] = " :: Create Account";
		return view('web.auth.registration',$this->data);
    }

    public function sendOTP(PageRequest $request){
        $otp = str_pad(rand('00000', 99999), 6, "0", STR_PAD_LEFT);
        $insert[] = [
            'contact_number' => $request->contact_number,
            'otp' => $otp,
            'email' => $request->email,
        ];

        $new_customer_otp = new CustomerOTP;

        $new_customer_otp->customer_mobile_no = $request->contact_number;
        $new_customer_otp->otp = $otp;

        $new_customer_otp->save();

        // $notification_data = new SendCustomerOTP($insert);
        // Event::dispatch('send-customer-otp', $notification_data);

        $notification_data = new SendCustomerOTPEmail($insert);
        Event::dispatch('send-customer-otp-email', $notification_data);

    }
	public function store(RegisterRequest $request){

        switch(session('register.progress',1)){
            case 1:
                $otp = str_pad(rand('00000', 99999), 6, "0", STR_PAD_LEFT);
                $insert[] = [
                    'contact_number' => $request->contact_number,
                    'otp' => $otp,
                    'email' => $request->email,
                ];

                $new_customer_otp = new CustomerOTP;

                $new_customer_otp->customer_mobile_no = $request->contact_number;
                $new_customer_otp->otp = $otp;

                $new_customer_otp->save();

                $notification_data = new SendCustomerOTPEmail($insert);
                Event::dispatch('send-customer-otp-email', $notification_data);

                session()->put('register.progress', 2);

                session()->put('register.fname', $request->fname);
                session()->put('register.lname', $request->lname);
                session()->put('register.mname', $request->fname);
                session()->put('register.email', $request->email);
                session()->put('register.contact_number', $request->contact_number);
                session()->put('register.region_name', $request->region_name);
                session()->put('register.town', $request->town);
                session()->put('register.town_name', $request->town_name);
                session()->put('register.barangay', $request->barangay);
                session()->put('register.barangay_name', $request->barangay_name);
                session()->put('register.street_name', $request->street_name);
                session()->put('register.unit_number', $request->unit_number);
                session()->put('register.zipcode', $request->zipcode);
                session()->put('register.tin_no', $request->tin_no);
                session()->put('register.sss_no', $request->sss_no);
                session()->put('register.phic_no', $request->phic_no);
                session()->put('register.password', bcrypt($request->get('password')));

                break;
            default:
                DB::beginTransaction();
                try{

                    $account = CustomerOTP::where('otp',request('code'))->first();
                    if(!$account){
                        goto callback;
                    }
                    if ($account) {
                        CustomerOTP::where('id',$account->id)->delete();
                        DB::commit();
                    }
                    $new_customer = new Customer;
                    $new_customer->fname = session('register.fname');
                    $new_customer->lname = session('register.lname');
                    $new_customer->mname = session('register.mname');
                    $new_customer->email = session('register.email');
                    $new_customer->contact_number = session('register.contact_number');

                    $new_customer->region = session('register.region');
                    $new_customer->region_name =session('register.region_name');
                    $new_customer->town = session('register.town');
                    $new_customer->town_name = session('register.town_name');
                    $new_customer->barangay = session('register.barangay');
                    $new_customer->barangay_name= session('register.barangay_name');
                    $new_customer->street_name = session('register.street_name');
                    $new_customer->unit_number = session('register.unit_number');
                    $new_customer->zipcode = session('register.zipcode');
                    $new_customer->birthdate = session('register.birthdate');
                    $new_customer->tin_no = session('register.tin_no');
                    $new_customer->sss_no = session('register.sss_no');
                    $new_customer->phic_no = session('register.phic_no');
                    $new_customer->password = session('register.password');
                    $new_customer->save();

                    DB::commit();
                    session()->flash('notification-status', "success");
                    session()->flash('notification-msg','Successfully registered.');
                    session()->forget('register');
                    return redirect()->route('web.login');
                }catch(\Exception $e){
                    DB::rollback();

                    dd($e->getMessage());
                   goto callback;
                }
                break;
        }
        callback:
        session()->flash('notification-status', "failed");
        return redirect()->back();
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
