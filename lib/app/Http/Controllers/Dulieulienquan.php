<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class Dulieulienquan extends Controller
{
	public function listKhoi(){
		return DB::table('khoi')->get();
	}
	public function listCapbac(){
		return DB::table('capbac')->get();
	}
	public function listChucvu(){
		return DB::table('chucvu')->get();
	}
	public function listDonvi(){
		return DB::table('donvi')->get();
	}
}
