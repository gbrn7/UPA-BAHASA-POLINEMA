<?php

namespace App\Http\Controllers;

use App\Models\imageModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
        $images = imageModel::where('type', 'like', '%gallery%')->get();

        return view('admin.data-images.gallery-managements.index', ['images' => $images]);
    }

    public function storeImage(Request $request)
    {
        $validator = Validator::make($request->all(), 
        [
            'image' => 'required|mimes:png,jpg,jpeg|max:2000'
        ],
        [
            'image.required' => 'Masukkan gambar gallery',
            'image.max' => 'Ukuran maksimal gambar adalah :max',
            'mimes' => 'Extension file gambar harus bertipe :values',
        ]
        );

        if($validator->fails()){
            return back()
            ->with('toast_error', $validator->messages()->all());
        }

        if(!$request->type)
        {
            return back()
            ->with('toast_error', 'Image Type params is required');
        }

        try {
            $image = $request->file('image');
            $imageName = Str::random(5).$image->getClientOriginalName();
            $image->storeAs('public/gallery', $imageName);
            
            imageModel::create([
                'file_name' => $imageName,
                'type' => $request->type,
                'created_by' => auth()->user()->user_id,
            ]);

        return redirect()->route('admin.data.image.galleryManagement')->with('toast_success', 'Berhasil menambahkan gambar galeri');
        } catch (\Throwable $th) {
        return redirect()->route('admin.data.image.galleryManagement')->with('toast_error', $th->getMessage());  
        }

    }

    public function updateImage(Request $request)
    {
        $validator = Validator::make($request->all(), 
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

        if($validator->fails()){
            return back()
            ->with('toast_error', $validator->messages()->all());
        }

        $oldData = imageModel::find($request->imageId);
        if(!$oldData)
        {
            return back()
            ->with('toast_error', 'Gambar tidak ditemukan');
        }

        try {
            if($request->file('image'))
            {
                $image = $request->file('image');
                $imageName = Str::random(5).$image->getClientOriginalName();
                $image->storeAs('public/gallery', $imageName);

                Storage::delete('public/gallery/'.$oldData->file_name);
                
                $oldData->update([
                    'file_name' => $imageName,
                    'updated_by' => auth()->user()->user_id,
                ]);
            }

        return redirect()->route('admin.data.image.galleryManagement')->with('toast_success', 'Berhasil memperbarui gambar galeri');
        } catch (\Throwable $th) {
        return redirect()->route('admin.data.image.galleryManagement')->with('toast_error', $th->getMessage());  
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

        if($validator->fails()){
            return back()
            ->with('toast_error', $validator->messages()->all());
        }

        try {
            $image = imageModel::find($request->imageId);

            $image->delete([
                'deleted_by' => auth()->user()->user_id
            ]);

            return back()->with('toast_success', 'Berhasil menghapus gambar');
        } catch (\Throwable $th) {
            return back()->with('toast_warning', $th->getMessage());

        }

    }
}
