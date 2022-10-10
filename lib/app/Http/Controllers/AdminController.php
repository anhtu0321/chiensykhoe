<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct(){
        $this-> middleware('kt');
    }
    public function getHome(){
        return view('backend/home');
    }
}
