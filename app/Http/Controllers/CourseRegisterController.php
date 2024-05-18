<?php

namespace App\Http\Controllers;

use App\Exports\CourseRegisterExport;
use App\Mail\CourseRegistrationMail;
use App\Models\CourseEventRegistrationModel;
use App\Models\CourseEventScheduleModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class CourseRegisterController extends Controller
{
    public function index(string $CourseEventId, string $CourseEventScheduleId)
    {
        $courseEventSchedule = CourseEventScheduleModel::with('courseEventsRegisters')->with('courseType')->find($CourseEventScheduleId);

        if (!$courseEventSchedule) return back()->with('toast_error', 'Course Event ID Invalid');

        return view('admin.data-course.data-course-schedule.data-course-register.index', ['courseEventSchedule' => $courseEventSchedule]);
    }

    public function create(string $CourseEventId, string $CourseEventScheduleId)
    {
        $courseEventSchedule = CourseEventScheduleModel::with('courseType')->find($CourseEventScheduleId);

        if (!$courseEventSchedule) return back()->with('toast_error', 'Course Event ID Invalid');

        return view('admin.data-course.data-course-schedule.data-course-register.create', ['courseEventSchedule' => $courseEventSchedule]);
    }

    public function store(Request $request, string $CourseEventId, string $CourseEventScheduleId)
    {
        $validation = [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone_num' => 'required|string',
            'goal' => 'nullable|string',
            'experience' => 'nullable|string',
            'address' => 'required',
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

        $schedule = CourseEventScheduleModel::find($CourseEventScheduleId);

        if (!isset($schedule)) return back()->with('toast_warning', 'Jadwal tidak ditemukan')->withInput();

        if ($schedule->remaining_quota <= 0) return back()->with('toast_warning', 'Kuota pendaftaran habis')->withInput();

        $newRegistration = $request->except('_token');
        $newRegistration['course_event_schedule_id'] = $schedule->course_event_schedule_id;

        $newRegistration['created_by'] = auth()->user()->user_id;
        $newRegistration['updated_by'] = auth()->user()->user_id;

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
            $imageName = $schedule->course_event_schedule_id . '_cer_' . Str::random(5) . '.' . $ktpOrPassport->getClientOriginalExtension();
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
                    ];

                    $this->sendNotif($data);
                } catch (\Throwable $th) {
                    return redirect()->route('admin.data-course.data-schedule.data-registers.index', [$schedule->course_events_id, $schedule->course_event_schedule_id])->with('toast_success', 'Pendaftaran Kursus berhasil');
                }
            }

            return redirect()->route('admin.data-course.data-schedule.data-registers.index', [$schedule->course_events_id, $schedule->course_event_schedule_id])->with('toast_success', 'Pendaftaran Kursus berhasil');
        } catch (\Throwable $th) {
            return back()->withInput()->with('toast_error', 'Internal Server Error');
        }
    }

    public function sendNotif($data)
    {
        Mail::to($data->email)->send(new CourseRegistrationMail($data));
    }

    public function edit(string $CourseEventId, string $CourseEventScheduleId, string $CourseEventRegistrationsId)
    {
        $courseEventSchedule = CourseEventScheduleModel::with('courseType')->find($CourseEventScheduleId);

        if (!$courseEventSchedule) return back()->with('toast_error', 'Course Event ID Invalid');

        $register = CourseEventRegistrationModel::find($CourseEventRegistrationsId);

        if (!$register) return back()->with('toast_error', 'Register ID Invalid');

        return view('admin.data-course.data-course-schedule.data-course-register.edit', ['courseEventSchedule' => $courseEventSchedule, 'register' => $register]);
    }

    public function update(Request $request, string $CourseEventId, string $CourseEventScheduleId, string $CourseEventRegistrationsId)
    {
        $validation = [
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email',
            'phone_num' => 'nullable|string',
            'goal' => 'nullable|string',
            'experience' => 'nullable|string',
            'address' => 'nullable',
            'ktp_or_passport_img' => 'nullable|mimes:png,jpg,jpeg|max:1024',
        ];

        $messages = [
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

        $registration = CourseEventRegistrationModel::find($CourseEventRegistrationsId);
        if (!isset($registration)) return back()->with('toast_warning', 'Register tidak ditemukan')->withInput();

        $schedule = CourseEventScheduleModel::find($CourseEventScheduleId);

        if (!isset($schedule)) return back()->with('toast_warning', 'Jadwal tidak ditemukan')->withInput();

        $newData = $request->except('_token');

        $newData['updated_by'] = auth()->user()->user_id;

        $checkEmail = CourseEventRegistrationModel::where('course_event_schedule_id', $schedule->course_event_schedule_id)
            ->where('course_event_registrations_id', '<>', $CourseEventRegistrationsId)
            ->where('email', $newData['email'])
            ->first();

        if (isset($checkEmail)) return back()->with('toast_warning', 'Email sudah didaftarkan')->withInput();

        try {
            DB::beginTransaction();

            if ($request->ktp_or_passport_img) {
                //Ktp rename file
                $ktpOrPassport = $request->ktp_or_passport_img;
                $imageName = $schedule->course_event_schedule_id . '_cer_' . Str::random(5) . '.' . $ktpOrPassport->getClientOriginalExtension();
                $ktpOrPassport->storeAs('public/ktp', $imageName);
                $newData['ktp_or_passport_img'] = $imageName;

                //delete old ktp
                Storage::delete('public/ktp/' . $registration->ktp_img);
            }


            $registration->update($newData);

            DB::commit();

            return redirect()->route('admin.data-course.data-schedule.data-registers.index', [$schedule->course_events_id, $schedule->course_event_schedule_id])->with('toast_success', 'Pendaftaran Kursus berhasil');
        } catch (\Throwable $th) {
            return back()->withInput()->with('toast_error', 'Internal Server Error');
        }
    }

    public function delete(Request $request)
    {
        $request->validate([
            'course_event_schedule_id' => 'required',
            'course_event_registrations_id' => 'required',
        ]);

        try {
            DB::beginTransaction();

            $register = CourseEventRegistrationModel::find($request->course_event_registrations_id);
            if (!isset($register)) return back()->with('toast_warning', 'Pendaftar tidak ditemukan')->withInput();

            $register->delete([
                'deleted_by' => auth()->user()->user_id
            ]);

            $schedule = CourseEventScheduleModel::find($register->course_event_schedule_id);
            if (!isset($schedule)) return back()->with('toast_warning', 'Jadwal tidak ditemukan')->withInput();

            $schedule->update([
                'remaining_quota' => ($schedule->remaining_quota + 1),
            ]);

            DB::commit();

            return redirect()->route('admin.data-course.data-schedule.data-registers.index', [$schedule->course_events_id, $schedule->course_event_schedule_id, $register->course_event_registrations_id])->with('toast_success', 'Data pendaftaran berhasil dihapus');
        } catch (\Throwable $th) {
            return redirect()->route('admin.data.detail.registers', $request->toeic_test_events_id)->with('toast_error', 'Gagal menghapus data pendaftaran');
        }
    }

    public function show(string $CourseEventId, string $CourseEventScheduleId, string $CourseEventRegistrationsId)
    {
        $courseEventSchedule = CourseEventScheduleModel::with('courseType')->find($CourseEventScheduleId);
        if (!$courseEventSchedule) return back()->with('toast_error', 'Course Event ID Invalid');

        $register = CourseEventRegistrationModel::find($CourseEventRegistrationsId);
        if (!$register) return back()->with('toast_error', 'Register ID Invalid');

        return view('admin.data-course.data-course-schedule.data-course-register.show', [
            'register' => $register,
            'courseEventSchedule' => $courseEventSchedule
        ]);
    }

    public function exportCourseRegister(string $CourseEventScheduleId)
    {
        $courseEventSchedule = CourseEventScheduleModel::with('courseType')
            ->find($CourseEventScheduleId);

        if (!$courseEventSchedule) return back()->with('toast_error', 'Course Event Schedule ID Invalid');

        $timeStart = date("H.i", strtotime($courseEventSchedule->time_start));
        $timeEnd = date("H.i", strtotime($courseEventSchedule->time_end));

        return Excel::download(new CourseRegisterExport($CourseEventScheduleId), 'Data Pendaftar Kursus Batch-' . $courseEventSchedule->course_events_id . '-' . $courseEventSchedule->courseType->name . ' hari ' . $courseEventSchedule->day_name . '(' . $timeStart . '-' . $timeEnd . ').xlsx');
    }
}
