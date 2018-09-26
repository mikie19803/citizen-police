<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CollaboratorRequest extends Model
{
    //
    protected $fillable =['inviteFrom','inviteTo','report_id'];

    public function report()
    {
        return $this->belongsTo('App\Report');
    }
    public function invited() //returns  users invited to collaborat on report
    {
        return $this->belongsTo('App\User','inviteTo');
    }
    public function invitor() // returns users who invited collaborations on report
    {
        return $this->belongsTo('App\User','inviteFrom');
    }

}
