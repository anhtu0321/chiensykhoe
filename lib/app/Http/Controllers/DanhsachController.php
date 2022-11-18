<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use DB;
// use Exception;
use App\Danhsach;
class DanhsachController extends Controller
{
    public function index(Request $request){
        return Danhsach::with('quytac:id,ten_quy_tac')->orderBy('id','desc')->paginate(20);
    }
    public function store(Request $request){
        try{
            DB::beginTransaction();
            $danhsach = new Danhsach;
            $danhsach->ten_danh_sach = $request->ten_danh_sach;
            $danhsach->nam = $request->nam;
            $danhsach->quy_tac = $request->quy_tac;
            $danhsach->save();
            $danhsach->monthi()->attach($request->mon_thi);
            DB::commit();
        }catch(Exception $exception){
            DB::rollback();
        }
        
    }
    public function edit($id){
        return Danhsach::with('monthi')->find($id);
    }
    public function update(Request $request, $id){
        
        try{
            DB::beginTransaction();
            $danhsach = Danhsach::find($id);
            $danhsach->ten_danh_sach = $request->ten_danh_sach;
            $danhsach->nam = $request->nam;
            $danhsach->quy_tac = $request->quy_tac;
            $danhsach->save();
            $danhsach->monthi()->sync($request->mon_thi);
            DB::commit();
        }catch(Exception $exception){
            DB::rollback();
        }
    }
    public function deleted($id){
        try{
            DB::beginTransaction();
            $Danhsach = Danhsach::find($id);
            $Danhsach->monthi()->detach();
            Danhsach::destroy($id);
            DB::commit();
        }catch(Exception $exception){
            DB::rollback();
        }
    }
}
