<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Donvi;
use DB;
class DonviController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return Donvi::orderBy('id','desc')->paginate(2);
        $donvi = DB::table('donvi')
        ->join('khoi','donvi.khoi','=','khoi.id')
        ->select('donvi.id','donvi.ky_hieu','donvi.ten_don_vi','khoi.ten_khoi','donvi.thu_tu')
        ->where('donvi.deleted_at','=', null)
        ->orderBy('khoi','asc')
        ->orderBy('thu_tu','asc')
        ->paginate(10);
        return $donvi;
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
        $this->validateForm($request);
        $donvi = new Donvi;
        $donvi->ten_don_vi = $request->ten_don_vi;
        $donvi->ky_hieu = $request->ky_hieu;
        $donvi->thu_tu = $request->thu_tu;
        $donvi->khoi = $request->khoi;
        $donvi->save();
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
        return Donvi::where('id','=',$id)->get();
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
        $this->validateForm($request);
        $donvi = Donvi::find($id);
        $donvi->ten_don_vi = $request->ten_don_vi;
        $donvi->ky_hieu = $request->ky_hieu;
        $donvi->thu_tu = $request->thu_tu;
        $donvi->khoi = $request->khoi;
        $donvi->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Donvi::destroy($id);
    }
    public function validateForm($request){
        return $request->validate([
            'ten_don_vi'=>'required',
            'ky_hieu'=>'required',
            'thu_tu'=>'required|numeric'
        ],
        $message=[
            'required'=>':attribute không được để trống !',
            'numeric'=>':attribute phải là ký tự số !',
        ],
        $attributes=[
            'ten_don_vi'=>'Tên đơn vị',
            'ky_hieu'=>'Ký hiệu',
            'thu_tu'=>'Thứ tự',
        ]);
    }
}
