<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Danhsach;
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
        // return Danhsach::with('canbo')->find($id);
        return DB::table('danhsach_canbo')
        ->join('danhsach','danhsach_canbo.danhsach_id','=','danhsach.id')
        ->join('canbo','danhsach_canbo.canbo_id','=','canbo.id')
        ->join('donvi','canbo.don_vi','=','donvi.id')
        ->where('danhsach.id','=',$id)
        ->select('danhsach_canbo.id','canbo.ho_ten','canbo.nam_sinh','canbo.gioi_tinh','donvi.ten_don_vi')
        ->orderBy('canbo.don_vi','asc')
        ->orderBy('canbo.chuc_vu','desc')
        ->orderBy('canbo.nam_sinh','asc')
        ->get();

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
