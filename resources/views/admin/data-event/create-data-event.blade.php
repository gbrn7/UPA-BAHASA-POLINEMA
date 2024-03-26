@extends('admin.layouts.base')

@section('content')
<div class="title-box  d-flex gap-2 align-items-baseline"><i class="ri-calendar-event-line fs-2"></i>
  <p class="fs-3 m-0">Tambah Event</p>
</div>
<div class="breadcrumbs-box mt-2 rounded rounded-2 bg-white p-2">
  <nav
    style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);"
    aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item d-flex gap-2 align-items-center"><i class="ri-apps-line"></i>UPA Bahasa</li>
      <li class="breadcrumb-item"><a href={{route('admin.data.event')}} class="text-decoration-none">Data Event</a></li>
      <li class="breadcrumb-item active" aria-current="page">Tambah Event</li>
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

    <form action={{route('admin.data.storeEvent')}} class="form" method="POST">
      @csrf
      <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Rentang Pendaftaran</label>
        <input required type="text" autocomplete="off" name="registration_range" value="{{old('registration_range')}}"
          id="datepicker" class="form-control" placeholder="Masukkan rentang tanggal pendaftaran" />
      </div>
      <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Tanggal Pelaksanaan</label>
        <input required type="text" name="execution" value="{{old('execution')}}" autocomplete="off" id="datepicker"
          class="form-control" placeholder="Masukkan tanggal pelaksanaan" />
      </div>
      <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Kuota</label>
        <input required type="number" min="0" name="quota" value="{{old('quota')}}" class="form-control"
          placeholder="Masukkan kuota pendaftar" />
      </div>
      <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Link Grup WhatsAppp</label>
        <input type="Text" name="wa_group_link" value="{{old('wa_group_link')}}" class="form-control"
          placeholder="Masukkan link grup WhatsAppp" />
      </div>
      <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Status</label>
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

<script>
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


  $('input[name="execution"]').daterangepicker({
    singleDatePicker: true,  
    autoUpdateInput: false,
    locale: {
              format: 'DD-MM-YYYY',
              cancelLabel: 'Clear'
            }
    });

    $('input[name="execution"]').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('DD-MM-YYYY'));
  });

  $('input[name="execution"]').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
  });

</script>


@endsection