<?php

namespace App\Http\Controllers;

use App\Models\DepartementModel;
use App\Models\EventModel;
use App\Models\ProdyModel;
use App\Models\RegistrationsModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use PhpParser\Node\Stmt\TryCatch;

class EventController extends Controller
{
    public function index()
    {
        $events = EventModel::all();

        $activeEvent = $events->where('status', true)->first();

        if (isset($activeEvent)) {
            $dateNow = Carbon::now();
            $registerEnd = Carbon::parse($activeEvent->register_end);
    
            if($dateNow->greaterThan($registerEnd) || $activeEvent->remaining_quota <= 0)
            {    
            $activeEvent->update(['status' => false]);
        
            }
        }

        return view('admin.data-event.data-event', ['events' => $events]);
    }

    public function createEvent()
    {
        $activeEvent = EventModel::where('status', true)->first();

        if (!isset($activeEvent)) {
            return view('admin.data-event.create-data-event');
        }

        return back()->with('toast_warning', 'Terdapat Event yang masih aktif, untuk menambahkan event pastikan semua event Non-Aktif');

    }

    public function storeEvent(Request $request)
    {
        $request->validate([
            'registration_range' => 'required',
            'execution' => 'required',
            'quota' => 'required',
            'status' => 'required',
        ]);

        $registerStart = Carbon::parse(explode(' - ',$request->registration_range)[0])->startOfDay();
        $registerEnd = Carbon::parse(explode(' - ',$request->registration_range)[1])->endOfDay();
        $execution = Carbon::parse($request->execution);

        $newEvent = EventModel::create([
            'register_start' => $registerStart,
            'register_end' => $registerEnd,
            'execution' => $execution,
            'quota' => $request->quota,
            'remaining_quota' => $request->quota,
            'status' => $request->status,
            'created_by' => auth()->user()->user_id,
            'updated_by' => auth()->user()->user_id
        ]);

        return redirect()->route('admin.data.event')->with('toast_success', 'Event Berhasil Ditambahkan');

    }   

    public function editEvent($eventId)
    {   
        $event = EventModel::where('event_id', $eventId)->first();
        $registerStart = date('d-m-Y', strtotime($event->register_start));
        $registerEnd = date('d-m-Y', strtotime($event->register_end));
        $execution = date('d-m-Y', strtotime($event->execution));

        return view('admin.data-event.edit-data-event', [
            'event' => $event,
            'registerStart' => $registerStart,
            'registerEnd' => $registerEnd,
            'execution' => $execution,
        ]);

    }

    public function updateEvent($eventId, Request $request)
    {
        $request->validate([
            'registration_range' => 'required',
            'execution' => 'required',
            'quota' => 'required',
            'status' => 'required|boolean',
        ]);

        if($request->status == 1 ){
            $activeEvent = EventModel::where('status', true)->first();

            if (isset($activeEvent) ) return back()->with('toast_warning', 'Terdapat Event yang masih aktif, untuk mengaktifkan event pastikan semua event Non-Aktif');
            
        }

        $oldEvent = EventModel::where('event_id', $eventId)->first();

        $registerStart = Carbon::parse(explode(' - ',$request->registration_range)[0])->startOfDay();
        $registerEnd = Carbon::parse(explode(' - ',$request->registration_range)[1])->endOfDay();
        $execution = Carbon::parse($request->execution);

        $oldEvent->update([
            'register_start' => $registerStart,
            'register_end' => $registerEnd,
            'execution' => $execution,
            'quota' => $request->quota,
            'remaining_quota' => $request->quota,
            'status' => $request->status,
            'created_by' => auth()->user()->user_id,
            'updated_by' => auth()->user()->user_id
        ]);

        return redirect()->route('admin.data.event')->with('toast_success', 'Event Berhasil Diedit');
    }

