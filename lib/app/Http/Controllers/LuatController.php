<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Luat;
class LuatController extends Controller
{
    public function index($id){
        return Luat::with('monthi:id,ten_mon_thi')->orderBy('id','desc')->where('id_quy_tac','=',$id)->paginate(100);
    }
    public function store(Request $request){
        $luat = new Luat;
        $luat->id_quy_tac = $request->id_quy_tac;
        $luat->min_age = $request->min_age;
        $luat->max_age = $request->max_age;
        $luat->gioi_tinh = $request->gioi_tinh;
        $luat->mon_thi = $request->mon_thi;
        $luat->dat = $request->dat;
        $luat->kha = $request->kha;
        $luat->gioi = $request->gioi;
        $luat->save();
    }
    public function edit($id){
        return Luat::find($id);
    }
    public function update(Request $request, $id){
        $luat = Luat::find($id);
        $luat->id_quy_tac = $request->id_quy_tac;
        $luat->min_age = $request->min_age;
        $luat->max_age = $request->max_age;
        $luat->gioi_tinh = $request->gioi_tinh;
        $luat->mon_thi = $request->mon_thi;
        $luat->dat = $request->dat;
        $luat->kha = $request->kha;
        $luat->gioi = $request->gioi;
        $luat->save();
    }
    public function deleted($id){
        Luat::destroy($id);
    }
}
