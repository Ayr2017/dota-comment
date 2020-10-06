<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Comment3 extends Model
{
    use HasFactory;
    protected $table = 'comments_3';
    protected $appends = ['table_name','table_id'];

    public function comments()
    {
        $request = new Request();
        $sort_by = $request->sort_by ?? 'rating';
        $sort_dir = $request->sort_dir ??'desc';
        return $this->hasMany('App\Models\Comment4', 'parent_id')->with(['comments','user'])->orderBy($sort_by, $sort_dir );
    }
    public function user()
    {
        return  $this->belongsTo('App\Models\User');
    }
    public function parent()
    {
        return $this->belongsTo('App\Models\Comment2','parent_id');
    }
    public function getTableNameAttribute(){
        return $this->table;
    }
    public function getTableIdAttribute(){
        return explode('_',$this->table)[1];
    }
}
