<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    use SoftDeletes;
    protected $table = 'permission';
    public function parent_permission(){
        return $this->belongsTo('App\Permission', 'parent_id', 'id')->select('name','id','parent_id');
    }
    public function per_child(){
        return $this->hasMany('App\Permission', 'parent_id', 'id')->select('name','id','parent_id');
    }
}
