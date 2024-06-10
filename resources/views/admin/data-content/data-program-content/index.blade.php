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
          class="ri-add-box-line me-2"></i>Tambah Konten Program</div>
    </div>
    <div class="table-wrapper mt-2 mb-2">
      <table id="example" class="table mt-3 table-hover table-borderless" style="width: 100%">
        <thead>
          <tr>
            <th class="text-secondary">No</th>
            <th class="text-secondary">Judul Program (Indo)</th>
            <th class="text-secondary">Judul Program (Inggris)</th>
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
            <td>{{$content->title_indo }}</td>
            <td>{{$content->title_english }}</td>
            <td>{{$content->text_indo }}</td>
            <td>{{$content->text_english }}</td>
            <td><img src="{{asset('assets/images/'.$content->image_name)}}" alt="images" style="max-width: 300px"></td>
            <td class="">
              <div class="btn-wrapper d-flex gap-2 flex-wrap">
                <a href=# data-bs-toggle="tooltip" data-bs-custom-class="custom-tooltip" data-bs-title="Edit Konten"
                  class="btn edit btn-action btn-warning text-white" data-title-indo="{{$content->title_indo}}"
                  data-title-english="{{$content->title_english}}" data-edit-text-indo="{{$content->text_indo}}"
                  data-edit-text-english="{{$content->text_english}}" data-id="{{$content->content_id}}"><i
                    class="ri-edit-2-line"></i></a>
                <div class="delete cursor-pointer btn btn-action btn-danger
                  text-white" data-bs-toggle="tooltip" data-bs-custom-class="custom-tooltip"
                  data-bs-title="Hapus Konten" data-content-title="{{$content->title_indo}}"
                  data-id="{{$content->content_id}}">
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
        <form action="{{route('admin.data.content.store', ['type' => 'program'])}}" id="addForm" method="POST"
          enctype="multipart/form-data">
          @csrf
          <div class="mb-3">
            <label class="form-label">Judul Bahasa Indonesia</label>
            <input required type="text" name="title_indo" value="{{old('title_indo')}}" class="form-control" />
          </div>
          <div class="mb-3">
            <label class="form-label">Judul Bahasa Inggris</label>
            <input required type="text" name="title_english" value="{{old('title_english')}}" class="form-control" />
          </div>
          <div class="mb-3">
            <label class="form-label">Konten Teks Bahasa Indonesia</label>
            <textarea name="text_indo" required class="form-control" rows="3"></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Konten Teks Bahasa Inggris</label>
            <textarea name="text_english" required class="form-control" rows="3"></textarea>
          </div>
          <div class="form-group mb-3">
            <label class="form-label">Gambar</label>
            <input class="form-control" required name="image_name" type="file" />
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
        <form action={{route('admin.data.content.update', ['type'=> 'program'])}} id="addForm" method="POST"
          enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <input type="hidden" name="contentId" id="editContentId">
          <div class="mb-3">
            <label class="form-label">Judul Bahasa Indonesia</label>
            <input required type="text" id="titleEditIndo" name="title_indo" value="{{old('title_indo')}}"
              class="form-control" />
          </div>
          <div class="mb-3">
            <label class="form-label">Judul Bahasa Inggris</label>
            <input required type="text" id="titleEditEnglish" name="title_english" value="{{old('title_english')}}"
              class="form-control" />
          </div>
          <div class="mb-3">
            <label class="form-label">Konten Teks Bahasa Indonesia</label>
            <textarea name="text_indo" required class="form-control" rows="3" id="edit-text-indo"></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Konten Teks Bahasa Inggris</label>
            <textarea name="text_english" required id="edit-text-english" class="form-control" rows="3"></textarea>
          </div>
          <div class="form-group mb-3">
            <label class="form-label">Gambar</label>
            <input class="form-control" name="image_name" type="file" />
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
        <h4 class="text-center">Apakah anda yakin mengapus Konten program <span id="content-title"></span> ini?</h4>
      </div>
      <form action={{route('admin.data.content.destroy')}} method="post">
        @method('delete')
        @csrf
        <input type="hidden" name="contentId" id="deleteContentId">
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
          var contentTitle = $(this).data('content-title');
          $('#deletemodal').modal('show');
          $('#deleteContentId').val(id);
          $('#content-title').html(contentTitle);
      });  

  });   
  
  $(document).on('click', '.edit', function (event){
          event.preventDefault();
          var id = $(this).data('id');
          var titleIndo = $(this).data('title-indo');
          var titleEnglish = $(this).data('title-english');
          var textIndo = $(this).data('edit-text-indo');
          var textEnglish = $(this).data('edit-text-english');
          $('#editmodal').modal('show');
          $('#titleEditIndo').val(titleIndo);
          $('#titleEditEnglish').val(titleEnglish);
          $('#edit-text-indo').html(textIndo);
          $('#edit-text-english').html(textEnglish);
          $('#editContentId').val(id);
      });
</script>
@endpush

@endsection