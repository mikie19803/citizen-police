<?php

namespace App\Http\Controllers\Auth;

use App\Citizen;
use App\Http\Controllers\GeneralController;
use App\User;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string/
     *
     *
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('activate');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        if ($data['login-type'] == 'email') {
            return Validator::make($data, [
                'email' => 'required|string|email|max:255|unique:users',
                'name' => 'required|string|max:255',
                'password' => 'required|string|min:6|confirmed',
            ]);

        } else if ($data['login-type'] == 'phone') {

            return Validator::make($data, [
                'phone' => 'required|max:12|unique:users',
                'name' => 'required|string|max:255',
                'password' => 'required|string|min:6|confirmed',
            ]);
        }


    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create(array $data)
    {
        $q = new GeneralController();

        $account_no = $q->generateAccountNumber();
        if ($data['login-type'] == 'email') {
            return User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
                'role' => 'citizen',
                'confirmation_status' => $data['confirmation_status'],
                'confirmation_code' => $data['confirmation_code'],
                'confirm_time' => Carbon::now(),
                'account_no' => $account_no
            ]);
        } elseif ($data['login-type'] == 'phone') {
            return User::create([
                'name' => $data['name'],
                'phone' => $data['phone'],
                'password' => bcrypt($data['password']),
                'role' => 'citizen',
                'confirmation_status' => $data['confirmation_status'],
                'confirmation_code' => $data['confirmation_code'],
                'confirm_time' => Carbon::now(),
                'account_no' => $account_no

            ]);
        }

    }

    protected function verify($code, $status) //for emails
    {
        $q = new GeneralController();
        //Verifies Confirmation Code and login
        $confirmationError = "The url entered is invalid. Kindly click on the url link shown in the confirmation email
            or copy and paste the url in your browser's address bar.<p> It is also possible the account has already been activated.</p>";
        if (!$code || !$status) {
            return view('verify')->with('confirmationError', '' . $confirmationError . '');
        }
        $user = User::whereConfirmationStatus($status)->whereConfirmationCode($code)->first();
        if (!$user) {
            return view('verify')->with('confirmationError', '' . $confirmationError . '');
        } else {
            $user->confirmation_code = null;
            $user->confirmation_status = 1;
            $user->save();
//            $exp = Carbon::createFromFormat('d-M-Y');

            Citizen::create([
                'user_id' => $user->id,
            ]);
            $this->guard()->login($user);
            Session::flash('success', 'Your account has been successfully activated.');
            return redirect('/');
        }

    }

    protected function activate(Request $request)//for phone numbers
    {
        $code = $request->activation_code;

        $user = User::where([
            'confirmation_code' => $code
        ])->first();

        if ($user != null) {
            $count = $user->count();
            if ($count > 0) {
                $user->confirmation_code = '';
                $user->confirmation_status = 1;
                $user->save();
                Session::flash('success','Your account has been activated.');

                $this->guard()->login($user);
                return redirect('/');

            }
        }
        Session::flash('warning', 'The activation code entered is not correct.');
        return redirect('/confirm/code');
    }
}
