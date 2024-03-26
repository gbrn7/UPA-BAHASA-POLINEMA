<?php

namespace App\Http\Controllers;

use App\Mail\RegistrationMail;
use App\Models\DepartementModel;
use App\Models\EventModel;
use App\Models\ProdyModel;
use App\Models\RegistrationsModel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ClientController extends Controller
{
    public function index()
    {


        $activeEvent = EventModel::where('status', true)
                        ->first();

        $admin = User::first();

        if (!isset($activeEvent)) {
            return view('client.landingPage');
        }

        $dateNow = Carbon::now();
        $registerEnd = Carbon::parse($activeEvent->register_end);

        if($dateNow->greaterThan($registerEnd) || $activeEvent->remaining_quota <= 0){

            $activeEvent->update(['status' => false]);

            return view('client.landingPage');
            
        }

        return view('client.landingPage', ['activeEvent' => $activeEvent, 'adminPhoneNum' => $admin->phone_num]);
    }

    public function formView()
    {
        $activeEvent = EventModel::where('status', true)
                        ->first();

        if (!isset($activeEvent)) {
            return redirect()->route('client');
        }

        $dateNow = Carbon::now();
        $registerEnd = Carbon::parse($activeEvent->register_end);

        if($dateNow->greaterThan($registerEnd) || $activeEvent->remaining_quota <= 0){

            $activeEvent->update(['status' => false]);

            return redirect()->route('client');   
        }

        $departements = DepartementModel::all();
        
        return view('client.form', 
        [
        'departements' => $departements, 
        ]);
    }

    public function saveRegistration(Request $request)
    {
        $validation = [
            'name' => 'required|string|max:255',
            'nim' => 'required|string|max:255',
            'nik' => 'required|string|max:255',
            'departement' => 'required',
            'program_study' => 'required|string|max:255',
            'semester' => 'required',
            'email' => 'required|email',
            'phone_num' => 'required|string',
            'ktp_img' => 'required|mimes:png,jpg,jpeg|max:1024',
            'ktm_img' => 'required|mimes:png,jpg,jpeg|max:1024',
            'surat_pernyataan_iisma' => 'required|mimes:pdf|extensions:pdf|max:5120',
            'pasFoto_img' => 'required|mimes:png,jpg,jpeg|max:1024',
        ];

        $messages = [
            'required' => ':attribute harus diisi',
            'ktp_img.required' => 'Foto ktp harus diisi',
            'ktm_img.required' => 'Foto ktm harus diisi',
            'surat_pernyataan_iisma.required' => 'Surat pernyataan iisma harus diisi',
            'pasFoto_img.required' => 'Pas foto harus diisi',
            'string' => 'Kolom :attribute harus bertipe teks atau string',
            'email' => 'Kolom :attribute harus bertipe email',
            'max' => ':attribute maksimal :max kb',
            'ktp_img.mimes' => 'File ktp harus bertipe :values',
            'ktm_img.mimes' => 'File ktm harus bertipe :values',
            'surat_pernyataan_iisma.mimes' => 'File Surat Pernyataa IISMA harus bertipe :values',
            'pasFoto_img.mimes' => 'File Pas Foto harus bertipe :values',
        ];

        $validator = Validator::make($request->all(), $validation, $messages);

        if($validator->fails()){
            return back()
            ->withInput()
            ->withErrors($validator->messages()->all());
        }

        $activeEvent = EventModel::where('status', true)
                        ->where('remaining_quota', '>', 0)
                        ->first();

        if (!isset($activeEvent)) return view('client.landingPage');
        
        $newRegistration = $request->except('_token');
        $newRegistration['event_id'] = $activeEvent->event_id;

        $departement  = DepartementModel::find($request->departement);
        if (!isset($departement)) return back()->withInput()->withErrors('Jurusan tidak ditemukan');
        $newRegistration['departement'] = $departement->name;

        $checkEmail = RegistrationsModel::where('event_id', $activeEvent->event_id)
                                         ->where('email', $newRegistration['email'] )
                                         ->first();

        if (isset($checkEmail)) return back()->withInput()->withErrors('Pendaftaran anda sudah terdaftar pada test TOEIC batch ini');

        try{
            DB::beginTransaction();

            $activeEvent->update([
                'remaining_quota' => ($activeEvent->remaining_quota - 1),
            ]); 
            //Ktp rename file
            $ktp = $request->ktp_img;
            $imageName = $activeEvent->event_id.'_'.Str::random(3).'.'.$ktp->getClientOriginalExtension();
            $ktp->storeAs('public/ktp', $imageName);
            $newRegistration['ktp_img'] = $imageName;
    
            //Ktm rename file
            $ktm = $request->ktm_img;
            $imageName = $activeEvent->event_id.'_'.Str::random(3).'.'.$ktm->getClientOriginalExtension();
            $ktm->storeAs('public/ktm', $imageName);
            $newRegistration['ktm_img'] = $imageName;
    
            //Surat Pernyataan IISMA rename file
            $srtPrytnis = $request->surat_pernyataan_iisma;
            $imageName = $activeEvent->event_id.'_'.Str::random(3).'.'.$srtPrytnis->getClientOriginalExtension();
            $srtPrytnis->storeAs('public/surat_pernyataan_iisma', $imageName);
            $newRegistration['surat_pernyataan_iisma'] = $imageName;
    
            //Pas Foto rename file
            $pasFoto = $request->pasFoto_img;
            $imageName = $activeEvent->event_id.'_'.Str::random(3).'.'.$pasFoto->getClientOriginalExtension();
            $pasFoto->storeAs('public/pasFoto', $imageName);
            $newRegistration['pasFoto_img'] = $imageName;
    
            $newRegistration = RegistrationsModel::create($newRegistration);
            
            $this->sendNotif([
                'name' => $newRegistration->name,
                'email' => $newRegistration->email,
                'nim' => $newRegistration->nim,
                'execution' => $activeEvent->execution,
                'wa_group_link' => isset($activeEvent->wa_group_link) ? $activeEvent->wa_group_link : null,
            ]);

            DB::commit();
    
            return back()->withSuccess('Pendaftaran test bahasa inggris TOEIC '.$newRegistration->name.' berhasil, silahkan cek email anda '.(isset($activeEvent->wa_group_link)? 'untuk mengikuti grup WhatsApp pendaftar': '' ));
        }catch (\Throwable $th){
            return back()->withInput()->withErrors('Internal Server Error');
        }


    }

    public function sendNotif($data)
    {
        Mail::to($data['email'])->send(new RegistrationMail($data));
    }

    public function getProgramStudy(Request $request)
    {
        $departementId = $request->departement_id;

        $prody  = ProdyModel::where('departement_id', $departementId)->get();

        return response()->json(['data' => $prody]);
    }
}
