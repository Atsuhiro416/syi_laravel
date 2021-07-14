<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stack extends Model
{
    protected $fillable = [
        'name', 'link', 'comment', 'user_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function folders()
    {
        return $this->belongsToMany('App\Models\Folder')->withTimestamps();
    }

    public function showStack($id)
    {
        return Stack::find($id);
    }

    public function showStackWithRelatedFolder($stack_id)
    {
        return Stack::with('folders:id,name')->where('id', $stack_id)->get();
    }
}
