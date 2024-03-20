<div class="sidebar" id="side_nav">
  <div class="header-box px-2 pt-3 pb-2 d-flex justify-content-center">
    <h1 class="header-text rounded rounded-3 p-3 border border-1">
      <div class="wrapper">
        <img src={{asset('assets/images/POLINEMA.png')}} class="header-logo">
        <br>
        <p class="mb-0 mt-3 text-black">UPA BAHASA POLINEMA</p>
      </div>
    </h1>
  </div>
  <div class="list-box  d-flex flex-column">
    <ul class="list-unstyled px-3 pt-3 d-flex flex-column gap-2">
      <li class="rounded {{Request::segment(2) === 'home-page' ? 'active' : ''}} rounded-2">
        <a href=# class="text-decoration-none p-3 rounded rounded-2 d-flex align-items-baseline"><i
            class="ri-dashboard-line me-2"></i>Beranda</a>
      </li>
      <li class="rounded {{Request::segment(2) === 'data-product' ? 'active' : ''}} rounded-2">
        <a href="#" class="text-decoration-none p-3 rounded rounded-2 d-flex align-items-baseline"><i
            class="ri-calendar-event-line me-2"></i>Data Event</a>
      </li>
      <li class="rounded {{Request::segment(2) === 'data-product' ? 'active' : ''}} rounded-2">
        <a href="#" class="text-decoration-none p-3 rounded rounded-2 d-flex align-items-baseline"><i
            class="ri-building-2-line me-2"></i>Data Jurusan</a>
      </li>
      <li class="rounded {{Request::segment(2) === 'data-product' ? 'active' : ''}} rounded-2">
        <a href="#" class="text-decoration-none p-3 rounded rounded-2 d-flex align-items-baseline"><i
            class="ri-book-marked-line me-2"></i>Data Program Studi</a>
      </li>
    </ul>
  </div>
</div>