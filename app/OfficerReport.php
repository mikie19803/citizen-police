<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OfficerReport extends Model
{
    //
    protected $fillable = ['user_id','report_id','status'];

    public function officer()
    {
        return $this->hasOne('App\User');
    }
    public function report()
    {
        return $this->hasOne('App\Report');
    }
}
