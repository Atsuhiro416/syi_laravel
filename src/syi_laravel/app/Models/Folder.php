<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Folder extends Model
{
    protected $fillable = [
        'name', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function stacks()
    {
        return $this->belongsToMany('App\Models\Stack')->withTimestamps();
    }

    public function isExistsFolderStack($folder_id, $stack_id)
    {
        $isExistsFolderStack = DB::table('folder_stack')->where([
            'folder_id' => $folder_id,
            'stack_id' => $stack_id,
        ])->exists();

        return $isExistsFolderStack;
    }
}
