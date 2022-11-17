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
	public function searchCanbo(Request $request){
		return DB::table('canbo')
			->join('donvi','canbo.don_vi','=','donvi.id')
			->where(function($query) use ($request){
				if($request->ho_ten != ''){$query->where('ho_ten','LIKE','%'.$request->ho_ten.'%');}
				if($request->don_vi !=''){$query->where('don_vi','=',$request->don_vi);}
			})
			->select('canbo.id','canbo.ho_ten','canbo.nam_sinh','canbo.gioi_tinh','donvi.ten_don_vi',)
			->get();
	}
}
