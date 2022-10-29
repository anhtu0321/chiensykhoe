<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Donvi extends Model
{
    use SoftDeletes;
    protected $table = 'donvi';
}
