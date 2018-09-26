<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','role','confirmation_code',
        'confirmation_status','phone','confirm_time','account_no','voter_id','status','phone_reset_code'
    ];
    protected $appends =['user_role'];
    protected $dates =['confirm_time'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    //relationships

    public function reportedCases() //Citizens reported cases
    {
        return $this->belongsToMany('App\Report','user_reports')->withPivot('user_status');
    }

    public function assignedCases() //officers assigned cases
    {
        return $this->belongsToMany('App\Report','officer_reports')->withPivot('user_status');
    }

    public function uploadedDocuments(){
        return $this->hasMany('App\DocumentUpload');
    }

    public function comments() //user's comments on reports
    {
       return $this->hasMany('App\Comment');
    }

    public function sentInvitations(){ //Invitations user has sent out
        return $this->hasMany('App\CollaboratorRequest','inviteFrom');
    }

    public function receivedInvitations(){ //Invitations user has received
        return $this->hasMany('App\CollaboratorRequest','inviteTo');
    }



    //Attributes
    public function getIsCitizenAttribute(){

        if($this->role=='citizen'){
            return true;
        }else{
            return false;
        }
    }
    public function getIsOfficerAttribute(){

        if($this->role=='officer'){
            return true;
        }else{
            return false;
        }
    }
    public function getIsAdminAttribute(){

        if($this->role=='admin'){
            return true;
        }else{
            return false;
        }
    }

    public function scopeIsConfirmed($query)
    {
        return $query->where([
            'confirmation_status'=>1
        ]);
    }



    public function scopeOfIsCollaborator($query,$report_id)
    {
        $user = $query->first();
        $user_id = $user->id;
        $count = UserReport::where([
            'user_id'=>$user_id,
            'report_id'=>$report_id
        ])->count();
        if($count > 0){
            return true;
        }
        return false;
    }

    public function scopeOfIsCaseOfficer($query,$report_id)
    {
        $user = $query->first();
        $user_id = $user->id;
        $count = OfficerReport::where([
            'user_id'=>$user_id,
            'report_id'=>$report_id
        ])->count();
        if($count > 0){
            return true;
        }
        return false;
    }

    public function getUserRoleAttribute()
    {
        if($this->isCitizen){
            return 'Citizen';
        }else if($this->isOfficer){
            return 'Police Officer';
        }else if($this->isAdmin){
            return 'Administrator';
        }else{
            return $this->role;
        }
    }

}
