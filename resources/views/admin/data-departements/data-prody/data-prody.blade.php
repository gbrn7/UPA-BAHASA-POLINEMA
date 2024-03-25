@extends('admin.layouts.base')

@section('content')
<div class="title-box  d-flex gap-2 align-items-baseline"><i class="ri-calendar-event-line fs-2"></i>
  <p class="fs-3 m-0">Data Program Studi <span class="fs-5 fw-light">Jurusan {{$departement->name}}</span></p>
</div>
<div class="breadcrumbs-box mt-2 rounded rounded-2 bg-white p-2">
  <nav
    style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);"
    aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item d-flex gap-2 align-items-center"><i class="ri-apps-line"></i>UPA Bahasa</li>
      <li class="breadcrumb-item" aria-current="page"><a class="text-decoration-none"
          href={{route('admin.data.departements')}}>Data Jurusan</a></li>
      <li class="breadcrumb-item active" aria-current="page">Data Program Studi</li>
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
          class="ri-add-box-line me-2"></i>Tambah Program Studi</div>
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
          @foreach ($prodys as $prody)
          <tr>
            <td>{{$loop->iteration }}</td>
            <td>{{$prody->name }}</td>
            <td class="">
              <div class="btn-wrapper d-flex gap-2 flex-wrap">
                <a href=# data-bs-toggle="tooltip" data-bs-custom-class="custom-tooltip" data-bs-title="Edit Jurusan"
                  class="btn edit btn-action
                  btn-warning text-white" data-name="{{$prody->name}}" data-id="{{$prody->prody_id}}"><i
                    class="ri-edit-2-line"></i></a>
                <div class="delete cursor-pointer btn btn-action btn-danger
                  text-white" data-bs-toggle="tooltip" data-bs-custom-class="custom-tooltip"
                  data-bs-title="Hapus Jurusan" data-name="{{$prody->name}}" data-id="{{$prody->prody_id}}">
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
        <h5 class="modal-title" id="myModalLabel">Tambah Program Studi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action={{route('admin.data.departements.storeProgramStudy', $departement->departement_id)}} id="addForm"
          method="POST">
          @csrf
          <input type="hidden" name="departement_id" value="{{$departement->departement_id}}" id="departement-id">
          <div class="form-group mb-3">
            <label for="nama" class="mb-1">Nama Program Studi</label>
            <input required class="form-control" type="text" name="name" placeholder="Masukkan Nama Program Studi" />
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
        <h5 class="modal-title" id="myModalLabel">Edit Program Studi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action={{route('admin.data.departements.updateProgramStudy', $departement->departement_id)}} id="addForm"
          method="POST">
          @csrf
          @method('PUT')
          <input type="hidden" name="id" id="edit-id">
          <input type="hidden" name="departement_id" value="{{$departement->departement_id}}" id="departement-id">
          <div class="form-group mb-3">
            <label for="nama" class="mb-1">Nama Program Studi</label>
            <input required class="form-control" type="text" name="name" id="name-edit"
              placeholder="Masukkan Nama Jurusan" />
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
        <h5 class="modal-title" id="myModalLabel">Hapus Program Studi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h4 class="text-center">Apakah anda yakin mengapus Program Studi <span id="programStudyName"></span> ini?</h4>
      </div>
      <form action={{route('admin.data.departements.deleteProgramStudy', $departement->departement_id)}} method="post">
        @method('delete')
        @csrf
        <input type="hidden" name="prodyId" id="prodyId">
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
          $('#prodyId').val(id);
          $('#programStudyName').html(name);
      });  

  });   
  
  $(document).on('click', '.edit', function (event){
          event.preventDefault();
          var id = $(this).data('id');
          var name = $(this).data('name');
          $('#editmodal').modal('show');
          $('#name-edit').val(name);
          $('#edit-id').val(id);
      });
</script>
@endpush

@endsection