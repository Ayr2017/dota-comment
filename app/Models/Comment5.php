<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment5 extends Model
{
    use HasFactory;
    protected $table = 'comments_5';
    protected $appends = ['table_name','table_id'];

    public function parent()
    {
        return $this->belongsTo('App\Models\Comment4','parent_id');
    }
    public function user()
    {
        return  $this->belongsTo('App\Models\User');
    }
    public function getTableNameAttribute(){
        return $this->table;
    }
    public function getTableIdAttribute(){
        return explode('_',$this->table)[1];
    }
}
