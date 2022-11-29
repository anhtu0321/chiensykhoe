<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Danhsach extends Model
{
    protected $table='danhsach';
    public function quytac(){
        return $this->belongsTo('App\Quytac','quy_tac','id');
    }
    /**
     * The canbo that belong to the Danhsach
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function canbo(){
        return $this->belongsToMany('App\Canbo', 'danhsach_canbo', 'id_danhsach', 'id_canbo');
    }
    public function monthi(){
        return $this->belongsToMany('App\Monthi', 'danhsach_monthi', 'id_danhsach', 'id_monthi');
    }
}
