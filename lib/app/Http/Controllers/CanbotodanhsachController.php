<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Danhsach;
// use App\Donvi;
use DB;
class CanbotodanhsachController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        // $donvi = DB::table('donvi')->get(); //Lấy dữ liệu đơn vị
        // $IDdonvi = collect($donvi)->pluck('id'); //Lấy mảng id đơn vị
        // $canbo = DB::table('canbo')->whereIn('don_vi', $IDdonvi)->get(); //Lấy dữ liệu cán bộ thuộc đơn vị trên
        // $canboCollect = collect($canbo)->groupBy('don_vi'); //Nhóm các cán bộ thuộc cùng 1 đơn vị vào 1 mảng
        // // Hàm dưới để chèn cán bộ vào các đơn vị tương ứng:
        // $donviReturn = collect($donvi)->map(function($item, $key) use ($canboCollect){
        //     $canbo = ['canbo' => []];
        //     if(isset($canboCollect[$item->id])){
        //         $canbo = ['canbo' => $canboCollect[$item->id]];
        //     }
        //     return collect($item)->merge($canbo);
        // });
        // return $donviReturn;

        // Tương đương Eloquent ở dưới:
        // return Donvi::with('canbo')->get();
        $danhsach = Danhsach::with('canbo.donvi:id,ten_don_vi')->where('id',$id)->get();
        return $danhsach;
       
    }
    public function indexKiemtra($id){
        $data = DB::table('danhsach')
        ->join('danhsach_canbo','danhsach.id','=','danhsach_canbo.id_danhsach')
        ->join('canbo','danhsach_canbo.id_canbo','=','canbo.id')
        ->join('donvi','canbo.don_vi','=','donvi.id')
        ->join('danhsach_monthi','danhsach.id','=','danhsach_monthi.id_danhsach')
        ->join('monthi','danhsach_monthi.id_monthi','=','monthi.id')
        ->leftJoin('ketqua',function($join){
            $join->on('danhsach_canbo.id','=','ketqua.id_ds_canbo')->on('danhsach_monthi.id','=','ketqua.id_ds_monthi');
        })
        ->where('danhsach.id',$id)
        ->select('canbo.ho_ten','canbo.gioi_tinh','canbo.nam_sinh', 'donvi.ten_don_vi','danhsach_canbo.id_canbo','danhsach_monthi.id_monthi', 'monthi.ten_mon_thi', 'ketqua.diem', 'ketqua.xeploai')
        ->get();
        $data = collect($data)->groupBy('id_canbo')->values();

        $data = $data->map(function($item, $key){
            $collect = collect($item[0]);
            $collect->splice(5);
            $ketqua = collect($item)->map(function($item, $key){
                return collect($item)->splice(5);
            });
            $ketqua = ['ketqua'=>$ketqua];
            return $collect->merge($ketqua);
        });
        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $danhsach = Danhsach::find($request->idDanhsach);
        $danhsach->canbo()->attach($request->mangcanbo);
        // dd($request->mangcanbo);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('danhsach_canbo')->where('id','=',$id)->delete();
       
    }
}
