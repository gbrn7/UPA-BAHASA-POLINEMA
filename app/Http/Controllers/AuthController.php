<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index(){
        return auth()->user() ? redirect()->route('admin.home') : view('admin.siginIn');
    }

    public function authenticate(Request $request){
        $validation = [
            'email' => 'required|email',
            'password' => 'required'
        ];

        $messages = [
            'required' => 'Kolom :attribute harus diisi',
            'email' => 'Kolom :attribute harus bertipe email',
        ];


        $validator = Validator::make($request->all(), $validation, $messages);

        if($validator->fails()){
            return back()->with('toast_error', join(', ', $validator->messages()->all()))
            ->withInput()
            ->withErrors($validator->messages());
        }

        $credentials = $request->only('email', 'password');

        
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
 
            return redirect()->route('admin.home');
        }

        return back()->with('toast_error', 'Email atau password tidak valid!');
    }

    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('admin.signIn')->with('toast_success', 'Berhasil Keluar');
    }
}
