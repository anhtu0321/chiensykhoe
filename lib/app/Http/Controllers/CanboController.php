<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Canbo;
class CanboController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Canbo::with('donvi:id,ten_don_vi')->with('capbac:id,ten_cap_bac')->with('chucvu:id,ten_chuc_vu')->orderBy('chuc_vu','desc')->orderBy('nam_sinh','asc')->paginate(10);
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
        $canbo = new Canbo;
        $canbo->ho_ten = $request->ho_ten;
        $canbo->nam_sinh = $request->nam_sinh;
        $canbo->gioi_tinh = $request->gioi_tinh;
        $canbo->cap_bac = $request->cap_bac;
        $canbo->chuc_vu = $request->chuc_vu;
        $canbo->don_vi = $request->don_vi;
        $canbo->save();
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
        $canbo = Canbo::where('id','=',$id)->get();
        return $canbo;
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
        $canbo = Canbo::find($id);
        $canbo->ho_ten = $request->ho_ten;
        $canbo->nam_sinh = $request->nam_sinh;
        $canbo->gioi_tinh = $request->gioi_tinh;
        $canbo->cap_bac = $request->cap_bac;
        $canbo->chuc_vu = $request->chuc_vu;
        $canbo->don_vi = $request->don_vi;
        $canbo->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Canbo::destroy($id);
    }
    public function validateForm($request){
        $request->validate([
            'ho_ten'=>'required',
            'nam_sinh'=>'required|numeric'
        ],
        $message=[
            'required'=>':attribute không được để trống !',
            'numeric'=>':attribute phải là ký tự số !'
        ],
        $attributes=[
            'ho_ten'=>"Họ tên",
            'nam_sinh'=>'Năm sinh'
        ]);
    }
}
