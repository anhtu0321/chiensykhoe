<?php

namespace App\Http\Controllers;

use App\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{

    public function index()
    {
        return Permission::with('parent_permission')->orderby('parent_id','asc')->orderby('id','asc')->paginate(20);
    }
    public function listCha(){
        return Permission::with('per_child')->where('parent_id','0')->select('name','id','parent_id')->orderby('name')->get();
    }
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $this-> validateForm($request);
        $Permission = new Permission;
        $Permission->name = $request->name;
        $Permission->display_name = $request->display_name;
        $Permission->key_code = $request->key_code;
        $Permission->parent_id = $request->parent_id;
        $Permission->save();
    }

    public function show($id)
    {
    }
    
    public function edit($id)
    {
        return Permission::where('id','=',$id)->get();
    }

    public function update(Request $request, $id)
    {
        $Permission = Permission::find($id);
        $Permission->name = $request->name;
        $Permission->display_name = $request->display_name;
        $Permission->key_code = $request->key_code;
        $Permission->parent_id = $request->parent_id;
        $Permission->save();
    }

    public function destroy($id)
    {
        Permission::destroy($id);
    }

    
    public function validateForm(Request $request){
        return $request->validate([
            'name'=>'required',	
            'display_name'=>'required',
            'key_code'=>'required',
        ], 
        $messages = [
            'required' => ':attribute không được để trống.',
        ],
        $attributes = [
            'name'=>'Tên chức năng',	
            'display_name'=>'Tên hiển thị',
            'key_code'=>'key_code',
        ]);
    }
    
}
