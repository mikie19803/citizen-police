<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    //
    protected $fillable = ['title', 'category_id', 'description', 'extra-description', 'reported_by', 'state','code', 'status', 'attach_code'];

    //relationships

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function reportedBy()
    {
        return $this->belongsTo('App\User', 'reported_by');
    }

    public function citizens()
    {
        return $this->belongsToMany('App\User', 'user_reports')->withPivot('user_status');
    }

    public function officers()
    {
        return $this->belongsToMany('App\User', 'officer_reports')->withPivot('user_status');
    }

    public function uploadedDocuments()
    {
        return $this->hasMany('App\DocumentUpload');
    }

    public function comments() //comments on reports
    {
        return $this->hasMany('App\Comment');
    }

    public function invitations() //collaborator requests on report
    {
        return $this->hasMany('App\CollaboratorRequest');
    }


//    scopes

    public function scopeOfStatus($query, $status)
    {
        return $query->where('status', $status);

    }

    public function getSetNullStateAttribute()
    {
         $this->state='';
        $this->save();
    }


}
