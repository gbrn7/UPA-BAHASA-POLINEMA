@extends('admin.layouts.base')

@section('content')
<div class="title-box  d-flex gap-2 align-items-baseline"><i class="ri-news-line fs-2"></i>
  <p class="fs-3 m-0">Edit Berita</p>
</div>
<div class="breadcrumbs-box mt-2 rounded rounded-2 bg-white p-2">
  <nav
    style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);"
    aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item d-flex gap-2 align-items-center"><i class="ri-apps-line"></i>UPA Bahasa</li>
      <li class="breadcrumb-item"><a href={{route('data-news.index')}} class="text-decoration-none">Data Berita</a></li>
      <li class="breadcrumb-item active" aria-current="page">Edit Berita</li>
    </ol>
  </nav>
</div>
<div class="content-box mt-3 rounded rounded-2 bg-white">
  <div class="content rounded rounded-2 border border-1 p-3">
    <div class="btn-wrapper mt-2">
      {{-- Error Alert --}}
      @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
          <li>{{$error}}</li>
          @endforeach
        </ul>
      </div>
      @endif
    </div>

    <form action={{route('data-news.update', $news->news_id)}} class="form" method="POST" enctype="multipart/form-data">
      @method('PUT')
      @csrf
      <div class="mb-3">
        <label class="form-label">Judul</label>
        <input type="text" name="title" value="{{old('title', $news->title)}}" class="form-control"
          placeholder="Masukkan judul" />
      </div>
      <div class="mb-3">
        <label class="form-label">Thumbnail</label>
        <input class="form-control" type="file" name="thumbnail" placeholder="Masukkan gambar thumbnail baru" />
      </div>
      <div class="mb-3">
        <label class="form-label">Konten</label>
        <x-trix-input id="content" name="content" :value="old('content', $news->content?->toTrixHtml())"
          autocomplete="off" />
      </div>
      <div class=" mb-3">
        <button type="submit" class="btn btn-success submit-btn fw-medium">
          Simpan
        </button>
      </div>
    </form>
  </div>
</div>

<script>
</script>


@endsection