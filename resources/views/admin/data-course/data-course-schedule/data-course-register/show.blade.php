@extends('admin.layouts.base')

@section('content')
<div class="title-box  d-flex gap-2 align-items-baseline"><i class="ri-graduation-cap-line fs-2"></i>
  <p class="fs-3 m-0">Detail Pendaftar</p>
</div>
<div class="breadcrumbs-box mt-2 rounded rounded-2 bg-white p-2">
  <nav
    style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);"
    aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item d-flex gap-2 align-items-center"><i class="ri-apps-line"></i>UPA Bahasa</li>
      <li class="breadcrumb-item" aria-current="page"><a href="{{route('admin.data-course.index')}}"
          class="text-decoration-none">Data Kursus</a></li>
      <li class="breadcrumb-item" aria-current="page"><a
          href="{{route('admin.data-course.data-schedule.index', [$courseEventSchedule->course_events_id, $courseEventSchedule->course_event_schedule_id])}}"
          class="text-decoration-none">Data Jadwal
          Kursus Batch #{{$courseEventSchedule->course_events_id}}</a></li>
      <li class="breadcrumb-item"><a href="{{route('admin.data-course.data-schedule.data-registers.index', [$courseEventSchedule->course_events_id,
        $courseEventSchedule->course_event_schedule_id])}}" class="text-decoration-none">Data Pendaftar Kursus Jadwal
          ({{$courseEventSchedule->courseType->name}} | {{$courseEventSchedule->day_name}} |
          {{date("H:i", strtotime($courseEventSchedule->time_start))}} - {{date("H:i",
          strtotime($courseEventSchedule->time_end))}})</a></li>
      <li class="breadcrumb-item active">Detail Pendaftar</li>
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
      <th>Email</th>
      <td>{{ $register->email }}</td>
    </tr>
    <tr>
      <th>No. Wa :</th>
      <td>{{ $register->phone_num }}</td>
    </tr>
    <tr>
      <th>Alamat :</th>
      <td>{{ $register->address }}</td>
    </tr>
    <tr>
      <th>Tujuan :</th>
      <td>{{ $register->goal }}</td>
    </tr>
    <tr>
      <th>Pengalaman :</th>
      <td>{{ $register->experience }}</td>
    </tr>
    <tr>
      <th>Tanggal Daftar :</th>
      <td>{{ $register->created_at->format('Y-m-d') }}</td>
    </tr>
    <tr>
      <th>Foto KTP :</th>
      <td>
        <a target="blank" href="{{url('storage/ktp/'.$register->ktp_or_passport_img)}}">
          <p class="">{{$register->ktp_or_passport_img}}</p>
        </a>
        <div class="img-wrapper">
          <img src="{{ asset('storage/ktp/'.$register->ktp_or_passport_img) }}" alt="ktp"
            class="img-fluid register-data-img">
        </div>
      </td>
    </tr>
  </table>
  @endempty
</div>
</div>
@endsection