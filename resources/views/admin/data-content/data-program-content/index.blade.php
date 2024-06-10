@extends('admin.layouts.base')

@section('content')
<div class="title-box  d-flex gap-2 align-items-baseline"><i class="ri-gallery-line fs-2"></i>
  <p class="fs-3 m-0">Data Konten Program</p>
</div>
<div class="breadcrumbs-box mt-2 rounded rounded-2 bg-white p-2">
  <nav
    style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);"
    aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item d-flex gap-2 align-items-center"><i class="ri-apps-line"></i>UPA Bahasa</li>
      <li class="breadcrumb-item" aria-current="page"><a href="{{route('admin.data.content')}}"
          class="text-decoration-none">Data Konten</a></li>
      <li class="breadcrumb-item active" aria-current="page">Data Konten Program</li>
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
          class="ri-add-box-line me-2"></i>Tambah Konten</div>
    </div>
    <div class="table-wrapper mt-2 mb-2">
      <table id="example" class="table mt-3 table-hover table-borderless" style="width: 100%">
        <thead>
          <tr>
            <th class="text-secondary">No</th>
            <th class="text-secondary">Nama Program</th>
            <th class="text-secondary">Deskripsi Indonesia</th>
            <th class="text-secondary">Dekripsi Inggris</th>
            <th class="text-secondary">Gambar</th>
            <th class="text-secondary">Aksi</th>
          </tr>
        </thead>
        <tbody id="tableBody">
          @foreach ($contents as $content)
          <tr>
            <td>{{$loop->iteration }}</td>
            <td>{{$content->title }}</td>
            <td>{{$content->text_indo }}</td>
            <td>{{$content->text_english }}</td>
            <td><img src="{{asset('storage/images/'.$content->image_name)}}" alt="images" style="max-width: 300px"></td>
            <td class="">
              <div class="btn-wrapper d-flex gap-2 flex-wrap">
                <a href=# data-bs-toggle="tooltip" data-bs-custom-class="custom-tooltip" data-bs-title="Edit Konten"
                  class="btn edit btn-action btn-warning text-white" data-title="{{$content->title}}"
                  data-text-indo="{{$content->text_indo}}" data-text-english="{{$content->text_english}}"
                  data-id="{{$content->content_id}}"><i class="ri-edit-2-line"></i></a>
                <div class="delete cursor-pointer btn btn-action btn-danger
                  text-white" data-bs-toggle="tooltip" data-bs-custom-class="custom-tooltip"
                  data-bs-title="Hapus Konten" data-title="{{$content->title}}" data-id="{{$content->content_id}}">
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
        <h5 class="modal-title" id="myModalLabel">Tambah Konten</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" id="addForm" method="POST" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="contentId" id="contentId">
          <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Judul</label>
            <input required type="text" name="title" value="{{old('title')}}" class="form-control" />
          </div>
          <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Konten Teks Bahasa Indonesia</label>
            <textarea name="text_indo">{{old('text_indo')}}</textarea>
          </div>
          <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Konten Teks Bahasa Inggris</label>
            <textarea name="text_english">{{old('text_english')}}</textarea>
          </div>
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
        <form action={{route('admin.data.image.edit')}} id="addForm" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <input type="hidden" name="contentId" id="contentId">
          <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Judul</label>
            <input required type="text" id="titleEdit" name="title" value="{{old('title')}}" class="form-control" />
          </div>
          <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Konten Teks Bahasa Indonesia</label>
            <textarea name="text_indo" id="edit-text-indo"></textarea>
          </div>
          <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Konten Teks Bahasa Inggris</label>
            <textarea name="text_english" id="edit-text-english"></textarea>
          </div>
          <div class="form-group mb-3">
            <input required class="form-control" name="image" type="file" />
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
        <h5 class="modal-title" id="myModalLabel">Hapus Konten</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h4 class="text-center">Apakah anda yakin mengapus Konten <span id="titleDelete"></span> ini?</h4>
      </div>
      <form action={{route('admin.data.image.destroy')}} method="post">
        @method('delete')
        @csrf
        <input type="hidden" name="contentId" id="contentId">
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" id="deletecriteria" class="btn btn-danger">Hapus</button>
      </form>
    </div>
  </div>
</div>


@push('js')
<script type="text/javascript">
  $(document).ready(function(){
      $(document).on('click', '.delete', function(event){
          event.preventDefault();
          var id = $(this).data('id');
          var title = $(this).data('title');
          $('#deletemodal').modal('show');
          $('#contentId').val(id);
          $('#titleDelete').html(title);
      });  

  });   
  
  $(document).on('click', '.edit', function (event){
          event.preventDefault();
          var id = $(this).data('id');
          var title = $(this).data('title');
          var textIndo = $(this).data('edit-text-indo');
          var textEnglish = $(this).data('edit-text-english');
          $('#editmodal').modal('show');
          $('#titleEdit').val(title);
          $('#edit-text-indo').val(textIndo);
          $('#edit-text-english').val(textEnglish);
          $('#contentId').val(id);
      });
</script>
@endpush

@endsection