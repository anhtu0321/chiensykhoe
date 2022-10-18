<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Role;
class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Role::orderby('id','asc')->paginate(10);
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
        try{
            DB::beginTransaction();
            $role = new Role;
            $role->name = $request->name;
            $role->display_name = $request->display_name;
            $role->save();
            $role->permission()->attach($request->mangcon);
            DB::commit();
        }catch(\Exception $exception){
            DB::rollback();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Role::with('permission')->where('id','=',$id)->get();
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
        $this->validateForm($request);
        try{
            DB::beginTransaction();
            $role = Role::find($id);
            $role->name = $request->name;
            $role->display_name = $request->display_name;
            $role->save();
            $role->permission()->sync($request->mangcon);
            DB::commit();
        }catch(\Exception $exception){
            DB::rollback();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            DB::beginTransaction();
            $role = Role::find($id);
            $role->permission()->detach();
            Role::destroy($id);
            DB::commit();
        }catch(\Exception $exception){
            DB::rollback();
        }
            

    }

    public function validateForm(Request $request){
        return $request->validate([
            'name'=>'required',
            'display_name'=>'required'
        ], $messages=[
            'required'=>':attribute không được để trống !'
        ], $attribute=[
            'name'=>'Tên nhóm quyền',
            'display_name'=>'Tên đầy đủ nhóm quyền',
        ]);
    }
}
