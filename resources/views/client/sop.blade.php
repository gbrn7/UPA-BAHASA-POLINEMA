<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>UPA POLINEMA</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href={{asset('assets/style/landing-page-style.css')}} />

  <!-- Icon -->
  <link rel="shortcut icon" href={{asset('assets/images/POLINEMA.png')}} type="image/x-icon" />

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
  <!-- Link BoxIcon -->
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />

  <!-- Link Remixicon -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.css"
    integrity="sha512-OQDNdI5rpnZ0BRhhJc+btbbtnxaj+LdQFeh0V9/igiEPDiWE2fG+ZsXl0JEH+bjXKPJ3zcXqNyP4/F/NegVdZg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
  <nav class="navbar navbar-expand-lg">
    <div class="container">
      <a class="navbar-brand d-flex" href="{{route('client')}}/#gallery">
        <div class="img-wrapper">
          <img src={{asset('assets/images/POLINEMA.png')}} class="img-logo img-fluid" />
        </div>
        <div class="title-wrapper d-flex flex-column justify-content-center ms-2">
          <p class="mb-1">UPA BAHASA</p>
          <p class="mb-0">POLITEKNIK NEGERI MALANG</p>
        </div>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
        aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNavAltMarkup">
        <div class="navbar-nav">
          <a class="nav-link d-flex align-items-center" aria-current="page"
            href="{{route('client')}}/#home">@lang('client.navbar.home')</a>
          @isset($activeEvent)
          <a class="nav-link d-flex align-items-center"
            href="{{route('client')}}/#announcement">@lang('client.navbar.announcement')</a>
          @endisset
          <a class="nav-link d-flex align-items-center"
            href="{{route('client')}}/#program">@lang('client.navbar.program')</a>
          <a class="nav-link d-flex align-items-center"
            href="{{route('client')}}/#gallery">@lang('client.navbar.gallery')</a>
          <a class="nav-link d-flex align-items-center"
            href="{{route('client.structureOrganization')}}">@lang('client.navbar.structure')</a>
          <a class="nav-link d-flex align-items-center" href="{{route('client.sop')}}">@lang('client.navbar.sop')</a>
          @isset($adminPhoneNum)
          <a class="nav-link d-flex align-items-center" target="blank" href="https://wa.me/62{{$adminPhoneNum}}"><i
              class="ri-whatsapp-fill text-success fs-4"></i></a>
          @endisset
          <div class="dropdown">
            <i class="ri-earth-line nav-link dropdown-toggle d-flex gap-2 align-items-center" role="button"
              data-bs-toggle="dropdown" aria-expanded="false"></i>
            <ul class="dropdown-menu">
              <li class="px-1"><a class="dropdown-item rounded rounded-2"
                  href="{{route('client.sop', ['lang'=> 'id'])}}">Indonesian</a></li>
              <li class="px-1"><a class="dropdown-item rounded rounded-2"
                  href="{{route('client.sop', ['lang'=> 'en'])}}">English</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </nav>

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


  <!-- Footer Start -->
  <footer class="mt-5 pt-3">
    <div class="container footer-wrapper">
      <div class="row foot">
        <div class="col-12 col-lg-4 one justify-content-between">
          <div class="head">
            <div class="img-footer">
              <img src={{asset('assets/images/JOSS!.png')}} class="img-fluid" />
            </div>
            <p class="desc-brand">@lang('client.footer.address')</p>
            <div class="icon-wrap d-flex align-items-center mt-3">
              <i class="bx bx-phone-call me-2"></i>
              <p class="m-0">(0341) 404424</p>
            </div>
          </div>
          <div class="icon mt-4">
            <a class="bx bxl-instagram text-decoration-none fs-3 text-black"
              href="https://www.instagram.com/upabahasa/"></a>
          </div>
        </div>
        <div class="col-12 col-lg-3 two mt-2 mt-lg-0 ms-auto">
          <p class="title">@lang('client.footer.nav.Related Links')</p>
          <div class="desc">
            <div class="icon-wrap d-flex mt-2">
              <a href={{route('admin.signIn')}}>Admin</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </footer>

  <!-- Footer End -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
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
</body>

</html>