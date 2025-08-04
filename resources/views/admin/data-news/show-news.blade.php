@extends('admin.layouts.base')

@section('content')
<div class="title-box  d-flex gap-2 align-items-baseline"><i class="ri-news-line fs-2"></i>
  <p class="fs-3 m-0">Detail Berita</p>
</div>
<div class="breadcrumbs-box mt-2 rounded rounded-2 bg-white p-2">
  <nav
    style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);"
    aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item d-flex gap-2 align-items-center"><i class="ri-apps-line"></i>UPA Bahasa</li>
      <li class="breadcrumb-item"><a href={{route('data-news.index')}} class="text-decoration-none">Data Berita</a></li>
      <li class="breadcrumb-item active" aria-current="page">Detail Berita</li>
    </ol>
  </nav>
</div>

<div class="content-box mt-3 rounded rounded-2 bg-white">
  @empty($news)
  <div class="alert alert-danger alert-dismissible">
    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
    Data yang Anda cari tidak ditemukan.
  </div>
  @else
  <table class="table table-bordered table-striped table-hover table-sm">
    <tr>
      <th>Judul</th>
      <td>{{ $news->title }}</td>
    </tr>
    <tr>
      <th>Thumbnail </th>
      <td>
        <div class="img-wrapper">
          <img src="{{asset('storage/news_thumbnail/'.$news->thumbnail)}}" alt="thumbnail"
            class="img-fluid register-data-img">
        </div>
      </td>
    </tr>
    <tr>
      <th>Konten</th>
      <td> {!! $news->content !!}</td>
    </tr>
  </table>
  @endempty
</div>

<script>
</script>


@endsection