@extends('admin.layouts.base')

@section('content')
<div class="title-box  d-flex gap-2 align-items-baseline"><i class="ri-mail-line fs-2"></i>
  <p class="fs-3 m-0">Email Notifikasi</p>
</div>
<div class="breadcrumbs-box mt-2 rounded rounded-2 bg-white p-2">
  <nav
    style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);"
    aria-label="breadcrumb">
    <ol class="breadcrumb mb-0">
      <li class="breadcrumb-item d-flex gap-2 align-items-center"><i class="ri-apps-line"></i>UPA Bahasa</li>
      <li class="breadcrumb-item active">Edit Email Notifikasi</li>
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

    <form action={{route('admin.update.email.notif', isset($mail->id) ? $mail->id : 0)}} class="form" method="POST"
      autocomplete="off">
      @csrf
      @method('PUT')
      <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Mailer</label>
        <input type="text" autocomplete="off" name="mail_transport"
          value="{{ old('mail_transport',isset($mail->mail_transport) ? $mail->mail_transport : "") }}"
          class="form-control" />
      </div>
      <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Mail Host</label>
        <input type="text" name="mail_host"
          value="{{ old('mail_host',isset($mail->mail_host)? $mail->mail_host : ""  ) }}" class="form-control"
          autocomplete="off" />
      </div>
      <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Mail Port</label>
        <input name="mail_port" value="{{ old('mail_port',isset($mail->mail_port)? $mail->mail_port : ""  ) }}"
          type="text" class="form-control" />
      </div>
      <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Mail Username</label>
        <input name="mail_username"
          value="{{ old('mail_username',isset($mail->mail_username)? $mail->mail_username : ""  ) }}"
          class="form-control" />
      </div>
      <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Mail Password</label>
        <input name="mail_password"
          value="{{ old('mail_password',isset($mail->mail_password)? $mail->mail_password : ""  ) }}" type="text"
          class="form-control" />
      </div>
      <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Mail Encryption</label>
        <input type="text" name="mail_encryption"
          value="{{ old('mail_encryption',isset($mail->mail_encryption)? $mail->mail_encryption : ""  ) }}"
          class="form-control" />
      </div>
      <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Mail From</label>
        <input type="text" name="mail_from"
          value="{{ old('mail_from',isset($mail->mail_from)? $mail->mail_from : ""  ) }}" class="form-control" />
      </div>
      <div class=" mb-3">
        <button type="submit" class="btn btn-warning text-white submit-btn fw-medium">
          Update
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