<?php

namespace App\Http\Controllers;

use App\Mail\RegistrationMail;
use App\Models\DepartementModel;
use App\Models\ToeicTestEventModel;
use App\Models\imageModel;
use App\Models\ProdyModel;
use App\Models\ToeicTestRegistrationsModel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        if($request->lang) App::setlocale($request->lang);

        $events = ToeicTestEventModel::where('status', true)->get();

        $admin = User::first();

        $gallery = imageModel::where('type', 'gallery')->orderBy('image_id', 'desc')->get();

        if (!isset($events)) {
            return view('client.landingPage', ['gallery' => $gallery]);
        }

        $activeEvents = collect();

        $dateNow = Carbon::now();
        foreach ($events as $key => $activeEvent) {
            $registerEnd = Carbon::parse($activeEvent->register_end);

            if($dateNow->greaterThan($registerEnd) || $activeEvent->remaining_quota <= 0){    
                $activeEvent->update(['status' => false]);
            }else{
                $activeEvents->push($activeEvent);
            }
        }

        return view('client.landingPage', ['activeEvents' => (count($activeEvents) > 0 ? $activeEvents : null), 'adminPhoneNum' => $admin->phone_num, 'gallery' => count($gallery) > 0 ? $gallery : null]);
    }

    public function sop(Request $request)
    {
        if($request->lang) App::setlocale($request->lang);

        $events = ToeicTestEventModel::where('status', true)->get();

        $admin = User::first();

        $image_toeic = imageModel::where('type', 'sop-toeic')->first();
        $image_consult = imageModel::where('type', 'sop-consult')->first();

        if (!isset($events)) {
            return view('client.sop', ['image_toeic' => $image_toeic, 'image_consult' => $image_consult]);
        }

        $activeEvents = collect();

        $dateNow = Carbon::now();
        foreach ($events as $key => $activeEvent) {
            $registerEnd = Carbon::parse($activeEvent->register_end);

            if($dateNow->greaterThan($registerEnd) || $activeEvent->remaining_quota <= 0){    
                $activeEvent->update(['status' => false]);
            }else{
                $activeEvents->push($activeEvent);
            }
        }

        return view('client.sop', ['activeEvent' => (count($activeEvents) > 0 ? $activeEvents : null), 'adminPhoneNum' => $admin->phone_num, 'image_toeic' => $image_toeic, 'image_consult' => $image_consult]);
        
    }

    public function structureOrganization(Request $request)
    {
        if($request->lang) App::setlocale($request->lang);

        $events = ToeicTestEventModel::where('status', true)->get();

        $admin = User::first();

        $image = imageModel::where('type', 'structure_organization')->first();

        if (!isset($events)) {
            return view('client.structure-organization', ['image' => $image]);
        }

        $activeEvents = collect();

        $dateNow = Carbon::now();
        foreach ($events as $key => $activeEvent) {
            $registerEnd = Carbon::parse($activeEvent->register_end);

            if($dateNow->greaterThan($registerEnd) || $activeEvent->remaining_quota <= 0){    
                $activeEvent->update(['status' => false]);
            }else{
                $activeEvents->push($activeEvent);
            }
        }

        return view('client.structure-organization', ['activeEvent' => (count($activeEvents) > 0 ? $activeEvents : null), 'adminPhoneNum' => $admin->phone_num, 'image' => $image]);
        
    }

    public function formView(Request $request)
    {
        if($request->lang) App::setlocale($request->lang);

        $events = ToeicTestEventModel::where('status', true)->get();

        if (!isset($events)) {
            return redirect()->route('client');
        }

        $activeEvents = collect();

        $dateNow = Carbon::now();

        foreach ($events as $key => $activeEvent) {
            $registerEnd = Carbon::parse($activeEvent->register_end);

            if($dateNow->greaterThan($registerEnd) || $activeEvent->remaining_quota <= 0){    
                $activeEvent->update(['status' => false]);
            }else{
                $activeEvents->push($activeEvent);
            }
        }

        $departements = DepartementModel::all();

        if(count($activeEvents) <= 0) return redirect()->route('client')->with('toast_warning', 'Event tes TOEIC tidak ditemukan');

        
        return view('client.form', 
        [
        'activeEvents' =>  $activeEvents,
        'departements' => $departements, 
        ]);
    }

    public function saveRegistration(Request $request)
    {
        $validation = [
            'toeic_test_events_id' => 'required',
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

        $activeEvent = ToeicTestEventModel::find($request->toeic_test_events_id);

        if (!isset($activeEvent)) return redirect()->route('client')->with('toast_warning', 'Event tidak ditemukan');

        if ($activeEvent->quota <= 0) return redirect()->route('client')->with('toast_warning', 'Kuota telah habis');
        
        $newRegistration = $request->except('_token');

        $departement  = DepartementModel::find($request->departement);
        if (!isset($departement)) return back()->withInput()->withErrors('Jurusan tidak ditemukan');
        $newRegistration['departement'] = $departement->name;

        $checkEmail = ToeicTestRegistrationsModel::where('toeic_test_events_id', $activeEvent->toeic_test_events_id)
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
            $imageName = $activeEvent->toeic_test_events_id.'_'.Str::random(5).'.'.$ktp->getClientOriginalExtension();
            $ktp->storeAs('public/ktp', $imageName);
            $newRegistration['ktp_img'] = $imageName;
    
            //Ktm rename file
            $ktm = $request->ktm_img;
            $imageName = $activeEvent->toeic_test_events_id.'_'.Str::random(5).'.'.$ktm->getClientOriginalExtension();
            $ktm->storeAs('public/ktm', $imageName);
            $newRegistration['ktm_img'] = $imageName;
    
            //Surat Pernyataan IISMA rename file
            $srtPrytnis = $request->surat_pernyataan_iisma;
            $imageName = $activeEvent->toeic_test_events_id.'_'.Str::random(5).'.'.$srtPrytnis->getClientOriginalExtension();
            $srtPrytnis->storeAs('public/surat_pernyataan_iisma', $imageName);
            $newRegistration['surat_pernyataan_iisma'] = $imageName;
    
            //Pas Foto rename file
            $pasFoto = $request->pasFoto_img;
            $imageName = $activeEvent->toeic_test_events_id.'_'.Str::random(5).'.'.$pasFoto->getClientOriginalExtension();
            $pasFoto->storeAs('public/pasFoto', $imageName);
            $newRegistration['pasFoto_img'] = $imageName;
    
            $newRegistration = ToeicTestRegistrationsModel::create($newRegistration);
           
            DB::commit();

            try {
                $this->sendNotif([
                    'name' => $newRegistration->name,
                    'email' => $newRegistration->email,
                    'nim' => $newRegistration->nim,
                    'execution' => $activeEvent->execution,
                    'wa_group_link' => isset($activeEvent->wa_group_link) ? $activeEvent->wa_group_link : null,
                ]);
                return back()->withSuccess('Pendaftaran test bahasa inggris TOEIC '.$newRegistration->name.' berhasil, silahkan cek email anda '.(isset($activeEvent->wa_group_link)? 'untuk mengikuti grup WhatsApp pendaftar': '' ));
            
            } catch (\Throwable $th) {
                return back()->withSuccess('Pendaftaran test bahasa inggris TOEIC '.$newRegistration->name.' berhasil');
            }
            
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
