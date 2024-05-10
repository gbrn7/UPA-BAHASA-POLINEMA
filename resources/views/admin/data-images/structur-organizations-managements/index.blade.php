@extends('admin.layouts.base')

@section('content')
<div class="title-box  d-flex gap-2 align-items-baseline"><i class="ri-calendar-event-line fs-2"></i>
  <p class="fs-3 m-0">Data Gambar Struktur Organisasi</p>
</div>
<div class="breadcrumbs-box mt-2 rounded rounded-2 bg-white p-2">
  <nav
    style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);"
    aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item d-flex gap-2 align-items-center"><i class="ri-apps-line"></i>UPA Bahasa</li>
      <li class="breadcrumb-item active" aria-current="page">Data Gambar Struktur Organisasi</li>
    </ol>
  </nav>
</div>
<div class="content-box mt-3 rounded rounded-2 bg-white">
  @if (isset($image))
  <a href=# data-bs-toggle="tooltip" data-bs-custom-class="custom-tooltip" data-bs-title="Edit Gambar" class="btn edit btn-action
  btn-warning text-white" data-name="{{$image->file_name}}" data-id="{{$image->image_id}}">Edit Gambar</a>
  <div class="delete cursor-pointer btn btn-action btn-danger
  text-white" data-bs-toggle="tooltip" data-bs-custom-class="custom-tooltip" data-bs-title="Hapus Gambar"
    data-name="{{$image->file_name}}" data-id="{{$image->image_id}}">
    Hapus Gambar
  </div>
  @else
  <div data-bs-toggle="modal" data-bs-target="#addnew" class="btn btn-success"><i
      class="ri-add-box-line me-2"></i>Tambah Gambar</div>
  @endif
  <table class="table table-bordered table-striped table-hover table-sm mt-2">
    <tr>
      <th>Nama File</th>
      @if (isset($image))
      <td>{{ $image->file_name }}</td>
      @else
      <td>-</td>
      @endif
    </tr>
    <tr>
      <th>Gambar Struktur Organisasi :</th>
      @if (isset($image))
      <td>
        <div class="img-wrapper">
          <img src="{{ asset('storage/images/'.$image->file_name) }}" alt="ktp" class="img-fluid register-data-img">
        </div>
      </td>
      @else
      <td>-</td>
      @endif
    </tr>

  </table>
</div>

{{-- Create Modal --}}
<div class="modal fade" id="addnew" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog ">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myModalLabel">Tambah Gambar</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{route('admin.data.image.galleryManagement.create', ['type'=> 'structure_organization'])}}"
          id="addForm" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="form-group mb-3">
            <input required class="form-control" name="image" type="file" />
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
<div class="modal fade" id="editmodal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"> wire:
  <div class="modal-dialog ">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myModalLabel">Edit Gambar</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action={{route('admin.data.image.galleryManagement.edit')}} id="addForm" method="POST"
          enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <input type="hidden" name="imageId" id="edit-id">
          <div class="form-group mb-3">
            <input required class="form-control" type="file" name="image" placeholder="Masukkan gambar yang baru" />
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
        <h5 class="modal-title" id="myModalLabel">Hapus Gambar</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h4 class="text-center">Apakah anda yakin mengapus Gambar <span id="imageName"></span> ini?</h4>
      </div>
      <form action={{route('admin.data.image.galleryManagement.destroy')}} method="post">
        @method('delete')
        @csrf
        <input type="hidden" name="imageId" id="imageId">
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
          $('#imageId').val(id);
          $('#imageName').html(name);
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