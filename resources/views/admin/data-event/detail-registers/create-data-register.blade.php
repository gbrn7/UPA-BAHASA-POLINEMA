@extends('admin.layouts.base')

@section('content')
<div class="title-box  d-flex gap-2 align-items-baseline"><i class="ri-calendar-event-line fs-2"></i>
  <p class="fs-3 m-0">Tambah Pendaftar</p>
</div>
<div class="breadcrumbs-box mt-2 rounded rounded-2 bg-white p-2">
  <nav
    style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);"
    aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item d-flex gap-2 align-items-center"><i class="ri-apps-line"></i>UPA Bahasa</li>
      <li class="breadcrumb-item"><a href={{route('admin.data.event')}} class="text-decoration-none">Data Event</a></li>
      <li class="breadcrumb-item"><a href={{route('admin.data.detail.registers', $event_id)}}
          class="text-decoration-none">Detail
          Pendaftar</a></li>
      <li class="breadcrumb-item active" aria-current="page">Tambah Pendaftar</li>
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

    <form enctype="multipart/form-data" action={{route('admin.data.detail.registers.saveRegister', $event_id)}}
      class="form" method="POST">
      @csrf
      <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Nama Lengkap</label>
        <input required type="Text" name="name" value="{{old('name')}}" class="form-control"
          placeholder="Masukkan nama anda" />
      </div>
      <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">NIM</label>
        <input required name="nim" type="Text" class="form-control" placeholder="Masukkan NIM anda"
          value="{{old('nik')}}" />
      </div>
      <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">NIK (Nomor Induk Kependudukan)</label>
        <input required name="nik" type="Text" class="form-control" placeholder="Masukkan NIK anda"
          value="{{old('nik')}}" />
      </div>
      <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Jurusan</label>
        <select name="departement" required id="jurusan-select" class="form-select" aria-label="Default select example">
          <option value="">Pilih Jurusan</option>
          @foreach ($departements as $departement)
          <option value="{{$departement->departement_id}}" {{old('departement')===$departement->name ? 'selected' :
            ''}}>
            {{$departement->name}}</option>
          @endforeach
        </select>
      </div>
      <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Program Studi</label>
        <select name="program_study" required class="form-select" aria-label="Default select example">
          <option value="">Pilih jurusan terlebih dahulu</option>
        </select>
      </div>
      <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Semester</label>
        <select required name="semester" class="form-select" aria-label="Default select example">
          <option value="">Pilih Semester</option>
          <option value="4" {{old('semester')==='4' ? ' selected' : '' }}>4</option>
          <option value="6" {{old('semester')==='6' ? ' selected' : '' }}>6</option>
          <option value="8" {{old('semester')==='8' ? ' selected' : '' }}>8</option>
        </select>
      </div>
      <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Email</label>
        <input required type="email" class="form-control" id="exampleFormControlInput1"
          placeholder="Masukkan email anda" name="email" value="{{old('email')}}" />
      </div>
      <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">No WA</label>
        <input required type="number" class="form-control" id="exampleFormControlInput1"
          placeholder="Masukkan no telepon anda" name="phone_num" value="{{old('phone_num')}}" />
      </div>
      <div class="mb-3">
        <label for="formFile" class="form-label">Foto KTP</label>
        <input required class="form-control" type="file" id="formFile" name="ktp_img" value="{{old('ktp_img')}}">
      </div>
      <div class="mb-3">
        <label for="formFile" class="form-label">Foto KTM</label>
        <input required class="form-control" type="file" id="formFile" name="ktm_img" value="{{old('ktm_img')}}">
      </div>
      <div class="mb-3">
        <label for="formFile" class="form-label">Surat Pernyataan Nominasi IISMA (dari KPS)</label>
        <input required class="form-control" type="file" id="formFile" name="surat_pernyataan_iisma"
          value="{{old('surat_penyataan_iisma')}}">
      </div>
      <div class="mb-3">
        <label for="formFile" class="form-label">Pas Foto</label>
        <input required class="form-control" type="file" id="formFile" name="pasFoto_img"
          value="{{old('pasFoto_img')}}">
      </div>
      <div class=" mb-5">
        <button type="submit" class="btn btn-success submit-btn fw-medium">
          Simpan
        </button>
      </div>
    </form>
  </div>
</div>

<script>
  const form = document.querySelector(".form");
    form.addEventListener('submit', function () {
      document.querySelector("html").style.cursor = "wait";
      document.querySelector(".loading-wrapper").classList.remove('d-none');
    });

  $('#jurusan-select').change(function (e) { 
      e.preventDefault();
      DepartementId = this.value;

      document.querySelector("html").style.cursor = "wait";
      document.querySelector(".loading-wrapper").classList.remove('d-none');

      $.ajax({
        type: "Get",
        url: "{{route('client.getProgramStudy')}}",
        data: {
          "_token": "{{csrf_token()}}",
          "departement_id" : DepartementId
        },
        success: function (res, status) {
          if(res.data.length > 0){
            $('select[name="program_study"]').empty();
            res.data.forEach(e => {
              $('select[name="program_study"]').append(`<option value="${e.name}">${e.name}</option>`);
            })
          }else{
            $('select[name="program_study"]').empty().append(`<option value="">Program studi tidak ditemukan</option>`);
          }
        }

      });

      document.querySelector("html").style.cursor = "default";
      document.querySelector(".loading-wrapper").classList.add('d-none');
      
    });
</script>

@endsection