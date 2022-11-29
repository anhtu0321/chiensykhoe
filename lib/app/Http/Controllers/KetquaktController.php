<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class KetquaktController extends Controller
{
    public function store(Request $request){
        $id_ds_canbo = DB::table('danhsach_canbo')
            ->join('canbo','danhsach_canbo.id_canbo','=','canbo.id')
            ->where('danhsach_canbo.id_danhsach','=',$request->id_danhsach)
            ->where('danhsach_canbo.id_canbo','=',$request->id_canbo)
            ->select('danhsach_canbo.id','canbo.nam_sinh','canbo.gioi_tinh')
            ->get();
        $namsinh = $id_ds_canbo[0]->nam_sinh;
        $gioitinh = $id_ds_canbo[0]->gioi_tinh;
        foreach($request->ketqua as $value){
            $ketqua = explode(',', $value); // explode ra mang $ketqua = ['id mon thi','diem thi']
            $id_ds_monthi = DB::table('danhsach_monthi')->where('id_danhsach','=',$request->id_danhsach)->where('id_monthi','=',$ketqua[0])->value('id');
            $xeploai = $this->xeploai($namsinh,$gioitinh,$ketqua[0],$ketqua[1]);
            if($ketqua[1] != null){
                DB::table('ketqua')->updateOrInsert(
                    ['id_ds_canbo' => $id_ds_canbo[0]->id, 'id_ds_monthi' => $id_ds_monthi],
                    ['diem'=> $ketqua[1], 'xeploai'=>$xeploai]
                );
            }
        }  
        
    }
    public function xeploai($namsinh, $gioitinh, $monthi, $diem){
        $date = getdate();
        $tuoi = $date['year'] - $namsinh;
        $luat = DB::table('luat')
            ->where('min_age','<=', $tuoi)
            ->where('max_age','>=', $tuoi)
            ->where('gioi_tinh','=', $gioitinh)
            ->where('mon_thi','=', $monthi)
            ->select('dat','kha','gioi')
            ->get();
        // return $luat;
        if($luat[0]->dat < $luat[0]->kha){
            if($diem < $luat[0]->dat){return "<div class='truot'>Thi trượt</div>";}
            else if($diem < $luat[0]->kha){return "<div class='dat'>Đạt</div>";}
            else if($diem < $luat[0]->gioi){return "<div class='kha'>Khá</div>";}
            else if($diem >= $luat[0]->gioi){return "<div class='gioi'>Giỏi</div>";}
            else{return "Không có luật";}
        }else if($luat[0]->dat > $luat[0]->kha){
            if($diem > $luat[0]->dat){return "<div class='truot'>Thi trượt</div>";}
            else if($diem > $luat[0]->kha){return "<div class='dat'>Đạt</div>";}
            else if($diem > $luat[0]->gioi){return "<div class='kha'>Khá</div>";}
            else if($diem <= $luat[0]->gioi){return "<div class='gioi'>Giỏi</div>";}
            else{return "Không có luật";}
        }
    } 
}
