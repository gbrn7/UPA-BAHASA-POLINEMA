<nav class="navbar navbar-expand-lg">
  <div class="container">
    <a class="navbar-brand d-flex" href="{{route('client')}}">
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
        <a class="nav-link d-flex align-items-center" aria-current="page" href="{{route('client')}}">
          @lang('client.navbar.home')
        </a>
        <a class="nav-link d-flex align-items-center" aria-current="page" href="{{route('client.news')}}">
          @lang('client.navbar.news')
        </a>
        <a class="nav-link d-flex align-items-center" href="{{route('client.structureOrganization')}}">
          @lang('client.navbar.structure')
        </a>
        <a class="nav-link d-flex align-items-center" href="{{route('client.sop')}}">
          @lang('client.navbar.sop')
        </a>
        @isset($adminPhoneNum)
        <a class="nav-link d-flex align-items-center" target="blank" href="https://wa.me/62{{$adminPhoneNum}}"><i
            class="ri-whatsapp-fill text-success fs-4"></i></a>
        @endisset
        <div class="dropdown">
          <i class="ri-earth-line nav-link dropdown-toggle d-flex gap-2 align-items-center" role="button"
            data-bs-toggle="dropdown" aria-expanded="false"></i>
          <ul class="dropdown-menu">
            <li class="px-1"><a class="dropdown-item rounded rounded-2" href="?lang=id">Indonesian</a></li>
            <li class="px-1"><a class="dropdown-item rounded rounded-2" href="?lang=en">English</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</nav>