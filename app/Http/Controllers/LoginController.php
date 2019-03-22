<?php

namespace App\Http\Controllers\controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function show(Request $request){
        $name=$request->input('name');
        $pwd=$request->input('pwd');
        return view('login');
    }
}
