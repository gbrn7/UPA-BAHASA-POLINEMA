<?php

namespace App\Http\Controllers;

use App\Exports\ToiecDataExport;
use App\Mail\RegistrationMail;
use App\Models\DepartementModel;
use App\Models\ProdyModel;
use App\Models\ToeicTestEventModel;
use App\Models\ToeicTestRegistrationsModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class EventController extends Controller
{
    public function index()
    {
        $events = ToeicTestEventModel::all();

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
        return view('admin.data-event.create-data-event');
    }

    public function storeEvent(Request $request)
    {
        $request->validate([
            'registration_range' => 'required',
            'execution' => 'required',
            'quota' => 'required',
            'status' => 'required',
            'wa_group_link' => 'nullable',
        ]);

        $registerStart = Carbon::parse(explode(' - ',$request->registration_range)[0])->startOfDay();
        $registerEnd = Carbon::parse(explode(' - ',$request->registration_range)[1])->endOfDay();
        $execution = Carbon::parse($request->execution);

        $newEvent = ToeicTestEventModel::create([
            'register_start' => $registerStart,
            'register_end' => $registerEnd,
            'execution' => $execution,
            'quota' => $request->quota,
            'remaining_quota' => $request->quota,
            'wa_group_link' => isset($request->wa_group_link) ? $request->wa_group_link :null,
            'status' => $request->status,
            'created_by' => auth()->user()->user_id,
            'updated_by' => auth()->user()->user_id
        ]);

        return redirect()->route('admin.data.event')->with('toast_success', 'Event Berhasil Ditambahkan');
    }   

    public function editEvent($eventId)
    {   
        $event = ToeicTestEventModel::where('event_id', $eventId)->first();
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
            'wa_group_link' => 'nullable',
        ]);

        $oldEvent = ToeicTestEventModel::where('event_id', $eventId)->first();

        $registerStart = Carbon::parse(explode(' - ',$request->registration_range)[0])->startOfDay();
        $registerEnd = Carbon::parse(explode(' - ',$request->registration_range)[1])->endOfDay();
        $execution = Carbon::parse($request->execution);

        $oldEvent->update([
            'register_start' => $registerStart,
            'register_end' => $registerEnd,
            'execution' => $execution,
            'quota' => $request->quota,
            'remaining_quota' => ($request->quota) - (($oldEvent->quota) - ($oldEvent->remaining_quota)),
            'wa_group_link' => isset($request->wa_group_link) ? $request->wa_group_link :null,
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

        $event = ToeicTestEventModel::find($request->eventId);

        $event->delete([
            'deleted_by' => auth()->user()->user_id
        ]);

        return redirect()->route('admin.data.event')->with('toast_success', 'Event Berhasil Dihapus');

    }

    public function detailRegisters($eventId)
    {
        $detailRegisters = ToeicTestRegistrationsModel::where('event_id', $eventId)
                    ->get();

        $event = ToeicTestEventModel::find($eventId);

        return view('admin.data-event.detail-registers.detail-registers', [
            'detailRegisters' => $detailRegisters,
            'event' => $event
        ]);
    }

    public function exportToeicData(string $eventId)
    {
        return Excel::download(new ToiecDataExport($eventId), 'Data Pendaftar TOEIC Batch-'.$eventId.'.xlsx');
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

        $event = ToeicTestEventModel::find($eventId);

        if (!isset($event)) return back()->with('toast_warning', 'Event tidak ditemukan')->withInput();

        if($event->remaining_quota <= 0) return back()->with('toast_warning', 'Kuota pendaftaran habis')->withInput();

        $newRegistration = $request->except('_token');
        $newRegistration['event_id'] = $event->event_id;

        $departement  = DepartementModel::find($request->departement);
        if (!isset($departement)) return back()->withInput()->withErrors('Jurusan tidak ditemukan');
        $newRegistration['departement'] = $departement->name;

        $newRegistration['created_by'] = auth()->user()->user_id;
        $newRegistration['updated_by'] = auth()->user()->user_id;

        $checkEmail = ToeicTestRegistrationsModel::where('event_id', $event->event_id)
                                         ->where('email', $newRegistration['email'] )
                                         ->first();

        if (isset($checkEmail)) return back()->with('toast_warning', 'Email sudah didaftarkan')->withInput();

        try{
            DB::beginTransaction();
            $event->update([
                'remaining_quota' => ($event->remaining_quota - 1),
            ]); 
            //Ktp rename file
            $ktp = $request->ktp_img;
            $imageName = $event->event_id.'_'.Str::random(5).'.'.$ktp->getClientOriginalExtension();
            $ktp->storeAs('public/ktp', $imageName);
            $newRegistration['ktp_img'] = $imageName;
    
            //Ktm rename file
            $ktm = $request->ktm_img;
            $imageName = $event->event_id.'_'.Str::random(5).'.'.$ktm->getClientOriginalExtension();
            $ktm->storeAs('public/ktm', $imageName);
            $newRegistration['ktm_img'] = $imageName;
    
            //Surat Pernyataan IISMA rename file
            $srtPrytnis = $request->surat_pernyataan_iisma;
            $imageName = $event->event_id.'_'.Str::random(5).'.'.$srtPrytnis->getClientOriginalExtension();
            $srtPrytnis->storeAs('public/surat_pernyataan_iisma', $imageName);
            $newRegistration['surat_pernyataan_iisma'] = $imageName;
    
            //Pas Foto IISMA rename file
            $pasFoto = $request->pasFoto_img;
            $imageName = $event->event_id.'_'.Str::random(5).'.'.$pasFoto->getClientOriginalExtension();
            $pasFoto->storeAs('public/pasFoto', $imageName);
            $newRegistration['pasFoto_img'] = $imageName;
    
            $newRegistration = ToeicTestRegistrationsModel::create($newRegistration);

            DB::commit();

            if($event->status == 1){
                try {
                    $this->sendNotif([
                        'name' => $newRegistration->name,
                        'email' => $newRegistration->email,
                        'nim' => $newRegistration->nim,
                        'execution' => $event->execution,
                        'wa_group_link' => isset($event->wa_group_link) ? $event->wa_group_link : null,
                    ]);
                    
                } catch (\Throwable $th) {
                    return redirect()->route('admin.data.detail.registers', $eventId)->with('toast_success', 'Pendaftaran test bahasa inggris TOEIC '.$newRegistration->name.' berhasil');
                }

            }

            return redirect()->route('admin.data.detail.registers', $eventId)->with('toast_success', 'Pendaftaran test bahasa inggris TOEIC '.$newRegistration->name.' berhasil');
        }catch (\Throwable $th){
            return back()->withInput()->with('toast_error','Internal Server Error');
        }
    }

    public function sendNotif($data)
    {
        Mail::to($data['email'])->send(new RegistrationMail($data));
    }

    public function editRegister($eventId, $registerId)
    {
        $departements = DepartementModel::all();
        $register = ToeicTestRegistrationsModel::find($registerId);
        $selectedDept = $departements->where('name',$register->departement)->first();
        $prodys = ProdyModel::where('departement_id', $selectedDept->departement_id)->get();

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
            'departement' => 'required',
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

        $registration = ToeicTestRegistrationsModel::find($registerId);
        if (!isset($registration)) return back()->with('toast_warning', 'Register tidak ditemukan')->withInput();

        $event = ToeicTestEventModel::find($eventId);
        if (!isset($event)) return back()->with('toast_warning', 'Event tidak ditemukan')->withInput();

        $newRegistration = $request->except('_token');
        $newRegistration['event_id'] = $event->event_id;

        $departement  = DepartementModel::find($request->departement);
        if (!isset($departement)) return back()->withInput()->withErrors('Jurusan tidak ditemukan');
        $newRegistration['departement'] = $departement->name;

        $newRegistration['updated_by'] = auth()->user()->user_id;

        $checkEmail = ToeicTestRegistrationsModel::where('event_id', $event->event_id)
                                         ->where('registration_id', '<>', $registerId)
                                         ->where('email', $newRegistration['email'] )
                                         ->first();

        if (isset($checkEmail)) return back()->with('toast_warning', 'Email sudah didaftarkan')->withInput();

        try {
            DB::beginTransaction();
            //Ktp update file
            if(isset( $request->ktp_img)){
                $ktp = $request->ktp_img;
                $fileName = $event->event_id.'_'.Str::random(5).'.'.$ktp->getClientOriginalExtension();
                $ktp->storeAs('public/ktp', $fileName);
                $newRegistration['ktp_img'] = $fileName;

                //delete old ktp
                Storage::delete('public/ktp/'.$registration->ktp_img);
            }   
    
            //Ktm update file
            if(isset( $request->ktm_img)){
                $ktm = $request->ktm_img;
                $fileName = $event->event_id.'_'.Str::random(5).'.'.$ktm->getClientOriginalExtension();
                $ktm->storeAs('public/ktm', $fileName);
                $newRegistration['ktm_img'] = $fileName;
                //delete old ktm
                Storage::delete('public/ktm/'.$registration->ktm_img);
            }
    
            //Surat Pernyataan IISMA update file
            if(isset( $request->surat_pernyataan_iisma)){
                $srtPrytnis = $request->surat_pernyataan_iisma;
                $fileName = $event->event_id.'_'.Str::random(5).'.'.$srtPrytnis->getClientOriginalExtension();
                $srtPrytnis->storeAs('public/surat_pernyataan_iisma', $fileName);
                $newRegistration['surat_pernyataan_iisma'] = $fileName;
                //delete old Surat Pernyataan IISMA
                Storage::delete('public/surat_pernyataan_iisma/'.$registration->surat_pernyataan_iisma);
            }
    
            //Pas Foto update file
            if(isset( $request->pasFoto_img)){
                $pasFoto = $request->pasFoto_img;
                $fileName = $event->event_id.'_'.Str::random(5).'.'.$pasFoto->getClientOriginalExtension();
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

    public function deleteRegister(Request $request)
    {

        $request->validate([
            'registerId' => 'required',
            'eventId' => 'required',
        ]);

        try {
            DB::beginTransaction();

            $register = ToeicTestRegistrationsModel::find($request->registerId);
            $register->delete([
                'deleted_by' => auth()->user()->user_id
            ]);
    
            $event = ToeicTestEventModel::find($register->event_id);
            $event->update([
                'remaining_quota' => ($event->remaining_quota + 1),
            ]); 
    
            DB::commit();
    
            return redirect()->route('admin.data.detail.registers', $request->eventId)->with('toast_success', 'Pendaftar Berhasil Dihapus');
        } catch (\Throwable $th) {
            
            return redirect()->route('admin.data.detail.registers', $request->eventId)->with('toast_error', 'Gagal menghapus data pendaftaran');
        }

    }

    public function detailRegister($eventId, $registerId)
    {
        $register = ToeicTestRegistrationsModel::find($registerId);


        return view('admin.data-event.detail-registers.detail-data-register', [
            'register' => $register,
            'event_id' => $eventId,
        ]);
    }

    public function downloadKTP($fileName)
    {
        $path = public_path("storage/ktp/". $fileName);

        return response()->download($path);
    }

    
    public function downloadKTM($fileName)
    {
        $path = public_path("storage/ktm/". $fileName);

        return response()->download($path);
    }

    public function downloadSuratPernyataan($fileName, $viewPdf )
    {

        $path = public_path("storage/surat_pernyataan_iisma/". $fileName);
        if($viewPdf){
            return response()->file($path);
        }

        return response()->download($path);

    }

    public function downloadPasFoto($fileName)
    {
        $path = public_path("storage/pasFoto/". $fileName);

        return response()->download($path);
    }
}
