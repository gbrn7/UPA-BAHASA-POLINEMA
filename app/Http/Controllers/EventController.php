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

        $activeEvents = $events->where('status', true);

        if (isset($activeEvents)) {
            $dateNow = Carbon::now();
            foreach ($activeEvents as $key => $event) {
                $registerEnd = Carbon::parse($event->register_end);

                if ($dateNow->greaterThan($registerEnd) || $event->remaining_quota <= 0) {
                    $event->update(['status' => false]);
                }
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


        try {
            $registerStart = Carbon::parse(explode(' - ', $request->registration_range)[0])->startOfDay();
            $registerEnd = Carbon::parse(explode(' - ', $request->registration_range)[1])->endOfDay();
            $execution = Carbon::parse($request->execution);
        } catch (\Throwable $th) {
            back()->with('toast_warning', $th->getMessage())->withInput();
        }

        if ($execution->lessThan($registerEnd)) {
            return back()->with('toast_warning', 'Tanggal pelaksanaan harus lebih dari rentang tanggal pendaftaran')->withInput();
        }

        try {
            $newEvent = ToeicTestEventModel::create([
                'register_start' => $registerStart,
                'register_end' => $registerEnd,
                'execution' => $execution,
                'quota' => $request->quota,
                'remaining_quota' => $request->quota,
                'wa_group_link' => isset($request->wa_group_link) ? $request->wa_group_link : null,
                'status' => $request->status,
                'created_by' => auth()->user()->user_id,
                'updated_by' => auth()->user()->user_id
            ]);

            return redirect()->route('admin.data.event')->with('toast_success', 'Event Berhasil Ditambahkan');
        } catch (\Throwable $th) {
            return redirect()->route('admin.data.event')->with('toast_warning', 'Internal Server Error');
        }
    }

    public function editEvent($toeic_test_events_id)
    {
        $event = ToeicTestEventModel::where('toeic_test_events_id', $toeic_test_events_id)->first();
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

    public function updateEvent($toeic_test_events_id, Request $request)
    {
        $request->validate([
            'registration_range' => 'required',
            'execution' => 'required',
            'quota' => 'required',
            'status' => 'required|boolean',
            'wa_group_link' => 'nullable',
        ]);

        DB::beginTransaction();
        $oldEvent = ToeicTestEventModel::where('toeic_test_events_id', $toeic_test_events_id)->lockForUpdate()->withCount('registers')->first();

        try {
            $registerStart = Carbon::parse(explode(' - ', $request->registration_range)[0])->startOfDay();
            $registerEnd = Carbon::parse(explode(' - ', $request->registration_range)[1])->endOfDay();
            $execution = Carbon::parse($request->execution);
        } catch (\Throwable $th) {
            back()->with('toast_warning', $th->getMessage())->withInput();
        }

        if ($execution->lessThan($registerEnd)) {
            return back()->with('toast_warning', 'Tanggal pelaksanaan harus lebih dari rentang tanggal pendaftaran')->withInput();
        }

        try {
            $oldEvent->update([
                'register_start' => $registerStart,
                'register_end' => $registerEnd,
                'execution' => $execution,
                'quota' => $request->quota,
                'remaining_quota' => ($request->quota - $oldEvent->registers_count),
                'wa_group_link' => isset($request->wa_group_link) ? $request->wa_group_link : null,
                'status' => $request->status,
                'created_by' => auth()->user()->user_id,
                'updated_by' => auth()->user()->user_id
            ]);
            DB::commit();

            return redirect()->route('admin.data.event')->with('toast_success', 'Event Berhasil Diedit');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('admin.data.event')->with('toast_warning', 'Internal Server Error');
        }
    }

    public function deleteEvent(Request $request)
    {

        $request->validate([
            'deleteId' => 'required',
        ]);

        try {
            $event = ToeicTestEventModel::find($request->deleteId);

            if (!$event) return back()->with('toast_error', 'Kursus Tidak Ditemukan');

            $event->delete([
                'deleted_by' => auth()->user()->user_id
            ]);

            return redirect()->route('admin.data.event')->with('toast_success', 'Event Berhasil Dihapus');
        } catch (\Throwable $th) {
            return redirect()->route('admin.data.event')->with('toast_error', 'Internal Server Error');
        }
    }

    public function detailRegisters($toeic_test_events_id)
    {
        $detailRegisters = ToeicTestRegistrationsModel::where('toeic_test_events_id', $toeic_test_events_id)
            ->get();

        $event = ToeicTestEventModel::find($toeic_test_events_id);

        return view('admin.data-event.detail-registers.detail-registers', [
            'detailRegisters' => $detailRegisters,
            'event' => $event
        ]);
    }

    public function exportToeicData(string $toeic_test_events_id)
    {
        return Excel::download(new ToiecDataExport($toeic_test_events_id), 'Data Pendaftar TOEIC Batch-' . $toeic_test_events_id . '.xlsx');
    }

    public function createRegister($toeic_test_events_id)
    {
        $departements = DepartementModel::all();
        $prodys = ProdyModel::all();

        return view('admin.data-event.detail-registers.create-data-register', [
            'departements' => $departements,
            'prodys' => $prodys,
            'toeic_test_events_id' => $toeic_test_events_id,
        ]);
    }

    public function saveRegister(Request $request, $toeic_test_events_id)
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
            'surat_pernyataan_iisma' => 'nullable|mimes:pdf|extensions:pdf|max:5120',
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

        if ($validator->fails()) {
            return back()
                ->withInput()
                ->withErrors($validator->messages()->all());
        }

        $event = ToeicTestEventModel::lockForUpdate()->find($toeic_test_events_id);

        if (!isset($event)) return back()->with('toast_warning', 'Event tidak ditemukan')->withInput();

        if ($event->remaining_quota <= 0) return back()->with('toast_warning', 'Kuota pendaftaran habis')->withInput();

        $newRegistration = $request->except('_token');
        $newRegistration['toeic_test_events_id'] = $event->toeic_test_events_id;

        $departement  = DepartementModel::find($request->departement);
        if (!isset($departement)) return back()->withInput()->withErrors('Jurusan tidak ditemukan');
        $newRegistration['departement'] = $departement->name;

        $newRegistration['created_by'] = auth()->user()->user_id;
        $newRegistration['updated_by'] = auth()->user()->user_id;

        $checkEmail = ToeicTestRegistrationsModel::where('toeic_test_events_id', $event->toeic_test_events_id)
            ->where('email', $newRegistration['email'])
            ->first();

        if (isset($checkEmail)) return back()->with('toast_warning', 'Email sudah didaftarkan')->withInput();

        try {
            DB::beginTransaction();
            //Ktp rename file
            $ktp = $request->ktp_img;
            $imageName = $event->toeic_test_events_id . '_' . Str::random(12) . '.' . $ktp->getClientOriginalExtension();
            $ktp->storeAs('public/ktp', $imageName);
            $newRegistration['ktp_img'] = $imageName;

            //Ktm rename file
            $ktm = $request->ktm_img;
            $imageName = $event->toeic_test_events_id . '_' . Str::random(12) . '.' . $ktm->getClientOriginalExtension();
            $ktm->storeAs('public/ktm', $imageName);
            $newRegistration['ktm_img'] = $imageName;

            //Surat Pernyataan IISMA rename file
            if (isset($request->surat_pernyataan_iisma)) {
                $srtPrytnis = $request->surat_pernyataan_iisma;
                $imageName = $event->toeic_test_events_id . '_' . Str::random(12) . '.' . $srtPrytnis->getClientOriginalExtension();
                $srtPrytnis->storeAs('public/surat_pernyataan_iisma', $imageName);
                $newRegistration['surat_pernyataan_iisma'] = $imageName;
            }

            //Pas Foto IISMA rename file
            $pasFoto = $request->pasFoto_img;
            $imageName = $event->toeic_test_events_id . '_' . Str::random(12) . '.' . $pasFoto->getClientOriginalExtension();
            $pasFoto->storeAs('public/pasFoto', $imageName);
            $newRegistration['pasFoto_img'] = $imageName;

            $newRegistration = ToeicTestRegistrationsModel::create($newRegistration);

            $event->update([
                'remaining_quota' => ($event->remaining_quota - 1),
            ]);

            DB::commit();

            if ($event->status == 1) {
                try {
                    $this->sendNotif([
                        'name' => $newRegistration->name,
                        'email' => $newRegistration->email,
                        'nim' => $newRegistration->nim,
                        'execution' => $event->execution,
                        'wa_group_link' => isset($event->wa_group_link) ? $event->wa_group_link : null,
                    ]);
                } catch (\Throwable $th) {
                    return redirect()->route('admin.data.detail.registers', $toeic_test_events_id)->with('toast_success', 'Pendaftaran test bahasa inggris TOEIC ' . $newRegistration->name . ' berhasil');
                }
            }

            return redirect()->route('admin.data.detail.registers', $toeic_test_events_id)->with('toast_success', 'Pendaftaran test bahasa inggris TOEIC ' . $newRegistration->name . ' berhasil');
        } catch (\Throwable $th) {
            DB::rollback();

            return back()->withInput()->with('toast_error', 'Internal Server Error');
        }
    }

    public function sendNotif($data)
    {
        Mail::to($data['email'])->send(new RegistrationMail($data));
    }

    public function editRegister($toeic_test_events_id, $toeic_test_registrations_id)
    {
        $departements = DepartementModel::all();
        $register = ToeicTestRegistrationsModel::find($toeic_test_registrations_id);
        $selectedDept = $departements->where('name', $register->departement)->first();
        $prodys = ProdyModel::where('departement_id', $selectedDept->departement_id)->get();

        if (!isset($register)) return back()->with('toast_warning', 'Pendaftar tidak ditemukan');

        return view('admin.data-event.detail-registers.edit-data-register', [
            'departements' => $departements,
            'prodys' => $prodys,
            'toeic_test_events_id' => $toeic_test_events_id,
            'register' => $register,
        ]);
    }

    public function updateRegister(Request $request, $toeic_test_events_id, $toeic_test_registrations_id)
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

        if ($validator->fails()) {
            return back()
                ->withInput()
                ->withErrors($validator->messages()->all());
        }

        $registration = ToeicTestRegistrationsModel::find($toeic_test_registrations_id);
        if (!isset($registration)) return back()->with('toast_warning', 'Register tidak ditemukan')->withInput();

        $event = ToeicTestEventModel::find($toeic_test_events_id);
        if (!isset($event)) return back()->with('toast_warning', 'Event tidak ditemukan')->withInput();

        $newRegistration = $request->except('_token');
        $newRegistration['toeic_test_events_id'] = $event->toeic_test_events_id;

        $departement  = DepartementModel::find($request->departement);
        if (!isset($departement)) return back()->withInput()->withErrors('Jurusan tidak ditemukan');
        $newRegistration['departement'] = $departement->name;

        $newRegistration['updated_by'] = auth()->user()->user_id;

        $checkEmail = ToeicTestRegistrationsModel::where('toeic_test_events_id', $event->toeic_test_events_id)
            ->where('toeic_test_registrations_id', '<>', $toeic_test_registrations_id)
            ->where('email', $newRegistration['email'])
            ->first();

        if (isset($checkEmail)) return back()->with('toast_warning', 'Email sudah didaftarkan')->withInput();

        try {
            DB::beginTransaction();
            //Ktp update file
            if (isset($request->ktp_img)) {
                $ktp = $request->ktp_img;
                $fileName = $event->toeic_test_events_id . '_' . Str::random(12) . '.' . $ktp->getClientOriginalExtension();
                $ktp->storeAs('public/ktp', $fileName);
                $newRegistration['ktp_img'] = $fileName;

                //delete old ktp
                Storage::delete('public/ktp/' . $registration->ktp_img);
            }

            //Ktm update file
            if (isset($request->ktm_img)) {
                $ktm = $request->ktm_img;
                $fileName = $event->toeic_test_events_id . '_' . Str::random(12) . '.' . $ktm->getClientOriginalExtension();
                $ktm->storeAs('public/ktm', $fileName);
                $newRegistration['ktm_img'] = $fileName;
                //delete old ktm
                Storage::delete('public/ktm/' . $registration->ktm_img);
            }

            //Surat Pernyataan IISMA update file
            if (isset($request->surat_pernyataan_iisma)) {
                $srtPrytnis = $request->surat_pernyataan_iisma;
                $fileName = $event->toeic_test_events_id . '_' . Str::random(12) . '.' . $srtPrytnis->getClientOriginalExtension();
                $srtPrytnis->storeAs('public/surat_pernyataan_iisma', $fileName);
                $newRegistration['surat_pernyataan_iisma'] = $fileName;
                //delete old Surat Pernyataan IISMA
                Storage::delete('public/surat_pernyataan_iisma/' . $registration->surat_pernyataan_iisma);
            }

            //Pas Foto update file
            if (isset($request->pasFoto_img)) {
                $pasFoto = $request->pasFoto_img;
                $fileName = $event->toeic_test_events_id . '_' . Str::random(12) . '.' . $pasFoto->getClientOriginalExtension();
                $pasFoto->storeAs('public/pasFoto', $fileName);
                $newRegistration['pasFoto_img'] = $fileName;
                //delete old pasFoto
                Storage::delete('public/pasFoto/' . $registration->pasFoto_img);
            }

            $registration->update($newRegistration);
            DB::commit();

            return redirect()->route('admin.data.detail.registers', $toeic_test_events_id)->with('toast_success', 'Pengeditan pendaftaran test bahasa inggris TOEIC ' . $request->name . ' berhasil');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->withInput()->with('toast_error', 'Internal Server Error');
        }
    }

    public function deleteRegister(Request $request)
    {

        $request->validate([
            'toeic_test_registrations_id' => 'required',
            'toeic_test_events_id' => 'required',
        ]);

        try {
            DB::beginTransaction();

            $register = ToeicTestRegistrationsModel::find($request->toeic_test_registrations_id);
            $register->delete([
                'deleted_by' => auth()->user()->user_id
            ]);

            $event = ToeicTestEventModel::find($register->toeic_test_events_id);
            $event->update([
                'remaining_quota' => ($event->remaining_quota + 1),
            ]);

            DB::commit();

            return redirect()->route('admin.data.detail.registers', $request->toeic_test_events_id)->with('toast_success', 'Pendaftar Berhasil Dihapus');
        } catch (\Throwable $th) {

            return redirect()->route('admin.data.detail.registers', $request->toeic_test_events_id)->with('toast_error', 'Gagal menghapus data pendaftaran');
        }
    }

    public function detailRegister($toeic_test_events_id, $toeic_test_registrations_id)
    {
        $register = ToeicTestRegistrationsModel::find($toeic_test_registrations_id);


        return view('admin.data-event.detail-registers.detail-data-register', [
            'register' => $register,
            'toeic_test_events_id' => $toeic_test_events_id,
        ]);
    }

    public function downloadKTP($fileName)
    {
        $path = public_path("storage/ktp/" . $fileName);

        return response()->download($path);
    }


    public function downloadKTM($fileName)
    {
        $path = public_path("storage/ktm/" . $fileName);

        return response()->download($path);
    }

    public function downloadSuratPernyataan($fileName, $viewPdf)
    {

        $path = public_path("storage/surat_pernyataan_iisma/" . $fileName);
        if ($viewPdf) {
            return response()->file($path);
        }

        return response()->download($path);
    }

    public function downloadPasFoto($fileName)
    {
        $path = public_path("storage/pasFoto/" . $fileName);

        return response()->download($path);
    }
}
