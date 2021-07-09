<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function stacks()
    {
        return $this->belongsToMany('App\Models\Stack')->withTimestamps();
    }
}
