<?php

namespace App\Http\Controllers;

use App\Models\CourseTypeModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CourseTypeController extends Controller
{
    public function index()
    {
        $course = CourseTypeModel::all();

        return view('admin.data-course-type.index', ['courses' => $course]);
    }

    public function storeCourseType(Request $request)
    {

        $validation = [
            'name' => 'required'
        ];

        $messages = [
            'name.required' => 'Masukkan tipe kursus',
        ];

        $validator = Validator::make($request->all(), $validation, $messages);


        if($validator->fails()){
            return back()
            ->with('toast_error', $validator->messages()->all());
        }

        try {
            CourseTypeModel::create([
                'name' => $request->name,
                'created_by' => auth()->user()->user_id ,
                'updated_by' => auth()->user()->user_id ,
            ]);
            return back()->with('toast_success', 'Berhasil menambahkan tipe kursus');
        } catch (\Throwable $th) {
            return back()->with('toast_warning', $th->getMessage());
        }
    }

    public function updateCourseType(Request $request)
    {
        $validation = [
            'name' => 'required',
        ];

        $messages = [
            'name.required' => 'Masukkan tipe kursus',
        ];

        $validator = Validator::make($request->all(), $validation, $messages);


        if($validator->fails()){
            return back()
            ->with('toast_error', $validator->messages()->all());
        }

        try {
            $oldCourseType = CourseTypeModel::find($request->editId);
            $oldCourseType->update([
                'name' => $request->name,
                'updated_by' => auth()->user()->user_id ,
            ]);

            return back()->with('toast_success', 'Berhasil memperbarui tipe kursus');
        } catch (\Throwable $th) {
            return back()->with('toast_warning', $th->getMessage());
        }

    }

    public function deleteCourseType(Request $request)
    {

        $validation = [
            'deleteId' => 'required',
        ];

        $messages = [
            'deleteId.required' => 'Wajib mengikutsertakan id',
        ];

        $validator = Validator::make($request->all(), $validation, $messages);

        if($validator->fails()){
            return back()
            ->with('toast_error', $validator->messages()->all());
        }

        try {
            $courseType = CourseTypeModel::find($request->deleteId);

            $courseType->delete([
                'deleted_by' => auth()->user()->user_id
            ]);

            return back()->with('toast_success', 'Berhasil menghapus tipe kursus');
        } catch (\Throwable $th) {
            return back()->with('toast_warning', $th->getMessage());

        }

    }
}
