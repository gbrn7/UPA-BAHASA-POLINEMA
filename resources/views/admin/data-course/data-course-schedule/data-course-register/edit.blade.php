@extends('admin.layouts.base')

@section('content')
<div class="title-box  d-flex gap-2 align-items-baseline"><i class="ri-graduation-cap-line fs-2"></i>
  <p class="fs-3 m-0">Edit Pendaftar</p>
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
      <li class="breadcrumb-item active">Edit Pendaftar</li>
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

    <form enctype="multipart/form-data" action={{route('admin.data-course.data-schedule.data-registers.update',
      [$courseEventSchedule->course_events_id, $courseEventSchedule->course_event_schedule_id,
      $register->course_event_registrations_id])}}
      class="form" method="POST">
      @method('put')
      @csrf
      <div class="mb-3">
        <label class="form-label">Nama Lengkap</label>
        <input required type="text" name="name" value="{{$register->name}}" class="form-control"
          placeholder="Masukkan nama pendaftar" />
      </div>
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input required type="email" class="form-control" placeholder="Masukkan email pendaftar" name="email"
          value="{{$register->email}}" />
      </div>
      <div class="mb-3">
        <label class="form-label">No WA</label>
        <input required type="number" class="form-control" placeholder="Masukkan no telepon pendaftar" name="phone_num"
          value="{{$register->phone_num}}" />
      </div>
      <div class="mb-3">
        <label class="form-label">Alamat</label>
        <input required type="text" class="form-control" placeholder="Masukkan alamat pendaftar" name="address"
          value="{{$register->address}}" />
      </div>
      <div class="mb-3">
        <label class="form-label">Tujuan</label>
        <textarea class="form-control" placeholder="Masukkan tujuan pendaftar"
          name="goal">{{$register->goal}}</textarea>
      </div>
      <div class="mb-3">
        <label class="form-label">Pengalaman</label>
        <textarea class="form-control" placeholder="Masukkan pengalaman pendaftar"
          name="experience">{{$register->experience}}</textarea>

      </div>
      <div class="mb-3">
        <label for="formFile" class="form-label">Foto KTP atau Passport </label>
        <input class="form-control" type="file" id="formFile" name="ktp_or_passport_img">
      </div>
      <div class=" mb-5">
        <button type="submit" class="btn btn-warning text-white submit-btn fw-medium">
          Update
        </button>
      </div>
    </form>
  </div>
</div>

<script>
  const form = document.querySelector(".form");
    form.addEventListener('submit', function () {
      document.querySelector("html").style.cursor = "wait";
      document.querySelector(".loading-wrapper").classList.remove('d-none');
    });

      
</script>

@endsection