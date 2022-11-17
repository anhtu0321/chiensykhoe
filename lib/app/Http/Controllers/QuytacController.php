<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Quytac;
class QuytacController extends Controller
{
    public function index(Request $request){
        return Quytac::orderBy('id','desc')->paginate(100);
    }
    public function store(Request $request){
        $quytac = new Quytac;
        $quytac->ten_quy_tac = $request->ten_quy_tac;
        $quytac->save();
    }
    public function edit($id){
        return Quytac::find($id);
    }
    public function update(Request $request, $id){
        $quytac = Quytac::find($id);
        $quytac->ten_quy_tac = $request->ten_quy_tac;
        $quytac->save();
    }
    public function deleted($id){
        Quytac::destroy($id);
    }
}
