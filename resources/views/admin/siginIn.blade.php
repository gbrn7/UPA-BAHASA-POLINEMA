@extends('admin.layouts.adminAuth')

@section('asset-image')
<img src="{{asset('assets/images/competition.jpg')}}" class="login-img" style="object-fit: cover" />
@endsection

@section('title', 'Sign In')

@section('content')
<form action={{route('admin.signIn.auth')}} method="post">
  @csrf
  <div class="login-form d-flex flex-column gap-1 gap-lg-2 mt-2 mt-lg-4 mt-4">
    <label for="email">Email</label>
    <input name="email" value="{{old('email')}}" class="form-control @error('email') is-invalid @enderror text-black"
      id="email" placeholder="Masukan email" />
    @error('email')
    <div class="invalid-feedback">
      {{$message}}
    </div>
    @enderror
    <div class="password-container">
      <label for="password">Password</label>
      <div class="pass-wrapper">
        <input name="password" type="password" class="form-control text-black @error('password') is-invalid @enderror"
          id="password" placeholder="Masukan password" />
        @error('password')
        <div class="invalid-feedback">
          {{$message}}
        </div>
        @enderror
      </div>
    </div>
    <button class="btn btn-primary login-btn mt-1 mt-lg-2" type="submit">
      Sign In
    </button>
  </div>
</form>
@endsection