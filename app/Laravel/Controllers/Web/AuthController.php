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
use App\Laravel\Events\SendResetPasswordLink;
use App\Laravel\Requests\Web\RegisterRequest;
use Carbon,Auth,DB,Str,FileUploader,Event,Session,Helper,Validator,ImageUploader;

class AuthController extends Controller{

	protected $data;

	public function __construct(){
		parent::__construct();

	}

	public function login($redirect_uri = NULL){
        $this->data['page_title'] = " :: Login";
        /*session(['link' => url()->previous()]);*/
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
                        /*$redirect_s = session('link');
                        if($redirect_s){
                            return redirect()->intended($redirect_s);
                            session()->forget('link');
                        } else {*/
                        return redirect()->route('web.business.index');

                } else if(Auth::guard('customer')->attempt(['email' => $email,'password' => $password, 'status' => 'pending' , 'otp_verified' => 0])){
                    Auth::guard('customer')->logout();
                    session()->put('register.progress', 2);
                    session()->put('register.email', $email);
                    return redirect()->route('web.register.otp');

                }
                else if(Auth::guard('customer')->attempt(['email' => $email,'password' => $password, 'status' => 'pending'])){
                    Auth::guard('customer')->logout();
                    session()->flash('notification-status','warning');
                    session()->flash('notification-msg','BPLO Activation Required.');
                    return redirect()->back();
                }else  if(Auth::guard('customer')->attempt(['email' => $email,'password' => $password, 'status' => 'declined' , 'otp_verified' => 1])){
                    Auth::guard('customer')->logout();
                    session()->flash('notification-status','error');
                    session()->flash('notification-msg','Your Account has been Declined.');
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
        if(in_array($session_stage ,['2','3'])){
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

        // Send OTP Code via SMS
        // $notification_data = new SendCustomerOTP($insert);
        // Event::dispatch('send-customer-otp', $notification_data);

        // send OTP Code via Email
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
        $contact_number = session('register.contact_number');
        $email = session('register.email');

        if(!$account){
            // incase of otp failure resend OTP code
            // $this->sendOTP($contact_number, $email);
            return redirect()->back()->withErrors(['otp_code' => trans('Invalid OTP code.')]);;
        } else {
            info('OTP - Email ::  ' . $email);
            $customer = Customer::where('email' ,  $email)->where('status',"PENDING")->first();
            info('OTP - Customer :: ', ['data' =>  $customer->all() ?: '']);
            $customer->otp_verified = '1';
            $customer->save();

            CustomerOTP::where('id',$account->id)->delete();
            auth()->guard('customer')->logout();

            session()->flash('notification-status', "success");
            session()->flash('notification-msg','Successfully registered.');
            // OTP success forget all session
            session()->put('register.progress', 3);
            return redirect()->back();
            // session()->forget('register');
            // return redirect()->route('web.login');
        }
    }
	public function store(RegisterRequest $request){
            DB::beginTransaction();
        try {
            $new_customer = new Customer;
            $new_customer->status = 'pending';
            $new_customer->fname = $request->fname;
            $new_customer->lname = $request->lname;
            $new_customer->mname = $request->mname;
            $new_customer->email = $request->email;
            $new_customer->gender = $request->gender;
            $new_customer->contact_number = $request->contact_number;

            $new_customer->region = '090000000';
            $new_customer->region_name = $request->region_name;
            $new_customer->town = '097332000';
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


            if($request->hasFile('gov_id_1')) {
                $image = $request->file('gov_id_1');
                $ext = $image->getClientOriginalExtension();
                $original_name = $image->getClientOriginalName();
                $file_type = 'gov_id_1';
                $filename = strtoupper(str_replace('-', ' ', Helper::resolve_file_name($file_type)). "_" . $new_customer->name) . "." . $ext;

                $upload_image = FileUploader::upload($image, 'uploads/'.$customer_id.'/file',$filename);

                $new_file = new CustomerFile;
                $new_file->path = $upload_image['path'];
                $new_file->directory = $upload_image['directory'];
                $new_file->filename = $filename;
                $new_file->type = $file_type;
                $new_file->original_name = $original_name;
                $new_file->application_id = $customer_id;
                $new_file->save();
            }

            if($request->hasFile('gov_id_2')) {
                $image = $request->file('gov_id_2');
                $ext = $image->getClientOriginalExtension();
                $original_name = $image->getClientOriginalName();
                $file_type = 'gov_id_2';
                $filename = strtoupper(str_replace('-', ' ', Helper::resolve_file_name($file_type)). "_" . $new_customer->name) . "." . $ext;

                $upload_image = FileUploader::upload($image, 'uploads/'.$customer_id.'/file',$filename);

                $new_file = new CustomerFile;
                $new_file->path = $upload_image['path'];
                $new_file->directory = $upload_image['directory'];
                $new_file->filename = $filename;
                $new_file->type = $file_type;
                $new_file->original_name = $original_name;
                $new_file->application_id = $customer_id;
                $new_file->save();
            }
            if($request->hasFile('business_permit')) {
                $image = $request->file('business_permit');
                $ext = $image->getClientOriginalExtension();
                $original_name = $image->getClientOriginalName();
                $file_type = 'business_permit';
                $filename = strtoupper(str_replace('-', ' ', Helper::resolve_file_name($file_type)). "_" . $new_customer->name) . "." . $ext;

                $upload_image = FileUploader::upload($image, 'uploads/'.$customer_id.'/file',$filename);

                $new_file = new CustomerFile;
                $new_file->path = $upload_image['path'];
                $new_file->directory = $upload_image['directory'];
                $new_file->filename = $filename;
                $new_file->type = $file_type;
                $new_file->original_name = $original_name;
                $new_file->application_id = $customer_id;
                $new_file->save();
            }
            // store contact number and email address to session incase of failure
            session()->put('register.contact_number', $new_customer->contact_number);
            session()->put('register.email', $new_customer->email);

            // fire sendOTP function after above all success
            $this->sendOTP($new_customer->contact_number, $new_customer->email);

            DB::commit();
            session()->flash('notification-status', "success");
            session()->flash('notification-msg','Successfully registered.');
            session()->put('register.progress', 2);
            return redirect()->route('web.register.otp');
        }catch(\Exception $e){
            DB::rollback();
            session()->flash('notification-status', "failed");
            session()->flash('notification-msg', "Server Error: Code #{$e->getMessage()}");
            return redirect()->back();
        }

	}
	public function verify(){
		$this->data['page_title'] = " :: Verify Account";
		return view('web.auth.verify',$this->data);

    }

    public function reset_mail_form(){
		$this->data['page_title'] = " :: Reset Password";
		return view('web.auth.reset.enter_email',$this->data);

    }
    public function reset_email(PageRequest $request){
        $this->data['page_title'] = " :: Reset Password";

        $user = Customer::where('email', $request->email)->first();
        if (!$user) {
            return redirect()->back()->withErrors(['email' => trans('User does not exist')]);
        }

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => Str::random(60),
            'created_at' => Carbon::now()
        ]);

