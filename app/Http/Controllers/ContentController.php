<?php

namespace App\Http\Controllers;

use App\Models\ContentModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ContentController extends Controller
{
    public function index()
    {
        return view('admin.data-content.index');
    }

    public function contentProfile()
    {
        $content = ContentModel::where('type', 'profile')->first();

        return view('admin.data-content.data-profil-content.index', [
            'content' => $content
        ]);
    }

    public function contentProgram()
    {
        $contents = ContentModel::where('type', 'program')->get();

        return view('admin.data-content.data-program-content.index', [
            'contents' => $contents
        ]);
    }

    public function storeContent(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'type' => 'required|in:profile,program',
                'title_indo' => 'required',
                'title_english' => 'required',
                'text_indo' => 'required',
                'text_english' => 'required',
                'image_name' => 'required|mimes:png,jpg,jpeg|max:2000',
            ]
        );

        if ($validator->fails()) {
            return back()
                ->with('toast_error', $validator->messages()->all());
        }

        $newData = $request->all();
        $newData['created_by'] = auth()->user()->user_id;
        try {

            if ($request->image_name) {
                $image = $request->file('image_name');
                $imageName = Str::random(5) . $image->getClientOriginalName();
                $image->move('assets/images/', $imageName);
                $newData['image_name'] = $imageName;
            }

            ContentModel::create($newData);

            return redirect()->back()->with('toast_success', 'Berhasil menambahkan data konten');
        } catch (\Throwable $th) {
            return redirect()->back()->with('toast_error', $th->getMessage());
        }
    }

    public function updateContent(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'type' => 'required|in:profile,program',
                'title_indo' => 'required',
                'title_english' => 'required',
                'text_indo' => 'required',
                'text_english' => 'required',
                'image_name' => 'nullable|mimes:png,jpg,jpeg|max:2000',
                'contentId' => 'required',
            ]
        );

        if ($validator->fails()) {
            return back()
                ->with('toast_error', $validator->messages()->all());
        }

        $oldData = ContentModel::find($request->contentId);
        if (!$oldData) {
            return back()
                ->with('toast_error', 'Konten tidak ditemukan');
        }

        $newData = $request->except('contentId');
        $newData['updated_by'] = auth()->user()->user_id;

        try {
            if ($request->image_name) {
                $image = $request->file('image_name');
                $imageName = Str::random(5) . $image->getClientOriginalName();
                $image->move('assets/images/', $imageName);
                $newData['image_name'] = $imageName;
            }

            $oldData->update($newData);

            return redirect()->back()->with('toast_success', 'Berhasil memperbarui data konten');
        } catch (\Throwable $th) {
            return redirect()->back()->with('toast_error', $th->getMessage());
        }
    }

    public function deleteContent(Request $request)
    {
        $validation = [
            'contentId' => 'required',
        ];

        $messages = [
            'contentId.required' => 'Wajib mengikutsertakan id',
        ];

        $validator = Validator::make($request->all(), $validation, $messages);

        if ($validator->fails()) {
            return back()
                ->with('toast_error', $validator->messages()->all());
        }

        try {
            $content = ContentModel::find($request->contentId);

            $content->delete([
                'deleted_by' => auth()->user()->user_id
            ]);

            return back()->with('toast_success', 'Berhasil menghapus data konten');
        } catch (\Throwable $th) {
            return back()->with('toast_warning', $th->getMessage());
        }
    }
}
