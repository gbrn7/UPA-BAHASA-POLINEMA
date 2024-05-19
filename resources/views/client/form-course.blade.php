<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Form Pendaftaran</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href={{asset('assets/style/form-style.css')}} />

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

  <div class="loader-wrapper d-none h-100 w-100 position-fixed d-flex justify-content-center align-items-center">
    <div class="loader"></div>
  </div>

  <section class="form mb-3">
    <div class="container  h-100 d-flex p-3 flex-column justify-content-start align-items-center">
      <div class="header-wrapper pb-3 border-bottom w-100 d-flex justify-content-center">
        <a class="navbar-brand d-flex pt-3" href={{route('client')}}>
          <div class="img-wrapper">
            <img src={{asset('assets/images/POLINEMA.png')}} class="img-logo img-fluid" />
          </div>
          <div class="title-wrapper d-flex flex-column justify-content-center ms-2">
            <p class="mb-1 fw-medium">UPA BAHASA</p>
            <p class="mb-0 fw-medium">POLITEKNIK NEGERI MALANG</p>
          </div>
        </a>
      </div>
      <form action={{route('client.form.saveCourseEventRegistration')}} class="form w-100 mt-2" method="POST"
        enctype="multipart/form-data">
        <div class="col-12 d-flex justify-content-between">
          <h5 class="mt-2 fw-semibold title">@lang('form.title.language_course')</h5>
          <div class="dropdown">
            <i class="ri-earth-line nav-link dropdown-toggle d-flex gap-2 align-items-center" role="button"
              data-bs-toggle="dropdown" aria-expanded="false"></i>
            <ul class="dropdown-menu">
              <li class="px-1"><a class="dropdown-item rounded rounded-2"
                  href="{{route('client.language.course.form', ['lang'=> 'id'])}}">Indonesian</a></li>
              <li class="px-1"><a class="dropdown-item rounded rounded-2"
                  href="{{route('client.language.course.form', ['lang'=> 'en'])}}">English</a></li>
            </ul>
          </div>
        </div>
        <div class="col-12 overflow-auto">
          <div class="table-wrapper table-content mt-2 mb-2">
            <table id="example" class="table mt-3 table-hover" style="width: 100%">
              <thead>
                <tr>
                  <th class="text-secondary batch">
                    @lang('client.announcement_section.language_course.detail_course_table_content.num')</th>
                  <th class="text-secondary registration-date">
                    @lang('client.announcement_section.language_course.detail_course_table_content.course_type')</th>
                  </th>
                  <th class="text-secondary registration-date">
                    @lang('client.announcement_section.language_course.detail_course_table_content.quota')</th>
                  </th>
                  <th class="text-secondary registration-date">
                    @lang('client.announcement_section.language_course.detail_course_table_content.remaining_quota')
                  </th>
                  <th class="text-secondary registration-date">
                    @lang('client.announcement_section.language_course.detail_course_table_content.day_name')</th>
                  </th>
                  <th class="text-secondary registration-date">
                    @lang('client.announcement_section.language_course.detail_course_table_content.time')</th>
                  </th>
                  </th>
                  <th class="text-secondary registration-date">
                    @lang('client.announcement_section.language_course.detail_course_table_content.information')</th>
                  </th>
                </tr>
              </thead>
              <tbody id="tableBody">
                @foreach ($activeEvent->courseEventSchedules as $activeSchedule)
                <tr>
                  <td>{{$loop->iteration}}</td>
                  <td>{{$activeSchedule->courseType->name}}</td>
                  <td>{{$activeSchedule->quota}}</td>
                  <td>{{$activeSchedule->remaining_quota}}</td>
                  <td>{{$activeSchedule->day_name}}</td>
                  <td>{{date("H:i", strtotime($activeSchedule->time_start))}} - {{date("H:i",
                    strtotime($activeSchedule->time_end))}}</td>
                  <td>{{$activeSchedule->information}}</td>

                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
        <div class="col-12 mt-4 d-lg-flex gap-2 justify-content-between">
          @csrf
          <div class="col-12 col-lg-6">
            <div class="mb-3">
              <label class="form-label">@lang('form.name.label')</label>
              <input required type="Text" name="name" value="{{old('name')}}" class="form-control"
                placeholder="@lang('form.name.placeholder')"" />
            </div>
            <div class=" mb-3">
              <label class="form-label">@lang('form.email.label')</label>
              <input required type="email" class="form-control" placeholder="@lang('form.email.placeholder')"
                name="email" value="{{old('email')}}" />
            </div>
            <div class="mb-3">
              <label class="form-label">@lang('form.wa_number.label')</label>
              <input required type="number" class="form-control" placeholder="@lang('form.wa_number.placeholder')"
                name="phone_num" value="{{old('phone_num')}}" />
            </div>
            <div class="mb-3">
              <label class="form-label">@lang('form.address.label')</label>
              <input required type="text" class="form-control" placeholder="@lang('form.address.placeholder')"
                name=" address" value="{{old('address')}}" />
            </div>
          </div>
          <div class="col-12 col-lg-6">
            <div class="mb-3">
              <label class="form-label">@lang('form.course.label')</label>
              <select required name="course" class="form-select">
                <option value="">@lang('form.course.placeholder')</option>
                @foreach ($activeEvent->courseEventSchedules as $activeSchedule)
                <option value="{{$activeSchedule->course_event_schedule_id}}"
                  @selected(old('course')===$activeSchedule->
                  course_event_schedule_id)>{{$activeSchedule->courseType->name}} - {{$activeSchedule->day_name}}
                  - ({{date("H:i", strtotime($activeSchedule->time_start))}} - {{date("H:i",
                  strtotime($activeSchedule->time_end))}}) </option>
                @endforeach
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">@lang('form.goal.label')</label>
              <input required type="text" class="form-control" placeholder=@lang('form.goal.placeholder') name="goal"
                value="{{old('goal')}}" />
            </div>
            <div class="mb-3">
              <label class="form-label">@lang('form.experience.label')</label>
              <input required type="text" class="form-control" placeholder="@lang('form.experience.placeholder')"
                name=" experience" value="{{old('experience')}}" />
            </div>
            <div class="mb-3">
              <label for="formFile" class="form-label">@lang('form.identity_card_image')</label>
              <input required class="form-control" type="file" id="formFile" name="ktp_or_passport_img">
            </div>
          </div>
        </div>
        <div class=" mb-3 text-center">
          <button type="submit" class="btn btn-primary submit-btn w-100 fw-medium">
            Submit
          </button>
        </div>
      </form>
    </div>
  </section>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  {{-- jquery --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  <script>
    const form = document.querySelector(".form");
    form.addEventListener('submit', function () {
      document.querySelector("html").style.cursor = "wait";
      document.querySelector(".loader-wrapper").classList.remove('d-none');
    });

    function startLoading()
    {
      document.querySelector(".loader-wrapper").classList.remove('d-none');
      document.querySelector("html").style.cursor = "wait";
    }

    function endLoading()
    {
      document.querySelector(".loader-wrapper").classList.add('d-none');
      document.querySelector("html").style.cursor = "default";
    }

    $('#jurusan-select').change(function (e) { 
      e.preventDefault();
      DepartementId = this.value;

      startLoading();

      $.ajax({
        type: "Get",
        url: "{{route('client.getProgramStudy')}}",
        data: {
          "_token": "{{csrf_token()}}",
          "departement_id" : DepartementId
        },
        success: function (res, status) {
          if(res.data.length > 0){
            $('select[name="program_study"]').empty();
            res.data.forEach(e => {
              $('select[name="program_study"]').append(`<option value="${e.name}">${e.name}</option>`);
            })
          }else{
            $('select[name="program_study"]').empty().append(`<option value="">Program studi tidak ditemukan</option>`);
          }
        }

      });
      endLoading();
    });

  </script>

</body>

</html>