        $tokenData = DB::table('password_resets')
            ->where('email', $request->email)->first();

        if ($this->sendResetEmail($request->email, $tokenData->token)) {
            $this->data['page_title'] = " :: Email Sent!";
            return view('web.auth.reset.email_confirm',$this->data);
        } else {
            return redirect()->back()->withErrors(['error' => trans('A Network Error occurred. Please try again.')]);
        }

    }

    private function sendResetEmail($email, $token)
    {
        $user = Customer::where('email', $email)->select('fname', 'mname', 'lname', 'email')->first();
        $link = url()->to('/') . '/password/reset?token=' . $token . '&email=' . urlencode($user->email);

        try {
        $insert[] = [
            'email' => $email,
            'link' => $link,
            'name' => $user->name,
        ];
        $notification_data = new SendResetPasswordLink($insert);
        Event::dispatch('send-reset-password', $notification_data);

        return true;
        } catch (\Exception $e) {
            return false;
        }
    }
    public function reset_password_form($token = null){
		$this->data['page_title'] = " :: Reset Password";
		return view('web.auth.reset.enter_password',$this->data);
    }

    public function reset_password()
    {
        //Validate input
        $validator = Validator::make(request()->all(), [
            'password' => 'required|confirmed',
            'token' => 'required']);

        //check if payload is valid before moving on
        if ($validator->fails()) {
            return redirect()->back()->withErrors(['password' => 'Please complete the form']);
        }

        $password = request()->password;
        // Validate the token
        $tokenData = DB::table('password_resets')
        ->where('token', request()->token)->first();
        // Redirect the user back to the password reset request form if the token is invalid
        if (!$tokenData) return view('web.auth.reset.enter_email');

        $user = Customer::where('email', $tokenData->email)->first();
        // Redirect the user back if the email is invalid
        if (!$user) return redirect()->back()->withErrors(['email' => 'Email not found']);
        //Hash and update the new password
        $user->password = \Hash::make($password);
        $user->update(); //or $user->save();

        //login the user immediately they change password successfully
        // Auth::login($user);

        //Delete the token
        DB::table('password_resets')->where('email', $user->email)
        ->delete();

        //Send Email Reset Success Email
		return redirect()->route('web.login');
        // if ($this->sendSuccessEmail($tokenData->email)) {
        //     return view('web.auth.reset.enter_password',$this->data);
        // } else {
        //     return redirect()->back()->withErrors(['email' => trans('A Network Error occurred. Please try again.')]);
        // }

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
