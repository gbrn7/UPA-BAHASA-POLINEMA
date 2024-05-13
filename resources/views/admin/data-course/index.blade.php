@extends('admin.layouts.base')

@section('content')
<div class="title-box  d-flex gap-2 align-items-baseline"><i class="ri-graduation-cap-line fs-2"></i>
  <p class="fs-3 m-0">Data Kursus</p>
</div>
<div class="breadcrumbs-box mt-2 rounded rounded-2 bg-white p-2">
  <nav
    style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);"
    aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item d-flex gap-2 align-items-center"><i class="ri-apps-line"></i>UPA Bahasa</li>
      <li class="breadcrumb-item active" aria-current="page">Data Kursus</li>
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
      <div data-bs-toggle="modal" data-bs-target="#addnew" id="add" class="btn btn-success"><i
          class="ri-add-box-line me-2"></i>Tambah batch kursus</div>
    </div>
    <div class="table-wrapper mt-2 mb-2">
      <table id="example" class="table mt-3 table-hover table-borderless" style="width: 100%">
        <thead>
          <tr>
            <th class="text-secondary">Batch</th>
            <th class="text-secondary">Awal Pendaftaran</th>
            <th class="text-secondary">Akhir Pendaftaran</th>
            <th class="text-secondary">Status</th>
            <th class="text-secondary">Aksi</th>
          </tr>
        </thead>
        <tbody id="tableBody">
          @foreach ($courses as $course)
          <tr>
            <td>{{$course->course_events_id }}</td>
            <td>{{date("d-m-Y", strtotime($course->register_start)) }}</td>
            <td>{{date("d-m-Y", strtotime($course->register_end)) }}</td>
            <td class="text-capitalize">{{$course->status == 1 ? 'Aktif' : 'Non-Aktif'}}</td>
            <td class="">
              <div class="btn-wrapper d-flex gap-2 flex-wrap">
                <a href=# data-bs-toggle="tooltip" data-bs-custom-class="custom-tooltip" data-bs-title="Edit Batch"
                  class="btn edit btn-action btn-warning text-white"
                  data-register-start="{{ date('d-m-Y', strtotime($course->register_start))}}"
                  data-register-end="{{ date('d-m-Y', strtotime($course->register_end))}}"
                  data-id="{{$course->course_events_id}}"><i class="ri-edit-2-line"></i></a>
                <div class="delete cursor-pointer btn btn-action btn-danger
                  text-white" data-bs-toggle="tooltip" data-bs-custom-class="custom-tooltip"
                  data-bs-title="Hapus batch" data-id="{{$course->course_events_id}}">
                  <i class="ri-delete-bin-line"></i>
                </div>
                <a href="{{route('admin.data-course.data-schedule.index', $course->course_events_id)}}"
                  data-bs-toggle="tooltip" data-bs-custom-class="custom-tooltip" data-bs-title="Detail kursus" class="btn detail btn-action
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
        <h5 class="modal-title" id="myModalLabel">Hapus batch kursus</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h4 class="text-center">Apakah anda yakin mengapus <br> batch <span id="batchId"></span>?</h4>
      </div>
      <form action="{{route('admin.data-course.delete')}}" method="post">
        @method('delete')
        @csrf
        <input type="hidden" name="delete_id" id="delete_id">
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" id="deletecriteria" class="btn btn-danger">Hapus</button>
      </form>
    </div>
  </div>
</div>
</div>

{{-- Create Modal --}}
<div class="modal fade" id="addnew" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog ">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myModalLabel">Tambah Batch</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action={{route('admin.data-course.store')}} id="addForm" method="POST">
          @csrf
          <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Rentang Pendaftaran</label>
            <input required type="text" autocomplete="off" name="registration_range"
              value="{{old('registration_range')}}" id="datepicker" class="form-control"
              placeholder="Masukkan rentang tanggal pendaftaran" />
          </div>
          <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Status</label>
            <select required name="status" class="form-select" aria-label="Default select example">
              <option value="1" {{old('status')==='1' ? "selected" : '' }}>Aktif</option>
              <option value="0" {{old('status')==='0' ? "selected" : '' }}>Non-Aktif</option>
            </select>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-success">Simpan</button>
      </div>
      </form>
    </div>
  </div>
</div>

{{-- Edit Modal --}}
<div class="modal fade" id="editmodal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog ">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myModalLabel">Edit Batch</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action={{route('admin.data-course.update')}} method="POST">
          @csrf
          @method('PUT')
          <input type="hidden" name="edit_id" id="edit-id">
          <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Rentang Pendaftaran</label>
            <input required type="text" autocomplete="off" name="registration_range"
              value="{{old('registration_range')}}" id="datepicker" class="form-control"
              placeholder="Masukkan rentang tanggal pendaftaran" />
          </div>
          <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Status</label>
            <select required name="status" class="form-select" aria-label="Default select example">
              <option value="1" {{old('status')==='1' ? "selected" : '' }}>Aktif</option>
              <option value="0" {{old('status')==='0' ? "selected" : '' }}>Non-Aktif</option>
            </select>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-warning text-white">Perbarui</button>
      </div>
      </form>
    </div>
  </div>
</div>

@push('js')
<script type="text/javascript">
  $(document).ready(function(){
      $(document).on('click', '.delete', function(event){
          event.preventDefault();
          let id = $(this).data('id');
          $('#deletemodal').modal('show');
          $('#batchId').html(id);
          $('#delete_id').val(id);
      });  

  });    

  $(document).on('click', '.edit', function (event){
          event.preventDefault();
          let id = $(this).data('id');
          let registerStart = $(this).data('register-start');
          let registerEnd = $(this).data('register-end');

          $('input[name="registration_range"]').daterangepicker({
          locale: {
                    format: 'DD-MM-YYYY',
                  },
          autoUpdateInput: true,
          startDate: registerStart,
          endDate: registerEnd,
        });
          $('#editmodal').modal('show');
          $('#edit-id').val(id);
      });

  $('input[name="registration_range"]').daterangepicker({
    locale: {
              format: 'DD-MM-YYYY',
              cancelLabel: 'Clear'
            },
    autoUpdateInput: false,
  });

  $('input[name="registration_range"]').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
  });

  $('input[name="registration_range"]').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
  });
</script>
@endpush

@endsection