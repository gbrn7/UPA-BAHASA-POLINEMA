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
  @empty($register)
  <div class="alert alert-danger alert-dismissible">
    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
    Data yang Anda cari tidak ditemukan.
  </div>
  @else
  <table class="table table-bordered table-striped table-hover table-sm">
    <tr>
      <th>Nama Lengkap</th>
      <td>{{ $register->name }}</td>
    </tr>
    <tr>
      <th>Nim</th>
      <td>{{ $register->nim }}</td>
    </tr>
    <tr>
      <th>NIK</th>
      <td>{{ $register->nik }}</td>
    </tr>
    <tr>
      <th>Jurusan</th>
      <td>{{ $register->departement }}</td>
    </tr>
    <tr>
      <th>Program Studi</th>
      <td>{{ $register->program_study }}</td>
    </tr>
    <tr>
      <th>Semester</th>
      <td>{{ $register->semester }}</td>
    </tr>
    <tr>
      <th>Email</th>
      <td>{{ $register->email }}</td>
    </tr>
    <tr>
      <th>No. Wa :</th>
      <td>{{ $register->phone_num }}</td>
    </tr>
    <tr>
      <th>Tanggal Daftar :</th>
      <td>{{ $register->created_at->format('Y-m-d') }}</td>
    </tr>
    <tr>
      <th>Foto KTP :</th>
      <td>
        <a href="{{route('admin.data.registers.downloadKTP', $register->ktp_img)}}">
          <p class="">{{$register->ktp_img}}</p>
        </a>
        <div class="img-wrapper">
          <img src="{{ asset('storage/ktp/'.$register->ktp_img) }}" alt="ktp" class="img-fluid register-data-img">
        </div>
      </td>
    </tr>
    <tr>
      <th>Foto KTM :</th>
      <td>
        <a href="{{route('admin.data.registers.downloadKTM', $register->ktm_img)}}">
          <p class="">{{$register->ktm_img}}</p>
        </a>
        <div class="img-wrapper">
          <img src="{{ asset('storage/ktp/'.$register->ktp_img) }}" alt="ktp" class="img-fluid register-data-img">
        </div>
      </td>
    </tr>
    <tr>
      <th>Surat Pernyataan Nominasi IISMA :</th>
      <td>
        <a class="text-decoration-none"
          href="{{route('admin.data.registers.downloadSuratPernyataan', [$register->surat_pernyataan_iisma, 0])}}">
          <p class=" btn btn-danger">Download PDF</p>
        </a>
        <a class="text-decoration-none" target="blank"
          href="{{route('admin.data.registers.downloadSuratPernyataan', [$register->surat_pernyataan_iisma, 1])}}">
          <p class=" btn btn-success ms-2">View PDF</p>
        </a>
      </td>
    </tr>
    <tr>
      <th>Pas Foto :</th>
      <td>
        <a href="{{route('admin.data.registers.downloadPasFoto', $register->pasFoto_img)}}">
          <p class="">{{$register->pasFoto_img}}</p>
        </a>
        <div class="img-wrapper">
          <img src="{{ asset('storage/pasFoto/'.$register->pasFoto_img) }}" alt="ktp"
            class="img-fluid register-data-img">
        </div>
      </td>
    </tr>
  </table>
  @endempty
</div>
</div>



@endsection