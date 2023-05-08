<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name', 'description','created_by','status','start_date','estimate_date','created_by','updated_by','checklist_id','end_date'
    ];

    public function checklist()
    {
        return $this->hasOne('App\Checklist','checklist_id','id');
    }

    public function user()
    {
        return $this->belongsTo('App\User','created_by')->withTrashed();
    }

}
