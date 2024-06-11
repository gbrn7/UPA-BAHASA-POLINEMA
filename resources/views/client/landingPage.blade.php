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
  {{-- Sweet alert --}}
  @include('sweetalert::alert')
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
          <a class="nav-link d-flex align-items-center" aria-current="page" href="#home">@lang('client.navbar.home')</a>
          @isset($activeEvents)
          <a class="nav-link d-flex align-items-center" href="#announcement">@lang('client.navbar.announcement')</a>
          @endisset
          <a class="nav-link d-flex align-items-center" href="#program">@lang('client.navbar.program')</a>
          <a class="nav-link d-flex align-items-center" href="#gallery">@lang('client.navbar.gallery')</a>
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
                  href="{{route('client', ['lang'=> 'id'])}}">Indonesian</a></li>
              <li class="px-1"><a class="dropdown-item rounded rounded-2"
                  href="{{route('client', ['lang'=> 'en'])}}">English</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </nav>

  <!-- Home -->
  @if ($profile)
  <section class="home mt-5" id="home">
    <div class="container">
      <div class="row align-items-center">
        <div class="header-section col-12 col-lg-7 text-center text-lg-start">
          <h4 class="head-title fw-bold">
            {{App::getLocale() == 'id' ? $profile->title_indo : $profile->title_english}}
          </h4>
          <div class="desc-content">{{App::getLocale() == 'id' ? $profile->text_indo : $profile->text_english}}</div>
        </div>
        <div class="col-12 col-lg-5 mt-3 mt-lg-0">
          <img src={{asset('storage/images/'.$profile->image_name)}} alt="" class="img-fluid rounded-5" />
        </div>
      </div>
    </div>
  </section>
  @endif

  @isset($activeEvents)
  <!-- Announcement -->
  <section class="announcement mt-5" id="announcement">
    <div class="container">
      <div class="header-section text-center">
        <p class="head-title mb-2">@lang('client.announcement_section.head_title')</p>
      </div>
      @isset($activeEvents->activeToeicEvents)
      <div class="body-section english-test mt-2 row justify-content-center">
        <h3 class="title-content text-center">@lang('client.announcement_section.english_test.title_content')</h3>
        <div class="col-lg-10 col-12 rounded rounded-2">
          <p class="text-center desc-content">@lang('client.announcement_section.english_test.desc_content')</p>
          <div class="info-wrapper overflow-auto p-3 row bg-white rounded-3">
            <div class="info p-3 overflow-auto rounded-2 text-center">
              <div class="schedule-wrapper">
                <div class="table-wrapper table-content mt-2 mb-2">
                  <table id="example" class="table mt-3 table-hover" style="width: 100%">
                    <thead>
                      <tr>
                        <th class="text-secondary batch">
                          @lang('client.announcement_section.english_test.table_content.batch')</th>
                        <th class="text-secondary registration-date">
                          @lang('client.announcement_section.english_test.table_content.registration_date')</th>
                        <th class="text-secondary execution-date">
                          @lang('client.announcement_section.english_test.table_content.execution_date')</th>
                        <th class="text-secondary">@lang('client.announcement_section.english_test.table_content.quota')
                        </th>
                        <th class="text-secondary">
                          @lang('client.announcement_section.english_test.table_content.remaining_quota')
                        </th>
                      </tr>
                    </thead>
                    <tbody id="tableBody">
                      @foreach ($activeEvents->activeToeicEvents as $activeEvent)
                      <tr>
                        <td>{{$activeEvent->toeic_test_events_id}}</td>
                        <td>{{date("d M Y", strtotime($activeEvent->register_start)) }} - {{date("d M
                          Y", strtotime($activeEvent->register_end)) }}</td>
                        <td>{{date("d M Y", strtotime($activeEvent->execution)) }}</td>
                        <td>{{$activeEvent->quota}}</td>
                        <td>{{$activeEvent->remaining_quota}}</td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
                <a class="btn btn-primary register_btn fw-medium mt-3"
                  href={{route('client.english.test.form')}}>@lang('client.announcement_section.register_btn')</a>
              </div>
            </div>
          </div>
        </div>
      </div>
      @endisset
      @isset($activeEvents->activeCourseEvent)
      <div class="body-section english-course mt-2 row justify-content-center mt-3">
        <h3 class="title-content text-center">@lang('client.announcement_section.language_course.title_content')</h3>
        <div class="col-lg-10 col-12 rounded rounded-2">
          <p class="text-center desc-content">@lang('client.announcement_section.language_course.desc_content')</p>
          <div class="info-wrapper overflow-auto p-3 row bg-white rounded-3">
            <div class="info p-3 overflow-auto rounded-2 text-center">
              <div class="schedule-wrapper">
                <div class="table-wrapper table-content mt-2 mb-2">
                  <table id="example" class="table mt-3 table-hover" style="width: 100%">
                    <thead>
                      <tr>
                        <th class="text-secondary batch">
                          @lang('client.announcement_section.language_course.table_content.batch')</th>
                        <th class="text-secondary registration-date">
                          @lang('client.announcement_section.language_course.table_content.registration_date')</th>
                        <th class="text-secondary execution-date">
                          @lang('client.announcement_section.language_course.table_content.execution_date')</th>
                        <th class="text-secondary execution-date">
                          @lang('client.announcement_section.language_course.table_content.number_of_courses')</th>
                        </th>
                      </tr>
                    </thead>
                    <tbody id="tableBody">
                      <tr>
                        <td>{{$activeEvents->activeCourseEvent->course_events_id}}</td>
                        <td>{{date("d M Y", strtotime($activeEvents->activeCourseEvent->register_start)) }} - {{date("d
                          M
                          Y", strtotime($activeEvents->activeCourseEvent->register_end)) }}</td>
                        <td>{{date("d M Y", strtotime($activeEvents->activeCourseEvent->execution)) }}</td>
                        <td>{{$activeEvents->activeCourseEvent->course_event_schedules_count }}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <a class="btn btn-primary register_btn fw-medium mt-3"
                  href={{route('client.language.course.form')}}>@lang('client.announcement_section.register_btn')</a>
              </div>

            </div>
          </div>
        </div>
      </div>
      @endisset
  </section>
  @endisset

  <!-- Our Program -->
  @if ($programs)
  <section class="program mt-5" id="program">
    <div class="container">
      <div class="header-section text-center">
        <p class="head-title mb-2">@lang('client.program_section.head_title')</p>
        <h3 class="title-content">@lang('client.program_section.title_content')</h3>
      </div>
      <div class="body-content program-section mt-4 row row-gap-2 justify-content-center">
        @foreach ($programs as $program)
        <div
          class="activity-wrapper course-program text-decoration-none text-black py-2 rounded-3 col-12 col-sm-6 col-lg-4">
          <div class="activity-wrap p-3 rounded-2 h-100">
            <div class="img-wrapper w-100">
              <img src={{asset('storage/images/'.$program->image_name)}} alt="" class="img-fluid rounded-3" />
            </div>
            <div class="content-wrapper mt-2">
              <div class="content-title">
                <p class="mb-2 text-center">{{App::getLocale() == 'id' ? $program->title_indo :
                  $program->title_english}}
                </p>
              </div>
              <div class="content-desc text-center">{{App::getLocale() == 'id' ? $program->text_indo :
                $program->text_english}}</div>
            </div>
          </div>
        </div>
        @endforeach
      </div>
  </section>
  @endif

  <!-- Our Gallery -->
  @if ($gallery)
  <section class="gallery mt-5" id="gallery">
    <div class="container">
      <div class="header-section text-center">
        <p class="head-title mb-2">@lang('client.gallery_section.head_title')</p>
        <h3 class="title-content">@lang('client.gallery_section.title_content')</h3>
      </div>
      <div class="body-content mt-4">
        <div class="swiper mySwiper container">
          <div class="swiper-wrapper">
            @foreach ($gallery as $image)
            <div class="swiper-slide rounded-2">
              <img src="{{asset('storage/images/'.$image->file_name)}}" alt="" class=" img-fluid rounded-2" />
            </div>
            @endforeach
          </div>
          <div class="swiper-button-next"></div>
          <div class="swiper-button-prev"></div>
          <div class="swiper-pagination"></div>
        </div>
      </div>
    </div>
  </section>
  @endif

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
            <a class="text-decoration-none fs-3 text-black" target="blank"
              href="https://www.instagram.com/upabahasa/"><i class="bx bxl-instagram"></i></a>
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
  <script src={{asset('assets/js/clientScript.js')}}></script>
</body>

</html>