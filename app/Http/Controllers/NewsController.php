<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::all();

        return view('admin.data-news.data-news', ['news' => $news]);
    }

    public function create()
    {
        return view('admin.data-news.create-data-news');
    }

    public function store(Request $request)
    {
        $validation = [
            'title' => 'required',
            'thumbnail' => 'required|mimes:png,jpg,jpeg|max:1024',
            'content' => 'required|string',
        ];

        $messages = [
            'required' => ':attribute harus diisi',
            'thumbnail.required' => 'Foto thumbnail harus diisi',
            'string' => 'Kolom :attribute harus bertipe teks atau string',
            'max' => ':attribute maksimal :max kb',
            'thumbnail.mimes' => 'Thumbnail harus bertipe :values',
        ];

        $validator = Validator::make($request->all(), $validation, $messages);

        if ($validator->fails()) {
            return back()
                ->withInput()
                ->withErrors($validator->messages()->all());
        }

        try {
            $thumbnail = $request->thumbnail;
            $imageName = Str::random(12) . '.' . $thumbnail->getClientOriginalExtension();
            $thumbnail->storeAs('public/news_thumbnail', $imageName);

            $newData =                 [
                'title' => $request->title,
                'thumbnail' => $imageName,
                'content' => $request->content,
                'created_by' => auth()->user()->user_id
            ];

            News::create($newData);

            return redirect()
                ->route('data-news.index')
                ->with('toast_success', 'Berhasil Menambahkan Berita');
        } catch (\Throwable $th) {
            return back()->with('toast_error', 'Internal Server Error');
        }
    }

    public function edit(string $ID)
    {
        try {
            $news = News::find($ID);

            if (!$news) return back()->with('toast_error', 'Data Tidak Ditemukan!');

            return view('admin.data-news.edit-news', ['news' => $news]);
        } catch (\Throwable $th) {
            return back()->with('toast_error', 'Internal Server Error');
        }
    }

    public function update(Request $request, string $ID)
    {
        try {
            $validation = [
                'title' => 'nullable',
                'thumbnail' => 'nullable|mimes:png,jpg,jpeg|max:1024',
                'content' => 'nullable|string',
            ];

            $messages = [
                'string' => 'Kolom :attribute harus bertipe teks atau string',
                'max' => ':attribute maksimal :max kb',
                'thumbnail.mimes' => 'Thumbnail harus bertipe :values',
            ];

            $validator = Validator::make($request->all(), $validation, $messages);

            if ($validator->fails()) {
                return back()
                    ->withInput()
                    ->withErrors($validator->messages()->all());
            }

            $newData = [];

            if ($request->title) {
                $newData['title'] = $request->title;
            }

            if ($request->content) {
                $newData['content'] = $request->content;
            }

            $newData['updated_by'] = auth()->user()->user_id;

            if ($request->file('thumbnail')) {
                $thumbnail = $request->file('thumbnail');
                $thumbnailName = Str::random(12) . $thumbnail->getClientOriginalName();
                $thumbnail->storeAs('public/news_thumbnail', $thumbnailName);

                $newData['thumbnail'] = $thumbnailName;
            }

            $news = News::find($ID);

            if (!$news) return back()->with('toast_error', 'Data Tidak Ditemukan!');

            $news->update($newData);

            return redirect()
                ->route('data-news.index')
                ->with('toast_success', 'Berhasil Mengedit Berita');
        } catch (\Throwable $th) {
            return back()->with('toast_error', 'Internal Server Error');
        }
    }

    public function show(string $ID)
    {
        try {
            $news = News::find($ID);

            if (!$news) return back()->with('toast_error', 'Data Tidak Ditemukan!');

            return view('admin.data-news.show-news', ['news' => $news]);
        } catch (\Throwable $th) {
            return back()->with('toast_error', 'Internal Server Error');
        }
    }

    public function destroy(Request $request)
    {
        $validation = [
            'deleteId' => 'required',
        ];

        $messages = [
            'deleteId.required' => 'Wajib mengikutsertakan id',
        ];

        $validator = Validator::make($request->all(), $validation, $messages);

        if ($validator->fails()) {
            return back()
                ->with('toast_error', $validator->messages()->all());
        }

        try {
            $news = News::find($request->deleteId);

            if (!$news) return back()->with('toast_error', 'Data Tidak Ditemukan!');

            $news->delete(['deleted_by' => auth()->user()->user_id]);

            return redirect()
                ->route('data-news.index')
                ->with('toast_success', 'Berita Berhasil Dihapus');
        } catch (\Throwable $th) {
            return back()->with('toast_error', 'Internal Server Error');
        }
    }
}
