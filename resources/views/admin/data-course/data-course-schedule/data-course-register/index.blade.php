@extends('admin.layouts.base')

@section('content')
<div class="title-box  d-flex gap-2 align-items-baseline"><i class="ri-graduation-cap-line fs-2"></i>
  <p class="fs-3 m-0">Data Pendaftar Kursus <span class="fs-5 fw-light">({{$courseEventSchedule->courseType->name}} |
      {{$courseEventSchedule->day_name}} |
      {{date("H:i", strtotime($courseEventSchedule->time_start))}} - {{date("H:i",
      strtotime($courseEventSchedule->time_end))}})</span>
  </p>
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
          Kursus Batch {{$courseEventSchedule->course_events_id}}</a></li>
      <li class="breadcrumb-item active">Data Pendaftar Kursus Jadwal ({{$courseEventSchedule->courseType->name}} |
        {{$courseEventSchedule->day_name}} |
        {{date("H:i", strtotime($courseEventSchedule->time_start))}} - {{date("H:i",
        strtotime($courseEventSchedule->time_end))}})</li>
    </ol>
  </nav>
</div>
<div class="content-box mt-3 rounded rounded-2 bg-white">
  <div class="content rounded rounded-2 border border-1 p-3">
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
    <div class="btn-wrapper mt-2">
      <a class="text-decoration-none"
        href="{{route('admin.data-course.data-schedule.data-registers.create', [$courseEventSchedule->course_events_id, $courseEventSchedule->course_event_schedule_id])}}">
        <div id="add" class="btn btn-success"><i class="ri-add-box-line me-2"></i>Tambah Pendaftar</div>
      </a>
      <a class="text-decoration-none" href={{route('admin.data.detail.registers.exportCourseRegister',
        $courseEventSchedule->course_event_schedule_id)}}>
        <div id="add" class="btn btn-success"><i class="ri-file-excel-2-line me-2"></i>Export Excel</div>
      </a>
    </div>
    <div class="table-wrapper mt-2 mb-2">
      <table id="example" class="table mt-3 table-hover table-borderless" style="width: 100%">
        <thead>
          <tr>
            <th class="text-secondary">No</th>
            <th class="text-secondary">Nama</th>
            <th class="text-secondary">Email</th>
            <th class="text-secondary">Alamat</th>
            <th class="text-secondary">No. HP</th>
            <th class="text-secondary">Aksi</th>
          </tr>
        </thead>
        <tbody id="tableBody">
          @foreach ($courseEventSchedule->courseEventsRegisters as $register)
          <tr>
            <td>{{$loop->iteration }}</td>
            <td>{{$register->name}}</td>
            <td>{{$register->email}}</td>
            <td>{{$register->address}}</td>
            <td>{{$register->phone_num}}</td>
            <td class="">
              <div class="btn-wrapper d-flex gap-2 flex-wrap">
                <a href={{route('admin.data-course.data-schedule.data-registers.edit',
                  [$courseEventSchedule->course_events_id, $courseEventSchedule->course_event_schedule_id,
                  $register->course_event_registrations_id])}} data-bs-toggle="tooltip"
                  data-bs-custom-class="custom-tooltip" data-bs-title="Edit Data"
                  class="btn edit btn-action
                  btn-warning
                  text-white"><i class="ri-edit-2-line"></i></a>
                <div class="delete cursor-pointer btn btn-action btn-danger
                  text-white" data-bs-toggle="tooltip" data-bs-custom-class="custom-tooltip" data-bs-title="Hapus Data"
                  data-id="{{$register->course_event_registrations_id}}" data-register-name="{{$register->name}}">
                  <i class="ri-delete-bin-line"></i>
                </div>
                <a href={{route('admin.data-course.data-schedule.data-registers.show',
                  [$courseEventSchedule->course_events_id, $courseEventSchedule->course_event_schedule_id,
                  $register->course_event_registrations_id])}} data-bs-toggle="tooltip"
                  data-bs-custom-class="custom-tooltip" data-bs-title="Detail Data Register" class="btn detail
                  btn-action
                  btn-primary
                  text-white"><i class="ri-list-check"></i></a>
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deletemodal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog ">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myModalLabel">Hapus Event</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h4 class="text-center">Apakah anda yakin mengapus data pendaftaran <span id="register-name"></span> ini?</h4>
      </div>
      <form action={{route('admin.data-course.data-schedule.data-registers.delete') }} method="post">
        @method('delete')
        @csrf
        <input type="hidden" name="course_event_schedule_id" value="{{$courseEventSchedule->course_event_schedule_id}}">
        <input type="hidden" name="course_event_registrations_id" id="course_event_registrations_id">
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" id="deletecriteria" class="btn btn-danger">Hapus</button>
      </form>
    </div>
  </div>
</div>
</div>

@push('js')
<script type="text/javascript">
  $(document).ready(function(){
      $(document).on('click', '.delete', function(event){
          event.preventDefault();
          var id = $(this).data('id');
          var name = $(this).data('register-name');
          $('#deletemodal').modal('show');
          $('#course_event_registrations_id').val(id);
          $('#register-name').html(name);
      });  

  });    
</script>
@endpush

@endsection