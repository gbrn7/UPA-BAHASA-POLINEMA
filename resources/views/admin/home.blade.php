@extends('admin.layouts.base')

@section('content')
<div class="title-box  d-flex gap-2 align-items-baseline"><i class="ri-dashboard-line fs-2"></i>
  <p class="fs-3 m-0">Home</p>
</div>
<div class="breadcrumbs-box rounded rounded-2 bg-white p-2 mt-2">
  <nav
    style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);"
    aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item d-flex gap-2 align-items-center"><i class="ri-apps-line"></i>UPA Bahasa</li>
      <li class="breadcrumb-item active" aria-current="page">Home</li>
    </ol>
  </nav>
</div>
<div class="content-box mt-3 rounded rounded-2 bg-white">
  <div class="content rounded rounded-2 border border-1 p-3">
    <div class="row mt-1 row-gap-2 row-cols-1 row-cols-md-2">
      <a href={{route('admin.data.event')}} class="card-dashboard text-decoration-none">
        <div class="card h-100">
          <div class="card-body  row justify-content-between align-items-center">
            <div class="card-body-content col-9">
              <h3 class="card-title">Data Event TOEIC</h3>
              <p class="card-text text-secondary fw-normal">Fitur ini digunakan untuk mengolah data event seperti
                menambah, memperbarui, atau menghapus data event TOIEC.</p>
            </div>
            <div class="col-2 col-sm-3 d-flex justify-content-center img-menu">
              <i class="fs-1 ri-calendar-event-line "></i>
            </div>
          </div>
        </div>
      </a>
      <a href={{route('admin.data.departements')}} class="card-dashboard text-decoration-none">
        <div class="card h-100">
          <div class="card-body  row justify-content-between align-items-center">
            <div class="card-body-content col-9">
              <h3 class="card-title">Data Jurusan</h3>
              <p class="card-text text-secondary fw-normal">Fitur ini digunakan untuk mengolah data jurusan seperti
                menambah, memperbarui, atau menghapus data jurusan</p>
            </div>
            <div class="col-2 col-sm-3 d-flex justify-content-center img-menu">
              <i class="fs-1 ri-building-2-line "></i>
            </div>
          </div>
        </div>
      </a>
      <a href={{route('admin.data.image')}} class="card-dashboard text-decoration-none">
        <div class="card h-100">
          <div class="card-body  row justify-content-between align-items-center">
            <div class="card-body-content col-9">
              <h3 class="card-title">Data Gambar</h3>
              <p class="card-text text-secondary fw-normal">Fitur ini digunakan untuk mengolah data gambar seperti
                menambah, memperbarui, atau menghapus data gambar</p>
            </div>
            <div class="col-2 col-sm-3 d-flex justify-content-center img-menu">
              <i class="fs-1 ri-image-fill"></i>
            </div>
          </div>
        </div>
      </a>
      <a href={{route('admin.data.content')}} class="card-dashboard text-decoration-none">
        <div class="card h-100">
          <div class="card-body row justify-content-between align-items-center">
            <div class="card-body-content col-9">
              <h3 class="card-title">Data Konten</h3>
              <p class="card-text text-secondary fw-normal">Fitur ini digunakan untuk mengolah data konten seperti
                menambah, memperbarui, atau menghapus data gambar</p>
            </div>
            <div class="col-2 col-sm-3 d-flex justify-content-center img-menu">
              <i class="fs-1 ri-pages-line"></i>
            </div>
          </div>
        </div>
      </a>
      <a href="{{route('admin.data-course.index')}}" class="card-dashboard text-decoration-none">
        <div class="card h-100">
          <div class="card-body  row justify-content-between align-items-center">
            <div class="card-body-content col-9">
              <h3 class="card-title">Data Kursus</h3>
              <p class="card-text text-secondary fw-normal">Fitur ini digunakan untuk mengolah data kursus seperti
                menambah, memperbarui, atau menghapus data kursus</p>
            </div>
            <div class="col-2 col-sm-3 d-flex justify-content-center img-menu">
              <i class="ri-graduation-cap-line"></i>
            </div>
          </div>
        </div>
      </a>
      <a href={{route('admin.data.courseType')}} class="card-dashboard text-decoration-none">
        <div class="card h-100">
          <div class="card-body  row justify-content-between align-items-center">
            <div class="card-body-content col-9">
              <h3 class="card-title">Data Tipe Kursus</h3>
              <p class="card-text text-secondary fw-normal">Fitur ini digunakan untuk mengolah data tipe kursus seperti
                menambah, memperbarui, atau menghapus data tipe kursus</p>
            </div>
            <div class="col-2 col-sm-3 d-flex justify-content-center img-menu">
              <i class="ri-earth-line"></i>
            </div>
          </div>
        </div>
      </a>
      <a href={{route('data-news.index')}} class="card-dashboard text-decoration-none">
        <div class="card h-100">
          <div class="card-body row justify-content-between align-items-center">
            <div class="card-body-content col-9">
              <h3 class="card-title">Data Berita</h3>
              <p class="card-text text-secondary fw-normal">Fitur ini digunakan untuk mengolah data berita seperti
                menambah, memperbarui, atau menghapus data berita
              </p>
            </div>
            <div class="col-2 col-sm-3 d-flex justify-content-center img-menu">
              <i class="ri-news-line"></i>
            </div>
          </div>
        </div>
      </a>
      <a href={{route('admin.edit.email.notif.setting')}} class="card-dashboard text-decoration-none">
        <div class="card h-100">
          <div class="card-body row justify-content-between align-items-center">
            <div class="card-body-content col-9">
              <h3 class="card-title">Email Notif</h3>
              <p class="card-text text-secondary fw-normal">Fitur ini digunakan untuk mengolah data email untuk
                notifikasi
              </p>
            </div>
            <div class="col-2 col-sm-3 d-flex justify-content-center img-menu">
              <i class="ri-mail-line"></i>
            </div>
          </div>
        </div>
      </a>
    </div>
  </div>
</div>
@endsection