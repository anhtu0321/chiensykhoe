<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Danhsach;
class DanhsachController extends Controller
{
    public function store(Request $request){
        $danhsach = new Danhsach;
        $danhsach->ten_danh_sach = $request->ten_danh_sach;
        $danhsach->nam = $request->nam;
        $danhsach->quy_tac = $request->quy_tac;
        $danhsach->save();
    }
}
