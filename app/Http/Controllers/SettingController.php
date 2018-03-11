<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingController extends Controller
{
    //
    public function  __construct()
    {
        return $this->middleware('auth');
    }
    public function create(Request $request){
        $method = $request->isMethod('post');
        if($method){ //Process form

        }else{ //Display form

        }
    }
}
