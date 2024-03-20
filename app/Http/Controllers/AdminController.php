<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){
        return view('admin.home');
        // return auth()->check() ? redirect()->route('admin.home') : redirect()->route('admin.signIn');
    }

}
