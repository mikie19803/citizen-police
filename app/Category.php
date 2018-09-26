<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $fillable =['category','description','status'];

    public function cases()
    {
        return $this->hasMany('App\Category');
    }

    public function scopeActive($query){
        return $query->where('status','active');
    }
}
