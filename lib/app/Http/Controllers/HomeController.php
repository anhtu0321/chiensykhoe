<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct(){
        $this->middleware('kt');
    }
    public function getHome(){
        $user = auth()->user()->fullname;
        return view('home', compact('user'));
    }
}
