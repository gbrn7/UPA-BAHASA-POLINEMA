<?php

namespace App\Http\Controllers;

use App\Exports\CourseRegisterExportByEventId;
use App\Exports\CourseRegisterExportBySchedule;
use App\Models\CourseEventModel;
use App\Models\CourseEventScheduleModel;
use App\Models\CourseTypeModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class CourseEventScheduleController extends Controller
{
    public function index(string $courseEventId)
    {
        if (!$courseEventId) return back()->with('toast_error', 'Id kursus tidak ditemukan');

        $course = CourseEventModel::with('courseEventSchedules.courseType')->find($courseEventId);

        if (!$course) return back()->with('toast_error', 'Kursus tidak ditemukan');

        $courseEventsDistinct = $course->courseEventSchedules->unique('courseType');

        return view('admin.data-course.data-course-schedule.index', ['course' => $course, 'courseEventsDistinct' => $courseEventsDistinct]);
    }

    public function create(string $courseEventId)
    {
        $courseTypes = CourseTypeModel::all();

        return view('admin.data-course.data-course-schedule.create', ['courseTypes' => $courseTypes, 'courseEventId' => $courseEventId]);
    }

    public function edit(string $courseEventId, string $courseEventScheduleId)
    {
        $courseTypes = CourseTypeModel::all();

        $courseScheduleEvent = CourseEventScheduleModel::find($courseEventScheduleId);

        if (!$courseScheduleEvent) return back()->with('toast_error', 'Kursus tidak ditemukan');

        return view('admin.data-course.data-course-schedule.edit', ['courseTypes' => $courseTypes, 'courseScheduleEvent' => $courseScheduleEvent]);
    }

    public function store(Request $request, string $courseEventId)
    {
        $request->validate([
            'course_type_id' => 'required',
            'quota' => 'required|numeric',
            'day_name' => 'required',
            'time_start' => 'required',
            'time_end' => 'required',
            'status' => 'required',
            'information' => 'nullable',
        ]);

        try {
            $newSchedule = CourseEventScheduleModel::create([
                'course_events_id' => $courseEventId,
                'course_type_id' => $request->course_type_id,
                'quota' => $request->quota,
                'remaining_quota' => $request->quota,
                'day_name' => $request->day_name,
                'time_start' => $request->time_start,
                'time_end' => $request->time_end,
                'status' => $request->status,
                'information' => $request->information,
                'created_by' => auth()->user()->user_id,
                'updated_by' => auth()->user()->user_id
            ]);

            return redirect()
                ->route('admin.data-course.data-schedule.index', $newSchedule->course_events_id)
                ->with('toast_success', 'Berhasil Menambahkan Jadwal');
        } catch (\Throwable $th) {
            return back()->with('toast_error', 'Internal Server Error');
        }
    }

    public function update(string $courseEventId, string $courseEventScheduleId, Request $request)
    {
        $request->validate([
            'course_type_id' => 'required',
            'quota' => 'required|numeric',
            'day_name' => 'required',
            'time_start' => 'required',
            'time_end' => 'required',
            'status' => 'required',
            'information' => 'nullable',
        ]);


        try {
            DB::beginTransaction();
            $oldSchedule = CourseEventScheduleModel::where('course_event_schedule_id', $courseEventScheduleId)->withCount('courseEventsRegisters')->lockForUpdate()->first();

            $oldSchedule->update([
                'course_type_id' => $request->course_type_id,
                'quota' => $request->quota,
                'remaining_quota' => ($request->quota - $oldSchedule->course_events_registers_count),
                'time_start' => $request->time_start,
                'time_end' => $request->time_end,
                'status' => $request->status,
                'information' => $request->information,
                'created_by' => auth()->user()->user_id,
                'updated_by' => auth()->user()->user_id
            ]);
            DB::commit();

            return redirect()->route('admin.data-course.data-schedule.index', $oldSchedule->course_events_id)->with('toast_success', 'Data jadwal berhasil di perbarui');
        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()->route('admin.data-course.data-schedule.index', $courseEventId)->with('toast_warning', 'Internal server error');
        }
    }

    public function delete(Request $request)
    {
        $request->validate([
            'deleteId' => 'required',
        ]);

        try {
            $schedule = CourseEventScheduleModel::find($request->deleteId);

            if (!$schedule) return back()->with('toast_error', 'Kursus Tidak Ditemukan');

            $schedule->delete([
                'deleted_by' => auth()->user()->user_id
            ]);

            return back()->with('toast_success', 'Event Berhasil Dihapus');
        } catch (\Throwable $th) {
            return back()->with('toast_error', 'Internal Server Error');
        }
    }

    public function exportCourseRegisterAllByEventId(string $courseEventId)
    {

        return Excel::download(new CourseRegisterExportByEventId($courseEventId), 'Data Pendaftar Kursus Batch-' . $courseEventId . '.xlsx');
    }

    public function exportCourseRegisterBySchedule(string $courseEventsId, string $courseTypeId, Request $request)
    {
        return Excel::download(new CourseRegisterExportBySchedule($courseEventsId, $courseTypeId), 'Data Pendaftar Kursus Batch-' . $courseEventsId . '-' . $request->courseName . '.xlsx');
    }
}
