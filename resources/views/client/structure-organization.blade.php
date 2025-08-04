@extends('client.base')

@section('content')
<section class="sop mt-4">
  <div class="container">
    <div class="header-section col-12 text-center">
      <div class="title text-center fw-bold blue-font">@lang('client.structure_organization_section.title')</div>
      <div class="title text-center fw-bold blue-font">UPA Bahasa</div>
      <div class="title text-center fw-regular blue-font">@lang('client.structure_organization_section.polinema')
      </div>

    </div>
    @if (isset($image))
    <div class="body-section col-12 mt-1 d-flex flex-column justify-content-center align-items-center">
      <div class="structure-organization-image sop-img-first mt-4 col-12 d-flex justify-content-center">
        <img src="{{asset('storage/images/'.$image->file_name)}}" class="img-fluid">
      </div>
    </div>
    @endif
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