<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stack extends Model
{
    public function folders()
    {
        return $this->belongsToMany('App/Models/Folder')->withTimestamps();
    }
}
