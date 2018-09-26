<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CitizensController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('citizen');
    }

    public function edit(){
    	$citizenId = Auth::user()->id;
    	$citizen = User::find($citizenId);
    	return view('citizens.edit')->withCitizen($citizen);
    }

    public function update(Request $request,$id){
    	$user = User::find($id);
    	 $oldemail = $user->email;
    	 $oldphone = $user->phone;

        if($user!=null){
            if($oldemail!=null && strcasecmp($oldemail,$request->email)!=0){
                $validator = Validator::make($request->all(),[
                    'email'=>'email|unique:users'
                ])->validate();
            }
            if($oldphone!=null && strcasecmp($oldphone,$request->phone)!=0){
                $validator = Validator::make($request->all(),[
                    'phone'=>'integer|unique:users'
                ])->validate();
            }
//dd($request->all());
            $user->fill($request->all())->save();
            Session::flash('success','Your information has been updated.');

        }else{
            Session::flash('error','User could not be found.');
        }
        return redirect('/profile');
    }
}
