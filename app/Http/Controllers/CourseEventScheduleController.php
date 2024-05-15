<?php

namespace App\Http\Controllers;

use App\Models\CourseEventModel;
use App\Models\CourseEventScheduleModel;
use App\Models\CourseTypeModel;
use Illuminate\Http\Request;

class CourseEventScheduleController extends Controller
{
    public function index(string $courseEventId)
    {
        if(!$courseEventId) return back()->with('toast_error', 'Id kursus tidak ditemukan');

        $course = CourseEventModel::with('courseEventSchedules.courseType')->find($courseEventId);

        if(!$course) return back()->with('toast_error', 'Kursus tidak ditemukan');

        return view('admin.data-course.data-course-schedule.index', ['course' => $course]);
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

        if(!$courseScheduleEvent) return back()->with('toast_error', 'Kursus tidak ditemukan');

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

    public function update
    (string $courseEventId, string $courseEventScheduleId, Request $request)
    {
        $request->validate([
            'course_type_id' => 'required',
            'quota' => 'required|numeric',
            'day_name' => 'required',
            'time_start' => 'required',
            'time_end' => 'required',
            'status' => 'required',
        ]);


        try {
            $oldSchedule = CourseEventScheduleModel::where('course_event_schedule_id', $courseEventScheduleId)->first();

            $oldSchedule->update([
                'course_type_id' => $request->course_type_id,
                'quota' => $request->quota,
                'remaining_quota' => ($request->quota) - (($oldSchedule->quota) - ($oldSchedule->remaining_quota)),
                'time_start' => $request->time_start,
                'time_end' => $request->time_end,
                'status' => $request->status,
                'created_by' => auth()->user()->user_id,
                'updated_by' => auth()->user()->user_id
            ]);
    
            return redirect()->route('admin.data-course.data-schedule.index', $oldSchedule->course_events_id)->with('toast_success', 'Data jadwal berhasil di perbarui');  

        } catch (\Throwable $th) {
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

        if(!$schedule) return back()->with('toast_error', 'Kursus Tidak Ditemukan');

        $schedule->delete([
            'deleted_by' => auth()->user()->user_id
        ]);

        return back()->with('toast_success', 'Event Berhasil Dihapus');
        } catch (\Throwable $th) {
        return back()->with('toast_error', 'Internal Server Error');
        }
    }

}
