<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Comment4 extends Model
{
    use HasFactory;
    protected $table = 'comments_4';
    protected $appends = ['table_name','table_id'];

    public function comments()
    {
        $request = new Request();
        $sort_by = $request->sort_by ?? 'rating';
        $sort_dir = $request->sort_dir ??'desc';
        return $this->hasMany('App\Models\Comment5', 'parent_id')->with('user')->orderBy($sort_by, $sort_dir );
    }
    public function user()
    {
        return  $this->belongsTo('App\Models\User');
    }
    public function parent()
    {
        return $this->belongsTo('App\Models\Comment3','parent_id');
    }
    public function getTableNameAttribute(){
        return $this->table;
    }
    public function getTableIdAttribute(){
        return explode('_',$this->table)[1];
    }
}
