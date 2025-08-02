@extends('admin.layouts.base')

@section('content')
<div class="title-box  d-flex gap-2 align-items-baseline"><i class="ri-calendar-event-line fs-2"></i>
  <p class="fs-3 m-0">Data Berita</p>
</div>
<div class="breadcrumbs-box mt-2 rounded rounded-2 bg-white p-2">
  <nav
    style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);"
    aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item d-flex gap-2 align-items-center"><i class="ri-apps-line"></i>UPA Bahasa</li>
      <li class="breadcrumb-item active" aria-current="page">Data Berita</li>
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
      <a href={{route('data-news.create')}}>
        <div id="add" class="btn btn-success"><i class="ri-add-box-line me-2"></i>Tambah Berita</div>
      </a>
    </div>
    <div class="table-wrapper mt-2 mb-2">
      <table id="example" class="table mt-3 table-hover table-borderless" style="width: 100%">
        <thead>
          <tr>
            <th class="text-secondary">ID</th>
            <th class="text-secondary">Judul</th>
            <th class="text-secondary">Thumbnail</th>
            <th class="text-secondary">Tanggal Dibuat</th>
            <th class="text-secondary">Aksi</th>
          </tr>
        </thead>
        <tbody id="tableBody">
          @foreach ($news as $item)
          <tr>
            <td>{{$item->news_id }}</td>
            <td>{{$item->title }}</td>
            <td><img src="{{asset('storage/news_thumbnail/'.$item->thumbnail)}}" alt="images" style="max-width: 300px">
            </td>
            <td>{{date("d-m-Y", strtotime($item->created_at)) }}</td>
            <td class="">
              <div class="btn-wrapper d-flex gap-2 flex-wrap">
                <a href={{route('data-news.edit',$item->news_id)}} data-bs-toggle="tooltip"
                  data-bs-custom-class="custom-tooltip"
                  data-bs-title="Edit Berita" class="btn edit btn-action
                  btn-warning
                  text-white"><i class="ri-edit-2-line"></i></a>
                <div class="delete cursor-pointer btn btn-action btn-danger
                  text-white" data-bs-toggle="tooltip" data-bs-custom-class="custom-tooltip"
                  data-bs-title="Hapus Berita" data-title="{{$item->title}}" data-id=" {{$item->news_id}}">
                  <i class="ri-delete-bin-line"></i>
                </div>
                <a href={{route('data-news.show', $item->news_id)}} data-bs-toggle="tooltip"
                  data-bs-custom-class="custom-tooltip"
                  data-bs-title="Detail Berita" class="btn detail btn-action
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
        <h5 class="modal-title" id="myModalLabel">Hapus Berita</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h4 class="text-center">Apakah anda yakin mengapus Berita <span id="deleteLabel"></span> ini?</h4>
      </div>
      <form action={{route('data-news.destroy')}} method="post">
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
          var title = $(this).data('title');
          $('#deletemodal').modal('show');
          $('#deleteId').val(id);
          $('#deleteLabel').html(title);
          ;
      });  

  }); 
</script>
@endpush

@endsection