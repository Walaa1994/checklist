<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Checklist extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'description','created_by'
    ];

    public function tasks()
    {
        return $this->hasMany('App\Task','checklist_id','id');
    }

    public function completedTasks()
    {
        return $this->tasks()->where('status',1);
    }

    public function uncompletedTasks()
    {
        return $this->tasks()->where('status',0);
    }

    public function user()
    {
        return $this->belongsTo('App\User','created_by')->withTrashed();
    }
}
