@extends('admin.layouts.base')

@section('content')
<div class="title-box  d-flex gap-2 align-items-baseline"><i class="ri-graduation-cap-line fs-2"></i>
  <p class="fs-3 m-0">Data Jadwal Kursus #{{$course->course_events_id}}</p>
</div>
<div class="breadcrumbs-box mt-2 rounded rounded-2 bg-white p-2">
  <nav
    style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);"
    aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item d-flex gap-2 align-items-center"><i class="ri-apps-line"></i>UPA Bahasa</li>
      <li class="breadcrumb-item" aria-current="page"><a href="{{route('admin.data-course.index')}}"
          class="text-decoration-none">Data Kursus</a></li>
      <li class="breadcrumb-item active" aria-current="page">Data Jadwal Kursus Batch {{$course->course_events_id}}</li>
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
      <a href={{route('admin.data-course.data-schedule.create', $course->course_events_id)}}
        class="text-decoration-none">
        <div id="add" class="btn btn-success"><i class="ri-add-box-line me-2"></i>Tambah Jadwal</div>
      </a>
      <div class="text-decoration-none text-decoration-none d-inline-block" data-bs-toggle="modal"
        data-bs-target="#exportTable" id="exportBtn">
        <div id="add" class="btn btn-success"><i class="ri-file-excel-2-line me-2"></i>Export Excel</div>
      </div>
    </div>
    <div class="table-wrapper mt-2 mb-2">
      <table id="example" class="table mt-3 table-hover table-borderless" style="width: 100%">
        <thead>
          <tr>
            <th class="text-secondary">No.</th>
            <th class="text-secondary">Tipe Kursus</th>
            <th class="text-secondary">Kuota</th>
            <th class="text-secondary">Jumlah Pendaftar</th>
            <th class="text-secondary">Sisa Kuota</th>
            <th class="text-secondary">Hari</th>
            <th class="text-secondary">Waktu</th>
            <th class="text-secondary">Status</th>
            <th class="text-secondary">Aksi</th>
          </tr>
        </thead>
        <tbody id="tableBody">
          @foreach ($course->courseEventSchedules as $schedule)
          <tr>
            <td>{{$loop->iteration }}</td>
            <td>{{$schedule->courseType->name }}</td>
            <td>{{$schedule->quota }}</td>
            <td>{{(($schedule->quota) - ($schedule->remaining_quota))}}</td>
            <td>{{$schedule->remaining_quota <= 0 ? 0 : $schedule->remaining_quota}}</td>
            <td>{{$schedule->day_name }}</td>
            <td>{{date("H:i", strtotime($schedule->time_start))}} - {{date("H:i", strtotime($schedule->time_end))}}</td>
            <td class="text-capitalize">{{$schedule->status == 1 ? 'Aktif' : 'Non-Aktif'}}</td>
            <td class="">
              <div class="btn-wrapper d-flex gap-2 flex-wrap">
                <a href="{{route('admin.data-course.data-schedule.edit', [$schedule->course_events_id, $schedule->course_event_schedule_id])}}"
                  data-bs-toggle="tooltip" data-bs-custom-class="custom-tooltip" data-bs-title="Edit Event" class="btn edit btn-action
                  btn-warning
                  text-white"><i class="ri-edit-2-line"></i></a>
                <div class="delete cursor-pointer btn btn-action btn-danger
                  text-white" data-bs-toggle="tooltip" data-bs-custom-class="custom-tooltip"
                  data-bs-title="Hapus Event" data-course-type="{{$schedule->courseType->name}}"
                  data-time-start="{{date(" H:i", strtotime($schedule->time_start))}}"
                  data-time-end="{{date("H:i", strtotime($schedule->time_end))}}"
                  data-day-name="{{$schedule->day_name}}" data-id="{{$schedule->course_event_schedule_id}}">
                  <i class="ri-delete-bin-line"></i>
                </div>
                <a href={{route('admin.data-course.data-schedule.data-registers.index', [$schedule->course_events_id,
                  $schedule->course_event_schedule_id])}} data-bs-toggle="tooltip"
                  data-bs-custom-class="custom-tooltip" data-bs-title="Data Pendaftar" class="btn detail btn-action
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
        <h5 class="modal-title" id="myModalLabel">Hapus Jadwal</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h4 class="text-center">Apakah anda yakin mengapus jadwal kursus <span id="courseType"></span> <span
            id="dayName"></span> jam <span id="time"></span> ?</h4>
      </div>
      <form action="{{route('admin.data-course.data-schedule.delete')}}" method="post">
        @method('delete')
        @csrf
        <input type="hidden" name="deleteId" id="deleteId">
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" id="deletecriteria" class="btn btn-danger">Hapus</button>
      </form>
    </div>
  </div>
</div>
</div>

{{-- Export Modal --}}
<div class="modal fade" id="exportTable" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog ">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myModalLabel">Export Table</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mt-2 mb-2">
          <table id="example" class="table mt-3 table-hover table-borderless" style="width: 100%">
            <thead>
              <tr>
                <th class="text-secondary">Tipe Kursus</th>
                <th class="text-secondary">Aksi</th>
              </tr>
            </thead>
            <tbody id="tableBody">
              @foreach ($courseEventsDistinct as $item)
              <tr>
                <td>{{$item->courseType->name}}</td>
                <td class="">
                  <a class="btn btn-success text-decoration-none"
                    href={{route('admin.data.detail.registers.exportCourseRegisterBySchedule', [
                    $item->course_events_id, $item->course_type_id, 'courseName' =>
                    $item->courseType->name])}}>Export</a>
                </td>
              </tr>
              @endforeach
              <tr>
                <td>Semua Tipe Kursus</td>
                <td class="">
                  <a class="btn btn-success text-decoration-none"
                    href="{{route('admin.data.detail.registers.exportCourseRegisterAllByEventId', $course->course_events_id)}}">Export</a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
      </div>
    </div>
  </div>
</div>

@push('js')
<script type="text/javascript">
  $(document).ready(function(){
      $(document).on('click', '.delete', function(event){
          event.preventDefault();
          let id = $(this).data('id');
          let courseType = $(this).data('course-type');
          let dayName = $(this).data('day-name');
          let timeStart = $(this).data('time-start');
          let timeEnd = $(this).data('time-end');

          $('#courseType').html(courseType);
          $('#dayName').html(dayName);
          $('#time').html(`${timeStart} - ${timeEnd}`);

          $('#deletemodal').modal('show');
          $('#deleteId').val(id);
      });  

  }); 
</script>
@endpush

@endsection