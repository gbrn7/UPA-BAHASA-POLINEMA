@extends('admin.layouts.base')

@section('content')
<div class="title-box  d-flex gap-2 align-items-baseline"><i class="ri-earth-line fs-2"></i>
  <p class="fs-3 m-0">Data Tipe Kursus</p>
</div>
<div class="breadcrumbs-box mt-2 rounded rounded-2 bg-white p-2">
  <nav
    style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);"
    aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item d-flex gap-2 align-items-center"><i class="ri-apps-line"></i>UPA Bahasa</li>
      <li class="breadcrumb-item active" aria-current="page">Data Tipe Kursus</li>
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
      <div data-bs-toggle="modal" data-bs-target="#addnew" class="btn btn-success"><i
          class="ri-add-box-line me-2"></i>Tambah Tipe Kursus</div>
    </div>
    <div class="table-wrapper mt-2 mb-2">
      <table id="example" class="table mt-3 table-hover table-borderless" style="width: 100%">
        <thead>
          <tr>
            <th class="text-secondary">No</th>
            <th class="text-secondary">Nama</th>
            <th class="text-secondary">Aksi</th>
          </tr>
        </thead>
        <tbody id="tableBody">
          @foreach ($courses as $course)
          <tr>
            <td>{{$loop->iteration }}</td>
            <td>{{$course->name }}</td>
            <td class="">
              <div class="btn-wrapper d-flex gap-2 flex-wrap">
                <a href=# data-bs-toggle="tooltip" data-bs-custom-class="custom-tooltip"
                  data-bs-title="Edit tipe kursus" class="btn edit btn-action
                  btn-warning text-white" data-name=" {{$course->name}}" data-id="{{$course->course_type_id}}"><i
                    class="ri-edit-2-line"></i></a>
                <div class="delete cursor-pointer btn btn-action btn-danger
                  text-white" data-bs-toggle="tooltip" data-bs-custom-class="custom-tooltip"
                  data-bs-title="Hapus tipe kursus" data-name="{{$course->name}}" data-id="{{$course->course_type_id}}">
                  <i class="ri-delete-bin-line"></i>
                </div>
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

{{-- Create Modal --}}
<div class="modal fade" id="addnew" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog ">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myModalLabel">Tambah Tipe Kursus</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{route('admin.data.courseType.storeCourseType')}}" id="addForm" method="POST">
          @csrf
          <div class="form-group mb-3">
            <label for="nama" class="mb-1">Tipe Kursus</label>
            <input required class="form-control" type="text" name="name" placeholder="Masukkan tipe kursus" />
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
        <h5 class="modal-title" id="myModalLabel">Edit Tipe Kursus</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{route('admin.data.courseType.updateCourseType')}}" id="addForm" method="POST">
          @csrf
          @method('PUT')
          <input type="hidden" name="editId" id="editId">
          <div class="form-group mb-3">
            <label for="nama" class="mb-1">Nama Tipe Kursus</label>
            <input required class="form-control" type="text" name="name" id="name-edit"
              placeholder="Masukkan tipe kursus" />
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

{{-- Delete Modal --}}
<div class="modal fade" id="deletemodal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog ">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myModalLabel">Hapus tipe kursus</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h4 class="text-center">Apakah anda yakin mengapus tipe kursus <span id="deleteLabel"></span> ini?</h4>
      </div>
      <form action={{route('admin.data.courseType.deleteDepartement')}} method="post">
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

@push('js')
<script type="text/javascript">
  $(document).ready(function(){
      $(document).on('click', '.delete', function(event){
          event.preventDefault();
          var id = $(this).data('id');
          var name = $(this).data('name');
          $('#deletemodal').modal('show');
          $('#deleteId').val(id);
          $('#deleteLabel').html(name);
      });  

  });   
  
  $(document).on('click', '.edit', function (event){
          event.preventDefault();
          var id = $(this).data('id');
          var name = $(this).data('name');
          $('#editmodal').modal('show');
          $('#name-edit').val(name);
          $('#editId').val(id);
      });
</script>
@endpush

@endsection