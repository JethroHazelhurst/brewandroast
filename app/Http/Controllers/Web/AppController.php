<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Auth;

class AppController extends Controller
{
    public function getApp(){
        var_dump(Auth::user());
        return view('app');
    }

    public function getLogin(){
        return view('login');
    }
}
