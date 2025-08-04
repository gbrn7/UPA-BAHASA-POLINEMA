@extends('client.base')

@section('content')
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

<!-- News -->
@isset ($news)
<section class="news mt-5" id="news">
  <div class="container">
    <div class="header-section text-center">
      <p class="head-title mb-2">@lang('client.news_section.head_title')</p>
      <h3 class="title-content">@lang('client.news_section.title_content')</h3>
    </div>
    <div class="body-content program-section mt-4 row row-gap-2 justify-content-center">
      @foreach ($news as $item)
      <div class="activity-wrapper text-decoration-none text-black py-2  rounded-3 col-12 col-sm-6 col-lg-4">
        <a href="{{route('client.news.detail', $item->news_id)}}"
          class="activity-wrap text-decoration-none d-inline-block text-black p-3 rounded-2 h-100">
          <div class="img-wrapper w-100">
            <img src={{asset('storage/news_thumbnail/'.$item->thumbnail)}} alt="" class="img-fluid rounded-3" />
          </div>
          <div class="content-wrapper mt-2">
            <div class="content-title">
              <p class="mb-2 text-center">{{$item->title}}</p>
            </div>
            <div class="content-desc text-center">{{$item->created_at_human}}</div>
          </div>
        </a>
      </div>
      @endforeach
      <a href="{{route('client.news')}}" class="text-decoration-none text-center">Selanjutnya <i
          class="ri-arrow-right-wide-line"></i></a>
    </div>
</section>
@endisset


<!-- Our Program -->
@isset ($programs)
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
@endisset

<!-- Our Gallery -->
@isset ($gallery)
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
@endisset
@endsection

@section('js')
<script src={{asset('assets/js/clientScript.js')}}></script>
@endsection