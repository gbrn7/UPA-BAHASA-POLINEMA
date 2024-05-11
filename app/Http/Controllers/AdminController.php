<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function index(){
        return view('admin.home');
    }

    public function editProfile()
    {
        return view('admin.edit-profile');
    }

    public function updateProfile(Request $request)
    {
        $validation = [
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:d_user,email,'.auth()->user()->user_id.',user_id',
            'phone_num' => 'nullable|string',
            'old_password' => 'nullable|string|min:6',
            'new_password' => 'nullable|string|min:6',
            'confirm_new_password' => 'nullable|string|min:6',
        ];

        $messages = [
            'required' => ':attribute harus diisi',
            'string' => 'Kolom :attribute harus bertipe teks atau string',
            'email' => 'Kolom :attribute harus bertipe email',
            'max' => ':attribute maksimal :max kb',
            'new_password.min' => 'Password baru minimal :min karakter',
            'confirm_new_password.min' => 'Konfirmasi password baru minimal :min karakter',
        ];

        $validator = Validator::make($request->all(), $validation, $messages);

        if($validator->fails()){
            return back()
            ->withInput()
            ->with('toast_error', $validator->messages()->all());
        }

        $newProfile = $request->except('_token');
        if(substr($newProfile['phone_num'], 0) == 0){
            $newProfile['phone_num'] = str_replace('08', '628', $newProfile['phone_num']);
          }
            
        $user = User::find(auth()->user()->user_id);

        if(isset($newProfile['old_password']) && isset($newProfile['new_password']) && isset($newProfile['confirm_new_password'])){

            if (Hash::check($newProfile['old_password'], $user->password)) {
                if($newProfile['new_password'] === $newProfile['confirm_new_password']){
                    $newProfile['password'] = Hash::make($newProfile['new_password']);
                }else{
                    return back()
                    ->withInput()
                    ->with('toast_error', 'Password baru dan password konfirmasi tidak sama');
                }
            }else{
                return back()
                ->withInput()
                ->with('toast_error', 'Password lama anda salah');
            }
        };

        try {
            $user->update($newProfile);

            return redirect()
            ->route('admin.home')
            ->withInput()
            ->with('toast_success', 'Ubah data profil berhasil');
        } catch (\Throwable $th) {
            dd($th);
            return back()
            ->withInput()
            ->with('toast_error', 'Ubah data profil gagal');
        }

    }
}
