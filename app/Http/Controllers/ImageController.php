<?php

namespace App\Http\Controllers;

use App\Models\ImageModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ImageController extends Controller
{
    public function index()
    {
        return view('admin.data-images.index');
    }

    public function galleryManagement()
    {
        $images = ImageModel::where('type', 'like', '%gallery%')->get();

        return view('admin.data-images.gallery-managements.index', ['images' => $images]);
    }

    public function storeImage(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'image' => 'required|mimes:png,jpg,jpeg|max:2000'
            ],
            [
                'image.required' => 'Masukkan gambar gallery',
                'image.max' => 'Ukuran maksimal gambar adalah :max',
                'mimes' => 'Extension file gambar harus bertipe :values',
            ]
        );

        if ($validator->fails()) {
            return back()
                ->with('toast_error', $validator->messages()->all());
        }

        if (!$request->type) {
            return back()
                ->with('toast_error', 'Image Type params is required');
        }

        try {
            $image = $request->file('image');
            $imageName = Str::random(5) . $image->getClientOriginalName();
            $image->storeAs('public/images', $imageName);


            ImageModel::create([
                'file_name' => $imageName,
                'type' => $request->type,
                'created_by' => auth()->user()->user_id,
            ]);

            return redirect()->back()->with('toast_success', 'Berhasil menambahkan gambar galeri');
        } catch (\Throwable $th) {
            return redirect()->back()->with('toast_error', $th->getMessage());
        }
    }

    public function updateImage(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'image' => 'nullable|mimes:png,jpg,jpeg|max:2000',
                'imageId' => 'required'
            ],
            [
                'imageId.required' => 'Image id is required',
                'image.max' => 'Ukuran maksimal gambar adalah :max',
                'mimes' => 'Extension file gambar harus bertipe :values',
            ]
        );

        if ($validator->fails()) {
            return back()
                ->with('toast_error', $validator->messages()->all());
        }

        $oldData = ImageModel::find($request->imageId);
        if (!$oldData) {
            return back()
                ->with('toast_error', 'Gambar tidak ditemukan');
        }

        try {
            if ($request->file('image')) {
                $image = $request->file('image');
                $imageName = Str::random(5) . $image->getClientOriginalName();
                $image->storeAs('public/images', $imageName);

                $oldData->update([
                    'file_name' => $imageName,
                    'updated_by' => auth()->user()->user_id,
                ]);
            }

            return redirect()->back()->with('toast_success', 'Berhasil memperbarui gambar galeri');
        } catch (\Throwable $th) {
            return redirect()->back()->with('toast_error', $th->getMessage());
        }
    }

    public function deleteImage(Request $request)
    {
        $validation = [
            'imageId' => 'required',
        ];

        $messages = [
            'imageId.required' => 'Wajib mengikutsertakan id',
        ];

        $validator = Validator::make($request->all(), $validation, $messages);

        if ($validator->fails()) {
            return back()
                ->with('toast_error', $validator->messages()->all());
        }

        try {
            $image = ImageModel::find($request->imageId);

            $image->delete([
                'deleted_by' => auth()->user()->user_id
            ]);

            return back()->with('toast_success', 'Berhasil menghapus gambar');
        } catch (\Throwable $th) {
            return back()->with('toast_warning', $th->getMessage());
        }
    }

    public function StructureOrganizationManagement()
    {
        $image = ImageModel::where('type', 'like', '%structure_organization%')->first();

        return view('admin.data-images.structure-organizations-managements.index', ['image' => $image]);
    }

    public function sopToiecManagement()
    {
        $image = ImageModel::where('type', 'like', '%sop-toeic%')->first();

        return view('admin.data-images.sop-toeic-management.index', ['image' => $image]);
    }

    public function sopConsultManagement()
    {
        $image = ImageModel::where('type', 'like', '%sop-consult%')->first();

        return view('admin.data-images.sop-consult-management.index', ['image' => $image]);
    }
}
