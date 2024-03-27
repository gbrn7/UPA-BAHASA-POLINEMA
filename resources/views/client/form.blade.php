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
      <form action={{route('client.form.registration')}} class="form" method="POST" enctype="multipart/form-data">
        <div class="col-12 text-center">
          <h3 class="mt-2 fw-semibold">Form Pendaftaran TOEIC</h3>
        </div>
        <div class="col-12 mt-4 d-lg-flex gap-2 justify-content-between">
          @csrf
          <div class="col-12 col-lg-6">
            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label">Nama Lengkap</label>
              <input required type="Text" name="name" value="{{old('name')}}" class="form-control"
                placeholder="Masukkan nama anda" />
            </div>
            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label">NIM</label>
              <input required name="nim" type="Text" class="form-control" placeholder="Masukkan NIM anda"
                value="{{old('nik')}}" />
            </div>
            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label">NIK (Nomor Induk Kependudukan)</label>
              <input required name="nik" type="Text" class="form-control" placeholder="Masukkan NIK anda"
                value="{{old('nik')}}" />
            </div>
            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label">Jurusan</label>
              <select name="departement" required id="jurusan-select" class="form-select"
                aria-label="Default select example">
                <option value="">Pilih Jurusan anda</option>
                @foreach ($departements as $departement)
                <option value="{{$departement->departement_id}}" {{old('departement')===$departement->name ? 'selected'
                  :
                  ''}}>
                  {{$departement->name}}</option>
                @endforeach
              </select>
            </div>
            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label">Program Studi</label>
              <select name="program_study" required class="form-select" aria-label="Default select example">
                <option value="">Pilih jurusan anda terlebih dahulu</option>
              </select>
            </div>
            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label">Semester</label>
              <select required name="semester" class="form-select" aria-label="Default select example">
                <option value="">Pilih Semester anda</option>
                <option value="4" {{old('semester')==='4' ? ' selected' : '' }}>4</option>
                <option value="6" {{old('semester')==='6' ? ' selected' : '' }}>6</option>
                <option value="8" {{old('semester')==='8' ? ' selected' : '' }}>8</option>
              </select>
            </div>
          </div>
          <div class="col-12 col-lg-6">
            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label">Email</label>
              <input required type="email" class="form-control" id="exampleFormControlInput1"
                placeholder="Masukkan email anda" name="email" value="{{old('email')}}" />
            </div>
            <div class="mb-3">
              <label for="exampleFormControlInput1" class="form-label">No WA</label>
              <input required type="number" class="form-control" id="exampleFormControlInput1"
                placeholder="Masukkan no telepon anda" name="phone_num" value="{{old('phone_num')}}" />
            </div>
            <div class="mb-3">
              <label for="formFile" class="form-label">Foto KTP</label>
              <input required class="form-control" type="file" id="formFile" name="ktp_img" value="{{old('ktp_img')}}">
            </div>
            <div class="mb-3">
              <label for="formFile" class="form-label">Foto KTM</label>
              <input required class="form-control" type="file" id="formFile" name="ktm_img" value="{{old('ktm_img')}}">
            </div>
            <div class="mb-3">
              <label for="formFile" class="form-label">Surat Pernyataan Nominasi IISMA (dari KPS)</label>
              <input required class="form-control" type="file" id="formFile" name="surat_pernyataan_iisma"
                value="{{old('surat_penyataan_iisma')}}">
            </div>
            <div class="mb-3">
              <label for="formFile" class="form-label">Pas Foto</label>
              <input required class="form-control" type="file" id="formFile" name="pasFoto_img"
                value="{{old('pasFoto_img')}}">
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