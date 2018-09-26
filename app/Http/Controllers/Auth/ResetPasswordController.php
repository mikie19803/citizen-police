<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GeneralController;
use App\User;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;


class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function getResetViewSms()
    {
        return view('auth.passwords.sms');
    }

    public function sendResetSms(Request $request)
    {
        $q = new GeneralController();
        $phone = $request->phone;
        $user = User::where('phone',$phone)->first();
        if($user!=null){
            $gen = new GeneralController();
            $confirmation_code =$gen->generateConfirmationCode();
            $message = 'Hello '.$user->name.", Your code for resetting your password is ".$confirmation_code.". The reset link is ".url('password/resetPassword');
            $user->phone_reset_code = $confirmation_code;
            $user->save();
            $res = $q->sendMessage($phone,$message);
//            if($res != )
            Session::flash('success','Reset Code has been sent to the number you entered.');
            return redirect('/password/resetPassword');

        }else{
            return redirect('/password/reset/phone')->withInput()->withErrors([
                'phone'=>'This phone number was not found in the system.']);
        }

    }



    public function getResetPasswordView()
    {
        return view('resetPassword');
    }

    public function resetPassword(Request $request)
    {
        $code = $request->code;
        $password = $request->password;
        $phone = $request->phone;

        $user = User::where(['phone'=>$phone,'phone_reset_code'=>$code])->first();

        if($user!=null){
            Validator::make($request->all(), [
                'password' => 'required|string|min:6|confirmed',
            ])->validate();

            $user->password = bcrypt($password);
            $user->phone_reset_code = null;
            $user->save();

            Session::flash('success','Password has been changed.');

             return redirect('/login');


        }else{
            return redirect()->back()->withInput()->withErrors([
                'user'=>'The code or phone number entered is incorrect.']);
        }





    }
}
