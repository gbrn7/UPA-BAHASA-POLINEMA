@extends('client.base')

@section('content')
<section class="sop mt-5">
  <div class="container">
    <div class="header-section col-12 d-md-flex ">
      <div class="col-md-6 col-12 text-center btn-tab btn-first fw-medium active border border-1 border-black py-2">
        @lang('client.sop_section.btn_first')</div>
      <div class="col-md-6 col-12 text-center btn-tab btn-second fw-medium border border-1 border-black py-2">
        @lang('client.sop_section.btn_second')</div>
    </div>
    <div class="body-section col-12 mt-3 d-flex flex-column justify-content-center align-items-center">
      <div class="sop-image sop-img-first mt-4 col-lg-9 col-12">
        <div class="title col-12 text-center fw-bold">@lang('client.sop_section.title_toeic')</div>
        @isset($image_toeic)
        <img src="{{asset('storage/images/'.$image_toeic->file_name)}}" class="img-fluid mt-3">
        @endisset
      </div>
      <div class="sop-image sop-img-second d-none mt-4 col-lg-9 col-12">
        @isset($image_consult)
        <div class="title col-12 text-center fw-bold">@lang('client.sop_section.title_consult')</div>
        <img src="{{asset('storage/images/'.$image_consult->file_name)}}" class="img-fluid mt-3">
        @endisset
      </div>
    </div>
  </div>
</section>
@endsection

@section('js')
<script>
  let btnFirst = document.querySelector('.btn-first');
    let btnSecond = document.querySelector('.btn-second');

    btnFirst.addEventListener('click', (e) => {
      btnFirst.classList.add('active');
      document.querySelector('.sop-img-first').classList.remove('d-none');
      document.querySelector('.sop-img-second').classList.add('d-none');
      btnSecond.classList.remove('active');
    });

    btnSecond.addEventListener('click', (e) => {
      btnSecond.classList.add('active');
      document.querySelector('.sop-img-first').classList.add('d-none');
      document.querySelector('.sop-img-second').classList.remove('d-none');
      btnFirst.classList.remove('active');
    });
</script>
@endsection