<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    public function lists()
    {
        return $this->belongsToMany('App/Models/List')->withTimestamps();
    }
}
