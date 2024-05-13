@extends('admin.layouts.base')

@section('content')
<div class="title-box  d-flex gap-2 align-items-baseline"><i class="ri-calendar-event-line fs-2"></i>
  <p class="fs-3 m-0">Tambah Jadwal</p>
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
          href="{{route('admin.data-course.data-schedule.index', $courseEventId)}}" class="text-decoration-none">Data
          Jadwal Kursus Batch {{ $courseEventId}}</a></li>
      <li class="breadcrumb-item active" aria-current="page">Tambah Jadwal</li>
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

    <form action="{{route('admin.data-course.data-schedule.store', $courseEventId)}}" class="form" method="POST">
      @csrf
      <div class="mb-3">
        <label class="form-label">Tipe Kursus</label>
        <select name="course_type_id" required class="form-select">
          <option value="">Pilih Tipe Kursus</option>
          @foreach ($courseTypes as $courseType)
          <option value="{{$courseType->course_type_id}}" {{old('course_type_id')===$courseType->
            course_type_id ? 'selected':''}}>
            {{$courseType->name}}
          </option>
          @endforeach
        </select>
      </div>
      <div class="mb-3">
        <label class="form-label">Kuota</label>
        <input required type="number" min="0" name="quota" value="{{old('quota')}}" class="form-control"
          placeholder="Masukkan kuota pendaftar" />
      </div>
      <div class="mb-3">
        <label class="form-label">Hari</label>
        <select name="day_name" required class="form-select">
          <option value="">Pilih hari</option>
          <option value="Senin" @selected(old('day_name')=="Senin" )>Senin</option>
          <option value="Selasa" @selected(old('day_name')=="Selasa" )>Selasa</option>
          <option value="Rabu" @selected(old('day_name')=="Rabu" )>Rabu</option>
          <option value="Kamis" @selected(old('day_name')=="Rabu" )>Kamis</option>
          <option value="Jumat" @selected(old('day_name')=="Jumat" )>Jumat</option>
          <option value="Sabtu" @selected(old('day_name')=="Sabtu" )>Sabtu</option>
          <option value="Minggu" @selected(old('day_name')=="Minggu" )>Minggu</option>
        </select>
      </div>
      <div class="mb-3">
        <label class="form-label">Jam Mulai</label>
        <input required type="time" placeholder="Pilih jam mulai" name="time_start" value="{{old('time_start')}}"
          class="form-control" placeholder="Masukkan jam mulai" />
      </div>
      <div class="mb-3">
        <label class="form-label">Jam Selesai</label>
        <input required type="time" placeholder="Pilih jam selesai" name="time_end" value="{{old('time_end')}}"
          class="form-control" placeholder="Masukkan jam selesai" />
      </div>
      <div class="mb-3">
        <label class="form-label">Status</label>
        <select required name="status" class="form-select" aria-label="Default select example">
          <option value="1" {{old('status')==='1' ? ' selected' : '' }}>Aktif</option>
          <option value="0" {{old('status')==='0' ? ' selected' : '' }}>Non-Aktif</option>
        </select>
      </div>
      <div class=" mb-3">
        <button type="submit" class="btn btn-success submit-btn fw-medium">
          Simpan
        </button>
      </div>
    </form>
  </div>
</div>
@endsection