    public function deleteEvent(Request $request)
    {

        $request->validate([
            'eventId' => 'required',
        ]);

        $event = EventModel::find($request->eventId);

        $event->delete([
            'deleted_by' => auth()->user()->user_id
        ]);

        return redirect()->route('admin.data.event')->with('toast_success', 'Event Berhasil Dihapus');

    }

    public function detailRegisters($eventId)
    {
        $detailRegisters = RegistrationsModel::where('event_id', $eventId)
                    ->get();

        $event = EventModel::find($eventId);

        return view('admin.data-event.detail-registers.detail-registers', [
            'detailRegisters' => $detailRegisters,
            'event' => $event
        ]);
    }

    public function createRegister($eventId)
    {
        $departements = DepartementModel::all();
        $prodys = ProdyModel::all();

        return view('admin.data-event.detail-registers.create-data-register', [
            'departements' => $departements, 
            'prodys' => $prodys,      
            'event_id' => $eventId,      
        ]);
    }

    public function saveRegister(Request $request, $eventId)
    {
        $validation = [
            'name' => 'required|string|max:255',
            'nim' => 'required|string|max:255',
            'nik' => 'required|string|max:255',
            'departement' => 'required|string|max:255',
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

        $event = EventModel::find($eventId);

        if (!isset($event)) return back()->with('toast_warning', 'Event tidak ditemukan')->withInput();

        if($event->remaining_quota <= 0) return back()->with('toast_warning', 'Kuota pendaftaran habis')->withInput();

        $newRegistration = $request->except('_token');
        $newRegistration['event_id'] = $event->event_id;

        $checkEmail = RegistrationsModel::where('event_id', $event->event_id)
                                         ->where('email', $newRegistration['email'] )
                                         ->first();

        if (isset($checkEmail)) return back()->with('toast_warning', 'Email sudah didaftarkan')->withInput();

        DB::beginTransaction();
        $event->update([
            'remaining_quota' => ($event->remaining_quota - 1),
        ]); 
        //Ktp rename file
        $ktp = $request->ktp_img;
        $imageName = $event->event_id.'_'.Str::random(3).'.'.$ktp->getClientOriginalExtension();
        $ktp->storeAs('public/ktp', $imageName);
        $newRegistration['ktp_img'] = $imageName;

        //Ktm rename file
        $ktm = $request->ktm_img;
        $imageName = $event->event_id.'_'.Str::random(3).'.'.$ktm->getClientOriginalExtension();
        $ktm->storeAs('public/ktm', $imageName);
        $newRegistration['ktm_img'] = $imageName;

        //Surat Pernyataan IISMA rename file
        $srtPrytnis = $request->surat_pernyataan_iisma;
        $imageName = $event->event_id.'_'.Str::random(3).'.'.$srtPrytnis->getClientOriginalExtension();
        $srtPrytnis->storeAs('public/surat_pernyataan_iisma', $imageName);
        $newRegistration['surat_pernyataan_iisma'] = $imageName;

        //Pas Foto IISMA rename file
        $pasFoto = $request->pasFoto_img;
        $imageName = $event->event_id.'_'.Str::random(3).'.'.$pasFoto->getClientOriginalExtension();
        $pasFoto->storeAs('public/pasFoto', $imageName);
        $newRegistration['pasFoto_img'] = $imageName;

        $newRegistration = RegistrationsModel::create($newRegistration);
        DB::commit();

        return redirect()->route('admin.data.detail.registers', $eventId)->with('toast_success', 'Pendaftaran test bahasa inggris TOEIC '.$newRegistration->name.' berhasil');
    }

    public function editRegister($eventId, $registerId)
    {
        $departements = DepartementModel::all();
        $prodys = ProdyModel::all();
        $register = RegistrationsModel::find($registerId);

        if (!isset($register)) return back()->with('toast_warning', 'Pendaftar tidak ditemukan');

        return view('admin.data-event.detail-registers.edit-data-register', [
            'departements' => $departements, 
            'prodys' => $prodys,      
            'event_id' => $eventId,      
            'register' => $register,      
        ]);
    }

    public function updateRegister(Request $request, $eventId, $registerId)
    {
        $validation = [
            'name' => 'required|string|max:255',
            'nim' => 'required|string|max:255',
            'nik' => 'required|string|max:255',
            'departement' => 'required|string|max:255',
            'program_study' => 'required|string|max:255',
            'semester' => 'required',
            'email' => 'required|email',
            'phone_num' => 'required|string',
            'ktp_img' => 'nullable|mimes:png,jpg,jpeg|max:1024',
            'ktm_img' => 'nullable|mimes:png,jpg,jpeg|max:1024',
            'surat_pernyataan_iisma' => 'nullable|mimes:pdf|extensions:pdf|max:5120',
            'pasFoto_img' => 'nullable|mimes:png,jpg,jpeg|max:1024',
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

        $registration = RegistrationsModel::find($registerId);
        if (!isset($registration)) return back()->with('toast_warning', 'Register tidak ditemukan')->withInput();

        $event = EventModel::find($eventId);
        if (!isset($event)) return back()->with('toast_warning', 'Event tidak ditemukan')->withInput();

        $newRegistration = $request->except('_token');
        $newRegistration['event_id'] = $event->event_id;

        $checkEmail = RegistrationsModel::where('event_id', $event->event_id)
                                         ->where('registration_id', '<>', $registerId)
                                         ->where('email', $newRegistration['email'] )
                                         ->first();

        if (isset($checkEmail)) return back()->with('toast_warning', 'Email sudah didaftarkan')->withInput();

        try {
            DB::beginTransaction();
            //Ktp update file
            if(isset( $request->ktp_img)){
                $ktp = $request->ktp_img;
                $fileName = $event->event_id.'_'.Str::random(3).'.'.$ktp->getClientOriginalExtension();
                $ktp->storeAs('public/ktp', $fileName);
                $newRegistration['ktp_img'] = $fileName;
                //delete old ktp
                Storage::delete('public/ktp/'.$registration->ktp_img);
            }   
    
            //Ktm update file
            if(isset( $request->ktm_img)){
                $ktm = $request->ktm_img;
                $fileName = $event->event_id.'_'.Str::random(3).'.'.$ktm->getClientOriginalExtension();
                $ktm->storeAs('public/ktm', $fileName);
                $newRegistration['ktm_img'] = $fileName;
                //delete old ktm
                Storage::delete('public/ktm/'.$registration->ktm_img);
            }
    
            //Surat Pernyataan IISMA update file
            if(isset( $request->surat_pernyataan_iisma)){
                $srtPrytnis = $request->surat_pernyataan_iisma;
                $fileName = $event->event_id.'_'.Str::random(3).'.'.$srtPrytnis->getClientOriginalExtension();
                $srtPrytnis->storeAs('public/surat_pernyataan_iisma', $fileName);
                $newRegistration['surat_pernyataan_iisma'] = $fileName;
                //delete old Surat Pernyataan IISMA
                Storage::delete('public/surat_pernyataan_iisma/'.$registration->surat_pernyataan_iisma);
            }
    
            //Pas Foto update file
            if(isset( $request->pasFoto_img)){
                $pasFoto = $request->pasFoto_img;
                $fileName = $event->event_id.'_'.Str::random(3).'.'.$pasFoto->getClientOriginalExtension();
                $pasFoto->storeAs('public/pasFoto', $fileName);
                $newRegistration['pasFoto_img'] = $fileName;
                //delete old pasFoto
                Storage::delete('public/pasFoto/'.$registration->pasFoto_img);
            }
    
            $registration->update($newRegistration);
            DB::commit();
    
            return redirect()->route('admin.data.detail.registers', $eventId)->with('toast_success', 'Pengeditan pendaftaran test bahasa inggris TOEIC '.$request->name.' berhasil');
        } catch (\Throwable $th) {
            return back()->withInput()->with('toast_error', 'Internal Server Error');
        }

    }
}
