<?php

namespace App\Http\Controllers;

use App\Models\CourseEventModel;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CourseEventsController extends Controller
{
    public function index()
    {
        $courses = CourseEventModel::all();
        $activeEvent = $courses->where('status', true)->first();

        if (isset($activeEvent)) {
            $dateNow = Carbon::now();
            $registerEnd = Carbon::parse($activeEvent->register_end);

            if ($dateNow->greaterThan($registerEnd)) {
                $activeEvent->update(['status' => false]);
            }
        }
        return view('admin.data-course.index', ['courses' => $courses]);
    }

    public function store(Request $request)
    {
        $activeEvent = CourseEventModel::where('status', true)->first();

        if ($activeEvent) return redirect()->route('admin.data-course.index')->with('toast_warning', 'Terdapat batch yang masih aktif, pastikan tidak ada batch yang aktif');

        $request->validate([
            'registration_range' => 'required',
            'status' => 'required',
            'execution' => 'required',
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


        $newEvent = CourseEventModel::create([
            'register_start' => $registerStart,
            'register_end' => $registerEnd,
            'execution' => $request->execution,
            'status' => $request->status,
            'created_by' => auth()->user()->user_id,
            'updated_by' => auth()->user()->user_id
        ]);

        return redirect()->route('admin.data-course.index')->with('toast_success', 'Batch kursus berhasil ditambahkan');
    }

    public function update(Request $request)
    {
        $request->validate([
            'edit_id' => 'required',
            'registration_range' => 'required',
            'execution' => 'required',
            'status' => 'required|boolean',
        ]);

        if ($request->status == true) {
            $activeEvent = CourseEventModel::where('status', true)->where('course_events_id', '<>', $request->edit_id)->first();

            if ($activeEvent) return redirect()->route('admin.data-course.index')->with('toast_warning', 'Terdapat batch yang masih aktif, pastikan tidak ada batch yang aktif');
        }

        $oldEvent = CourseEventModel::find($request->edit_id);

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


        $oldEvent->update([
            'register_start' => $registerStart,
            'register_end' => $registerEnd,
            'status' => $request->status,
            'execution' => $request->execution,
            'created_by' => auth()->user()->user_id,
            'updated_by' => auth()->user()->user_id
        ]);

        return redirect()->route('admin.data-course.index')->with('toast_success', 'Batch Berhasil Diedit');
    }

    public function delete(Request $request)
    {
        $request->validate([
            'delete_id' => 'required',
        ]);

        $course = CourseEventModel::find($request->delete_id);

        $course->delete([
            'deleted_by' => auth()->user()->user_id
        ]);

        return redirect()->route('admin.data-course.index')->with('toast_success', 'Event Berhasil Dihapus');
    }

    public function edit(Request $request)
    {
    }
}
