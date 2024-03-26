@extends('admin.layouts.base')

@section('content')
<div class="title-box  d-flex gap-2 align-items-baseline"><i class="ri-calendar-event-line fs-2"></i>
  <p class="fs-3 m-0">Edit Profil</p>
</div>
<div class="breadcrumbs-box mt-2 rounded rounded-2 bg-white p-2">
  <nav
    style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);"
    aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item d-flex gap-2 align-items-center"><i class="ri-apps-line"></i>UPA Bahasa</li>
      <li class="breadcrumb-item"><a href={{route('admin.data.event')}} class="text-decoration-none">Edit Profil</a>
      </li>
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

    <form action={{route('admin.updateProfile')}} class="form" method="POST">
      @csrf
      @method('PUT')
      <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Nama</label>
        <input type="text" autocomplete="off" name="name" value="{{auth()->user()->name}}" id="datepicker"
          class="form-control" placeholder="Masukkan nama baru anda" />
      </div>
      <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Email</label>
        <input type="text" name="email" value="{{auth()->user()->email}}" class="form-control"
          placeholder="Masukkan email baru anda" />
      </div>
      <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">No. WhatsApp admin</label>
        <input name="phone_num" type="text" class="form-control" placeholder="Masukkan No WhatsApp admin" />
      </div>
      <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Password Lama</label>
        <input name="old_password" type="password" class="form-control" placeholder="Masukkan password lama anda" />
      </div>
      <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Password Baru</label>
        <input name="new_password" type="password" class="form-control" placeholder="Masukkan password baru anda" />
      </div>
      <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Konfirmasi Password Baru</label>
        <input name="confirm_new_password" type="password" class="form-control"
          placeholder="Masukkan password baru anda" />
      </div>
      <div class=" mb-3">
        <button type="submit" class="btn btn-success submit-btn fw-medium">
          Simpan
        </button>
      </div>
    </form>
  </div>
</div>

@push('js')
<script>
  const form = document.querySelector(".form");
    form.addEventListener('submit', function () {
      document.querySelector("html").style.cursor = "wait";
      document.querySelector(".loading-wrapper").classList.remove('d-none');
    });
</script>
@endpush

@endsection