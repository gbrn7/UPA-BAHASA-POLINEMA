@extends('admin.layouts.base')

@section('content')
<div class="title-box  d-flex gap-2 align-items-baseline"><i class="ri-calendar-event-line fs-2"></i>
  <p class="fs-3 m-0">Detail Data</p>
</div>
<div class="breadcrumbs-box mt-2 rounded rounded-2 bg-white p-2">
  <nav
    style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);"
    aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item d-flex gap-2 align-items-center"><i class="ri-apps-line"></i>UPA Bahasa</li>
      <li class="breadcrumb-item"><a href={{route('admin.data.event')}} class="text-decoration-none">Data Event</a></li>
      <li class="breadcrumb-item"><a href={{route('admin.data.detail.registers', $event_id)}}
          class="text-decoration-none">Detail
          Pendaftar</a></li>
      <li class="breadcrumb-item active" aria-current="page">Detail Data</li>
    </ol>
  </nav>
</div>
<div class="content-box mt-3 rounded rounded-2 bg-white">
  <div class="content rounded rounded-2 border border-1 p-3">
    <div class="btn-wrapper mt-2">
    </div>
    <div class="mb-3">
      <p class="form-label">Nama Lengkap : </p>
      <p class="fw-semibold">{{$register->name}}</p>
    </div>
    <div class="mb-3">
      <p class="form-label">NIM : </p>
      <p class="fw-semibold">{{$register->nim}}</p>
    </div>
    <div class="mb-3">
      <p class="form-label">NIK : </p>
      <p class="fw-semibold">{{$register->nik}}</p>
    </div>
    <div class="mb-3">
      <p class="form-label">Jurusan : </p>
      <p class="fw-semibold">{{$register->departement}}</p>
    </div>
    <div class="mb-3">
      <p class="form-label">Program Studi : </p>
      <p class="fw-semibold">{{$register->program_study}}</p>
    </div>
    <div class="mb-3">
      <p class="form-label">Semester : </p>
      <p class="fw-semibold">{{$register->semester}}</p>
    </div>
    <div class="mb-3">
      <p class="form-label">Email : </p>
      <p class="fw-semibold">{{$register->email}}</p>
    </div>
    <div class="mb-3">
      <p class="form-label">No. Wa : </p>
      <p class="fw-semibold">{{$register->phone_num}}</p>
    </div>
    <div class="mb-3">
      <p class="form-label">Foto KTP : </p>
      <a href="{{route('admin.data.registers.downloadKTP', $register->ktp_img)}}">
        <p class="fw-semibold">{{$register->ktp_img}}</p>
      </a>
      <div class="img-wrapper col-lg-6 col-10">
        <img src="{{ asset('storage/ktp/'.$register->ktp_img) }}" alt="ktp" class="img-fluid w-100 register-data-img">

      </div>
    </div>
    <div class="mb-3">
      <p class="form-label">Foto KTM : </p>
      <a href="{{route('admin.data.registers.downloadKTM', $register->ktm_img)}}">
        <p class="fw-semibold">{{$register->ktm_img}}</p>
      </a>
      <div class="img-wrapper col-lg-6 col-10">
        <img src="{{ asset('storage/ktp/'.$register->ktp_img) }}" alt="ktp" class="img-fluid w-100 register-data-img">

      </div>
    </div>
    <div class="mb-3">
      <p class="form-label">Surat Pernyataan Nominasi IISMA : </p>
      <a class="text-decoration-none"
        href="{{route('admin.data.registers.downloadSuratPernyataan', [$register->surat_pernyataan_iisma, 0])}}">
        <p class="fw-semibold btn btn-danger">Download PDF</p>
      </a>
      <a class="text-decoration-none" target="blank"
        href="{{route('admin.data.registers.downloadSuratPernyataan', [$register->surat_pernyataan_iisma, 1])}}">
        <p class="fw-semibold btn btn-success ms-2">View PDF</p>
      </a>

    </div>
    <div class="mb-5">
      <p class="form-label">Pas Foto : </p>
      <a href="{{route('admin.data.registers.downloadPasFoto', $register->pasFoto_img)}}">
        <p class="fw-semibold">{{$register->pasFoto_img}}</p>
      </a>
      <div class="img-wrapper col-lg-6 col-10">
        <img src="{{ asset('storage/pasFoto/'.$register->pasFoto_img) }}" alt="ktp"
          class="img-fluid w-100 register-data-img">
      </div>
    </div>
  </div>
</div>
</div>



@endsection