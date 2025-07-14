<?php

namespace App\Http\Controllers;

use App\Mail\CourseRegistrationMail;
use App\Mail\RegistrationMail;
use App\Models\ContentModel;
use App\Models\CourseEventModel;
use App\Models\CourseEventRegistrationModel;
use App\Models\CourseEventScheduleModel;
use App\Models\DepartementModel;
use App\Models\ToeicTestEventModel;
use App\Models\ImageModel;
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
        if ($request->lang) App::setlocale($request->lang);

        $admin = User::first();

        $gallery = ImageModel::where('type', 'gallery')->orderBy('image_id', 'desc')->get();

        $programs = ContentModel::where('type', 'program')->get();

        $profile = ContentModel::where('type', 'profile')->first();

        $toeicEvent = ToeicTestEventModel::where('status', true)
            ->get();

        $courseEvent = CourseEventModel::where('status', true)
            ->withCount([
                'courseEventSchedules' => function ($query) {
                    $query->where('status', true)->where('remaining_quota', '>', 0);
                }
            ])
            ->first();

        if (!isset($toeicEvent) && !isset($courseEvent)) {
            return view('client.landingPage', ['gallery' => $gallery]);
        }

        $activeToeicEvents = collect();

        $dateNow = Carbon::now();

        $activeEvents = [];

        foreach ($toeicEvent as $key => $item) {
            $registerStart = Carbon::parse($item->register_start);
            $registerEnd = Carbon::parse($item->register_end);

            if ($dateNow->greaterThan($registerEnd) || $item->remaining_quota <= 0) {
                $item->update(['status' => false]);
            } else {

                if ($dateNow->between($registerStart, $registerEnd)) {
                    $activeToeicEvents->push($item);
                }
            }
        }

        if ($activeToeicEvents->count() > 0) {
            $activeEvents = [
                'activeToeicEvents' =>  $activeToeicEvents,
            ];
        }

        if (isset($courseEvent)) {
            $registerStart = Carbon::parse($courseEvent->register_start);
            $registerEnd = Carbon::parse($courseEvent->register_end);

            if ($dateNow->greaterThan($registerEnd)) {
                $courseEvent->update(['status' => false]);
            } else {
                if ($dateNow->between($registerStart, $registerEnd)) {
                    $activeEvents['activeCourseEvent'] = $courseEvent->course_event_schedules_count ? $courseEvent : null;
                } else {
                    $activeEvents['activeCourseEvent'] = null;
                }
            }
        }

        return view(
            'client.landingPage',
            [
                'activeEvents' => (count($activeEvents) > 0 ? (object) $activeEvents : null),
                'adminPhoneNum' => $admin->phone_num,
                'gallery' => count($gallery) > 0 ? $gallery : null,
                'programs' => count($programs) > 0 ? $programs : null,
                'profile' => isset($profile) ? $profile : null
            ]
        );
    }

    public function sop(Request $request)
    {
        if ($request->lang) App::setlocale($request->lang);

        $admin = User::first();

        $image_toeic = ImageModel::where('type', 'sop-toeic')->first();
        $image_consult = ImageModel::where('type', 'sop-consult')->first();

        $toeicEvent = ToeicTestEventModel::where('status', true)->get();

        $courseEvent = CourseEventModel::where('status', true)
            ->withCount([
                'courseEventSchedules' => function ($query) {
                    $query->where('status', true);
                }
            ])
            ->first();

        if (!isset($toeicEvent) && !isset($courseEvent)) {
            return view('client.sop', ['image_toeic' => $image_toeic, 'image_consult' => $image_consult]);
        }

        $activeToeicEvents = collect();

        $dateNow = Carbon::now();

        $activeEvents = [];

        foreach ($toeicEvent as $key => $item) {
            $registerEnd = Carbon::parse($item->register_end);

            if ($dateNow->greaterThan($registerEnd) || $item->remaining_quota <= 0) {
                $item->update(['status' => false]);
            } else {
                $activeToeicEvents->push($item);
            }
        }

        if ($activeToeicEvents->count() > 0) {
            $activeEvents = [
                'activeToeicEvents' =>  $activeToeicEvents,
            ];
        }

        if (isset($courseEvent)) {
            $registerEnd = Carbon::parse($courseEvent->register_end);

            if ($dateNow->greaterThan($registerEnd)) {
                $courseEvent->update(['status' => false]);
            } else {
                $activeEvents['activeCourseEvent'] = $courseEvent->course_event_schedules_count ? $courseEvent : null;
            }
        }

        return view('client.sop', ['activeEvent' => (count($activeEvents) > 0 ? (object) $activeEvents : null), 'adminPhoneNum' => $admin->phone_num, 'image_toeic' => $image_toeic, 'image_consult' => $image_consult]);
    }

    public function structureOrganization(Request $request)
    {
        if ($request->lang) App::setlocale($request->lang);

        $admin = User::first();

        $image = ImageModel::where('type', 'structure_organization')->first();

        $toeicEvent = ToeicTestEventModel::where('status', true)->get();

        $courseEvent = CourseEventModel::where('status', true)
            ->withCount([
                'courseEventSchedules' => function ($query) {
                    $query->where('status', true);
                }
            ])
            ->first();

        if (!isset($toeicEvent) && !isset($courseEvent)) {
            return view('client.structure-organization', ['image' => $image]);
        }

        $activeToeicEvents = collect();

        $dateNow = Carbon::now();

        $activeEvents = [];

        foreach ($toeicEvent as $key => $item) {
            $registerEnd = Carbon::parse($item->register_end);

            if ($dateNow->greaterThan($registerEnd) || $item->remaining_quota <= 0) {
                $item->update(['status' => false]);
            } else {
                $activeToeicEvents->push($item);
            }
        }

        if ($activeToeicEvents->count() > 0) {
            $activeEvents = [
                'activeToeicEvents' =>  $activeToeicEvents,
            ];
        }

        if (isset($courseEvent)) {
            $registerEnd = Carbon::parse($courseEvent->register_end);

            if ($dateNow->greaterThan($registerEnd)) {
                $courseEvent->update(['status' => false]);
            } else {
                $activeEvents['activeCourseEvent'] = $courseEvent->course_event_schedules_count ? $courseEvent : null;
            }
        }

        return view('client.structure-organization', ['activeEvent' => (count($activeEvents) > 0 ? (object)$activeEvents : null), 'adminPhoneNum' => $admin->phone_num, 'image' => $image]);
    }

    public function englishTestFormView(Request $request)
    {
        if ($request->lang) App::setlocale($request->lang);

        $events = ToeicTestEventModel::where('status', true)->where('remaining_quota', '>', 0)->get();

        if (!isset($events)) {
            return redirect()->route('client');
        }

        $activeEvents = collect();

        $dateNow = Carbon::now();

        foreach ($events as $key => $activeEvent) {
            $registerEnd = Carbon::parse($activeEvent->register_end);

            if ($dateNow->greaterThan($registerEnd) || $activeEvent->remaining_quota <= 0) {
                $activeEvent->update(['status' => false]);
            } else {
                $activeEvents->push($activeEvent);
            }
        }

        $departements = DepartementModel::all();

        if (count($activeEvents) <= 0) return redirect()->route('client')->with('toast_warning', 'Event tes TOEIC tidak ditemukan');


        return view(
            'client.form-english-test',
            [
                'activeEvents' =>  $activeEvents,
                'departements' => $departements,
            ]
        );
    }

    public function languageCourseFormView(Request $request)
    {
        if ($request->lang) App::setlocale($request->lang);

        $activeEvent = CourseEventModel::where('status', true)
            ->with('courseEventSchedules.courseType')
            ->whereRelation('courseEventSchedules', 'status', true)
            ->whereRelation('courseEventSchedules', 'remaining_quota', '>', 0)
            ->first();

        if (!isset($activeEvent)) {
            return redirect()->route('client');
        } else {
            $dateNow = Carbon::now();
            $registerEnd = Carbon::parse($activeEvent->register_end);

            if ($dateNow->greaterThan($registerEnd)) {
                $activeEvent->update(['status' => false]);
                return redirect()->route('client');
            }
        }

        return view(
            'client.form-course',
            [
                'activeEvent' =>  $activeEvent,
            ]
        );
    }

    public function saveToeicTestRegistration(Request $request)
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

        $activeEvent = ToeicTestEventModel::where('status', true)->where('toeic_test_events_id', $request->toeic_test_events_id)->lockForUpdate()->first();

        if (!isset($activeEvent)) return redirect()->route('client')->with('toast_warning', 'Event tidak ditemukan');

        if ($activeEvent->quota <= 0) return redirect()->route('client')->with('toast_warning', 'Kuota telah habis');

        $newRegistration = $request->except('_token');

        $departement  = DepartementModel::find($request->departement);
        if (!isset($departement)) return back()->withInput()->withErrors('Jurusan tidak ditemukan');
        $newRegistration['departement'] = $departement->name;

        $checkEmail = ToeicTestRegistrationsModel::where('toeic_test_events_id', $activeEvent->toeic_test_events_id)
            ->where('email', $newRegistration['email'])
            ->first();

        if (isset($checkEmail)) return back()->withInput()->withErrors('Pendaftaran anda sudah terdaftar pada test TOEIC batch ini');

        try {
            DB::beginTransaction();
            //Ktp rename file
            $ktp = $request->ktp_img;
            $imageName = $activeEvent->toeic_test_events_id . '_' . Str::random(12) . '.' . $ktp->getClientOriginalExtension();
            $ktp->storeAs('public/ktp', $imageName);
            $newRegistration['ktp_img'] = $imageName;

            //Ktm rename file
            $ktm = $request->ktm_img;
            $imageName = $activeEvent->toeic_test_events_id . '_' . Str::random(12) . '.' . $ktm->getClientOriginalExtension();
            $ktm->storeAs('public/ktm', $imageName);
            $newRegistration['ktm_img'] = $imageName;

            //Surat Pernyataan IISMA rename file
            if (isset($request->surat_pernyataan_iisma)) {
                $srtPrytnis = $request->surat_pernyataan_iisma;
                $imageName = $activeEvent->toeic_test_events_id . '_' . Str::random(12) . '.' . $srtPrytnis->getClientOriginalExtension();
                $srtPrytnis->storeAs('public/surat_pernyataan_iisma', $imageName);
                $newRegistration['surat_pernyataan_iisma'] = $imageName;
            }

            //Pas Foto rename file
            $pasFoto = $request->pasFoto_img;
            $imageName = $activeEvent->toeic_test_events_id . '_' . Str::random(12) . '.' . $pasFoto->getClientOriginalExtension();
            $pasFoto->storeAs('public/pasFoto', $imageName);
            $newRegistration['pasFoto_img'] = $imageName;

            $newRegistration = ToeicTestRegistrationsModel::create($newRegistration);

            $activeEvent->update([
                'remaining_quota' => ($activeEvent->remaining_quota - 1),
            ]);

            DB::commit();

            try {
                $this->sendToeicNotif([
                    'name' => $newRegistration->name,
                    'email' => $newRegistration->email,
                    'nim' => $newRegistration->nim,
                    'execution' => $activeEvent->execution,
                    'wa_group_link' => isset($activeEvent->wa_group_link) ? $activeEvent->wa_group_link : null,
                ]);
                return back()->withSuccess('Pendaftaran test bahasa inggris TOEIC ' . $newRegistration->name . ' berhasil, silahkan cek email anda ' . (isset($activeEvent->wa_group_link) ? 'untuk mengikuti grup WhatsApp pendaftar' : ''));
            } catch (\Throwable $th) {
                return back()->withSuccess('Pendaftaran test bahasa inggris TOEIC ' . $newRegistration->name . ' berhasil');
            }
        } catch (\Throwable $th) {
            return back()->withInput()->withErrors('Internal Server Error');
        }
    }

    public function saveCourseEventRegistration(Request $request)
    {
        $validation = [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone_num' => 'required|string',
            'course' => 'required',
            'address' => 'required',
            'goal' => 'nullable|string',
            'experience' => 'nullable|string',
            'ktp_or_passport_img' => 'required|mimes:png,jpg,jpeg|max:1024',
        ];

        $messages = [
            'required' => ':attribute harus diisi',
            'ktp_or_passport_img.required' => 'Foto ktp atau passport harus diisi',
            'string' => 'Kolom :attribute harus bertipe teks atau string',
            'email' => 'Kolom :attribute harus bertipe email',
            'max' => ':attribute maksimal :max kb',
            'ktp_or_passport_img.mimes' => 'File ktp harus bertipe :values',
        ];

        $validator = Validator::make($request->all(), $validation, $messages);

        if ($validator->fails()) {
            return back()
                ->withInput()
                ->withErrors($validator->messages()->all());
        }

        $schedule = CourseEventScheduleModel::where('status', true)->where('course_event_schedule_id', $request->course)->first();

        if (!isset($schedule)) return back()->with('toast_warning', 'Jadwal tidak ditemukan')->withInput();

        if ($schedule->remaining_quota <= 0) return back()->with('toast_warning', 'Kuota pendaftaran habis')->withInput();

        $batch = CourseEventModel::find($schedule->course_events_id);

        if (!isset($batch)) return back()->with('toast_warning', 'Batch tidak ditemukan')->withInput();

        if ($batch->status == false) return back()->with('toast_warning', 'Batch tidak aktif')->withInput();

        $newRegistration = $request->except('_token');
        $newRegistration['course_event_schedule_id'] = $schedule->course_event_schedule_id;

        $checkEmail = CourseEventRegistrationModel::where('course_event_schedule_id', $schedule->course_event_schedule_id)
            ->where('email', $newRegistration['email'])
            ->first();

        if (isset($checkEmail)) return back()->with('toast_warning', 'Email sudah didaftarkan')->withInput();

        try {
            DB::beginTransaction();
            $schedule->update([
                'remaining_quota' => ($schedule->remaining_quota - 1),
            ]);

            //Ktp rename file
            $ktpOrPassport = $request->ktp_or_passport_img;
            $imageName = $schedule->course_event_schedule_id . '_cer_' . Str::random(12) . '.' . $ktpOrPassport->getClientOriginalExtension();
            $ktpOrPassport->storeAs('public/ktp', $imageName);
            $newRegistration['ktp_or_passport_img'] = $imageName;


            $newRegistration = CourseEventRegistrationModel::create($newRegistration);

            DB::commit();

            if ($schedule->status == 1) {
                try {
                    $data = (object) [
                        'name' => $newRegistration->name,
                        'email' => $newRegistration->email,
                        'schedule' => $schedule,
                        'batch' => $batch,
                    ];

                    $this->sendCourseRegisNotif($data);
                    return back()->withSuccess('Pendaftaran kursus ' . $schedule->courseType->name . ' berhasil, silahkan cek email anda');
                } catch (\Throwable $th) {
                    return back()->withSuccess('Pendaftaran kursus ' . $schedule->courseType->name . ' berhasil');
                }
            }
        } catch (\Throwable $th) {
            return back()->withInput()->withErrors('Internal Server Error');
        }
    }

    public function sendToeicNotif($data)
    {
        Mail::to($data['email'])->send(new RegistrationMail($data));
    }

    public function sendCourseRegisNotif($data)
    {
        Mail::to($data->email)->send(new CourseRegistrationMail($data));
    }

    public function getProgramStudy(Request $request)
    {
        $departementId = $request->departement_id;

        $prody  = ProdyModel::where('departement_id', $departementId)->get();

        return response()->json(['data' => $prody]);
    }
}
