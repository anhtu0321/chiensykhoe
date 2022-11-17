<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Luat extends Model
{
    protected $table="luat";
 
    public function monthi()
    {
        return $this->belongsTo('App\Monthi', 'mon_thi', 'id');
    }
   
}
