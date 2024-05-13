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
    
            if($dateNow->greaterThan($registerEnd))
            {    
            $activeEvent->update(['status' => false]);
            }
        }
        return view('admin.data-course.index', ['courses' => $courses]);
    }

    public function store(Request $request)
    {
        $activeEvent = CourseEventModel::where('status', true)->first();

        if($activeEvent) return redirect()->route('data-course.index')->with('toast_warning', 'Terdapat batch yang masih aktif, pastikan tidak ada batch yang aktif');

        $request->validate([
            'registration_range' => 'required',
            'status' => 'required',
        ]);

        $registerStart = Carbon::parse(explode(' - ',$request->registration_range)[0])->startOfDay();
        $registerEnd = Carbon::parse(explode(' - ',$request->registration_range)[1])->endOfDay();

        $newEvent = CourseEventModel::create([
            'register_start' => $registerStart,
            'register_end' => $registerEnd,
            'status' => $request->status,
            'created_by' => auth()->user()->user_id,
            'updated_by' => auth()->user()->user_id
        ]);

        return redirect()->route('data-course.index')->with('toast_success', 'Batch kursus berhasil ditambahkan');
    }  

    public function update(Request $request)
    {
        $request->validate([
            'edit_id' => 'required',
            'registration_range' => 'required',
            'status' => 'required|boolean',
        ]);

        $oldEvent = CourseEventModel::find($request->edit_id);

        $registerStart = Carbon::parse(explode(' - ',$request->registration_range)[0])->startOfDay();
        $registerEnd = Carbon::parse(explode(' - ',$request->registration_range)[1])->endOfDay();

        $oldEvent->update([
            'register_start' => $registerStart,
            'register_end' => $registerEnd,
            'status' => $request->status,
            'created_by' => auth()->user()->user_id,
            'updated_by' => auth()->user()->user_id
        ]);

        return redirect()->route('data-course.index')->with('toast_success', 'Batch Berhasil Diedit');
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

        return redirect()->route('data-course.index')->with('toast_success', 'Event Berhasil Dihapus');

    }
}
