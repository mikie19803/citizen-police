<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserReport extends Model
{
    //
    protected $fillable = ['user_id','report_id','status'];
    
    public function citizen()
    {
        return $this->hasOne('App\User');
    }
    public function report()
    {
        return $this->hasOne('App\Report');
    }
}
