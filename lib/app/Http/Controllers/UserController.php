<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use DB;
use Hash;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::with('role:role.id,role.name')->orderby('id','desc')->paginate(10);
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
            $user = new User;
            $user->username = $request->username;
            $user->fullname = $request->fullname;
            $user->password = bcrypt($request->password);
            $user->save();
            $user->role()->attach($request->roles);
            DB::commit();
        }catch(\Exception $e){
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
        return User::with('role')->where('id','=',$id)->get();
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
            $user = User::find($id);
            $user->username = $request->username;
            $user->fullname = $request->fullname;
            if($request->password != ''){$user->password = bcrypt($request->password);}
            $user->save();
            $user->role()->sync($request->roles);
            DB::commit();
        }catch(\Exception $e){
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
            $user = User::find($id);
            $user->role()->detach();
            User::destroy($id);
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
        }
    }
    public function validateForm(Request $request){
        return $request->validate([
            'username'=>'required',
            'fullname'=>'required',
        ],
        $messages=[
            'required'=>':attribute không được để trống !'
        ],
        $attribute=[
            'username'=>"Tên tài khoản",
            'fullname'=>"Tên hiển thị",
        ]
        );
    }
    public function doimatkhau(Request $request){
        $user = auth()->user();
        $request->validate([
                'oldpass'=>'required',
                'newpass'=>'required',
                'renewpass'=>'required',
            ],
            $messages=[
                'required'=>':attribute không được để trống !'
            ],
            $attributes=[
                'oldpass'=>'Mật khẩu cũ',
                'newpass'=>'Mật khẩu mới',
                'renewpass'=>'Nhập lại mật khẩu mới',
            ]
        ); 
        if(!Hash::check($request->oldpass, $user->password)){
            return response()->json([
                'message' =>'Dữ liệu không hợp lệ !',
                'errors' => ['oldpass'=>['Mật khẩu cũ không đúng !']],
            ], 422);
        }else{
            $user->password  = bcrypt($request->newpass);
            $user->save();
        }
        
    }
}
