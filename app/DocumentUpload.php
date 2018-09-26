<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentUpload extends Model
{
    //
    protected $fillable =['report_id','uploaded_by','path','name'];

    public function uploadedBy()
    {
        return $this->belongsTo('App\User');
    }

    public function report()
    {
     return $this->belongsTo('App\Report');
    }
}
