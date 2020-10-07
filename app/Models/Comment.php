<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;


class Comment extends Model
{
    use HasFactory;

    public function comments(){
        return $this->hasMany('App\Models\Comment','parent_id')->with(['comments','user']);
    }
    public function user()
    {
        return  $this->belongsTo('App\Models\User');
    }

}
