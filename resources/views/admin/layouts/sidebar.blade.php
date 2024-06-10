<div class="sidebar" id="side_nav">
  <div class="header-box px-2 pt-3 pb-2 d-flex justify-content-center">
    <h1 class="header-text rounded rounded-3 p-2 border border-1">
      <a class="wrapper text-decoration-none" href="{{route('admin.home')}}">
        <img src={{asset('assets/images/POLINEMA.png')}} class="header-logo">
        <br>
        <p class="mb-0 mt-3 text-black">UPA BAHASA POLINEMA</p>
      </a>
    </h1>
  </div>
  <div class="list-box  d-flex flex-column">
    <ul class="list-unstyled px-3 pt-3 d-flex flex-column gap-2">
      <li class="rounded {{Request::segment(2) === 'home' ? 'active' : ''}} rounded-2">
        <a href={{route('admin.home')}}
          class="text-decoration-none p-3 rounded rounded-2 d-flex align-items-baseline"><i
            class="ri-dashboard-line me-2"></i>Beranda</a>
      </li>
      <li class="rounded {{Request::segment(2) === 'data-events' ? 'active' : ''}} rounded-2">
        <a href={{route('admin.data.event')}}
          class="text-decoration-none p-3 rounded rounded-2 d-flex align-items-baseline"><i
            class="ri-calendar-event-line me-2"></i>Data Event TOIEC</a>
      </li>
      <li class="rounded {{Request::segment(2) === 'data-departements' ? 'active' : ''}} rounded-2">
        <a href={{route('admin.data.departements')}}
          class="text-decoration-none p-3 rounded rounded-2 d-flex align-items-baseline"><i
            class="ri-building-2-line me-2"></i>Data Jurusan</a>
      </li>
      <li class="rounded {{Request::segment(2) === 'data-images' ? 'active' : ''}} rounded-2">
        <a href={{route('admin.data.image')}}
          class="text-decoration-none p-3 rounded rounded-2 d-flex align-items-baseline"><i
            class="ri-image-fill me-2"></i>Data Gambar</a>
      </li>
      <li class="rounded {{Request::segment(2) === 'data-content' ? 'active' : ''}} rounded-2">
        <a href={{route('admin.data.content')}}
          class="text-decoration-none p-3 rounded rounded-2 d-flex align-items-baseline"><i
            class="ri-pages-line me-2"></i>Data Konten</a>
      </li>
      <li class="rounded {{Request::segment(2) === 'data-course' ? 'active' : ''}} rounded-2">
        <a href={{route('admin.data-course.index')}}
          class="text-decoration-none p-3 rounded rounded-2 d-flex align-items-baseline"><i
            class="ri-graduation-cap-line me-2"></i>Data Kursus</a>
      </li>
      <li class="rounded {{Request::segment(2) === 'data-course-type' ? 'active' : ''}} rounded-2">
        <a href={{route('admin.data.courseType')}}
          class="text-decoration-none p-3 rounded rounded-2 d-flex align-items-baseline"><i
            class="ri-earth-line me-2"></i>Data Tipe Kursus</a>
      </li>
    </ul>
  </div>
</div>