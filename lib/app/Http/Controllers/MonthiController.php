<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Monthi;
class MonthiController extends Controller
{
    public function index(Request $request){
        return Monthi::orderBy('id','desc')->paginate(10);
    }
    public function store(Request $request){
        $monthi = new Monthi;
        $monthi->ten_quy_tac = $request->ten_quy_tac;
        $monthi->save();
    }
    public function edit($id){
        return Monthi::find($id);
    }
    public function update(Request $request, $id){
        $monthi = Monthi::find($id);
        $monthi->ten_quy_tac = $request->ten_quy_tac;
        $monthi->save();
    }
    public function deleted($id){
        Monthi::destroy($id);
    }
}
