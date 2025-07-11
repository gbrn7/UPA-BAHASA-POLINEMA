<?php

namespace App\Http\Controllers;

use App\Models\MailSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;

class MailSettingController extends Controller
{
    public function index()
    {
        $mail = MailSetting::first();

        return view('admin.edit-email-setting', ['mail' => $mail]);
    }

    public function update(Request $request)
    {
        $mail = MailSetting::first();

        $request->validate([
            'mail_transport'  => 'nullable',
            'mail_host'       => 'nullable',
            'mail_port'       => 'nullable|numeric',
            'mail_username'   => 'nullable',
            'mail_password'   => 'nullable',
            'mail_encryption' => 'nullable',
            'mail_from'       => 'nullable',
        ]);

        $data =                 [
            'mail_transport'  => isset($request->mail_transport) ? $request->mail_transport : '',
            'mail_host'       => isset($request->mail_host) ? $request->mail_host : '',
            'mail_port'       => isset($request->mail_port) ? $request->mail_port : 0,
            'mail_username'   => isset($request->mail_username) ? $request->mail_username : '',
            'mail_password'   => isset($request->mail_password) ? $request->mail_password : '',
            'mail_encryption' => isset($request->mail_encryption) ? $request->mail_encryption : '',
            'mail_from'       => isset($request->mail_from) ? $request->mail_from : '',
        ];

        if (isset($mail)) {
            $mail->update($data);
        } else {
            $mail = MailSetting::create($data);
        }


        return redirect()->back()->withSuccess('Email Notifikasi Berhasil Diperbarui');
    }
}
