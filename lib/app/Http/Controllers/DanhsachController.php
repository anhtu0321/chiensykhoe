<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Danhsach;
class DanhsachController extends Controller
{
    public function index(Request $request){
        return Danhsach::with('quytac:id,ten_quy_tac')->orderBy('id','desc')->paginate(20);
    }
    public function store(Request $request){
        $danhsach = new Danhsach;
        $danhsach->ten_danh_sach = $request->ten_danh_sach;
        $danhsach->nam = $request->nam;
        $danhsach->quy_tac = $request->quy_tac;
        $danhsach->save();
    }
    public function edit($id){
        return Danhsach::find($id);
    }
    public function update(Request $request, $id){
        $danhsach = Danhsach::find($id);
        $danhsach->ten_danh_sach = $request->ten_danh_sach;
        $danhsach->nam = $request->nam;
        $danhsach->quy_tac = $request->quy_tac;
        $danhsach->save();
    }
    public function deleted($id){
        Danhsach::destroy($id);
    }
}
