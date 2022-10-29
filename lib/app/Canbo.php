<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Canbo extends Model
{
    use SoftDeletes;
    protected $table = 'canbo';
    protected $guard = [
       
    ];
    public function capbac(){
        return $this->belongsTo('App\Capbac','cap_bac','id');
    }
    public function chucvu(){
        return $this->belongsTo('App\Chucvu','chuc_vu','id');
    }
    public function donvi(){
        return $this->belongsTo('App\Donvi','don_vi','id');
    }
}
