<?php

namespace App\Http\Controllers;

use App\Mail\NewUserAlert;
use App\User;
use Carbon\Carbon;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;


class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('admin');
    }
    public function index()
    {
        //
        $users = User::where('role','!=','citizen')->orderBy('role','asc')->orderBy('name')->get();
        return view('users.index')->withUsers($users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
         return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $q = new GeneralController();
        $validator = Validator::make($request->all(),[
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6'
        ]);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $password = $request->password;
        $request->merge([
           'confirmation_status'=>1,
            'confirm_time'=>Carbon::now(),
            'account_no'=> $q->generateAccountNumber(),
            'password'=>bcrypt($request->password),
            'name'=>ucwords($request->name)
        ]);
        $user = User::create($request->all());

        Mail::to($user->email)->queue(new NewUserAlert($user,$password));

        Session::flash('User has been created','message');
        return redirect('/user');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect('/user/'.$id.'/edit');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $user = User::find($id);
        return view('users.edit')->withUser($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $user = User::find($id);

        $oldemail = $user->email;


        if($user!=null){
            if(strcasecmp($oldemail,$request->email)!=0){
                $validator = Validator::make($request->all(),[
                    'email'=>'required|email|unique:users'
                ])->validate();
            }

            $user->fill($request->all())->save();
            Session::flash('success','User information has been updated.');

        }else{
            Session::flash('error','User could not be found.');
        }
        return redirect('/user');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $user = User::find($id);
        if($user!=null){
            $user->delete();
        }
        echo 1;
    }
}
