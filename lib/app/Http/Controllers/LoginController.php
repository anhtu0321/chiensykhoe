<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
class LoginController extends Controller
{
    public function getLogin(){
        if(Auth::check()){
            return redirect()->route('home');
        }else{
            return view('login');
        }
    }
    public function postLogin(Request $request){
        $user_check = [
            'username' => $request->username,
            'password' => $request->password
        ];
        if(Auth::attempt($user_check)){
            return redirect()->route('home');
        }else{
            return redirect()->route('login');
        }
    }
    public function logOut(){
        Auth::logout();
        return redirect()->route('home');
    }
}
