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
      <a class="navbar-brand d-flex pt-3" href={{route('client')}}>
        <div class="img-wrapper">
          <img src={{asset('assets/images/POLINEMA.png')}} class="img-logo img-fluid" />
        </div>
        <div class="title-wrapper d-flex flex-column justify-content-center ms-2">
          <p class="mb-1 fw-medium">UPA BAHASA</p>
          <p class="mb-0 fw-medium">POLITEKNIK NEGERI MALANG</p>
        </div>
      </a>
      <div class="col-12 col-lg-10 mt-4">
        <form action={{route('admin.form.registration')}} class="form" method="POST" enctype="multipart/form-data">
          @csrf
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
            <select name="departement" required class="form-select" aria-label="Default select example">
              <option value="">Open this select menu</option>
              @foreach ($departements as $departement)
              <option value="{{$departement->name}}" {{old('departement')===$departement->name ? 'selected' : ''}}>
                {{$departement->name}}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Program Studi</label>
            <select name="program_study" required class="form-select" aria-label="Default select example">
              <option value="">Open this select menu</option>
              @foreach ($prodys as $prody)
              <option value="{{$prody->name}}" {{old('program_study')===$prody->name ? 'selected' :
                ''}}>{{$prody->name}}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Semester</label>
            <select required name="semester" class="form-select" aria-label="Default select example">
              <option value="">Open this select menu</option>
              <option value="4" {{old('semester')==='4' ? ' selected' : '' }}>4</option>
              <option value="6" {{old('semester')==='6' ? ' selected' : '' }}>6</option>
              <option value="8" {{old('semester')==='8' ? ' selected' : '' }}>8</option>
            </select>
          </div>
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
            <label for="formFile" class="form-label">KTP</label>
            <input required class="form-control" type="file" id="formFile" name="ktp_img" value="{{old('ktp_img')}}">
          </div>
          <div class="mb-3">
            <label for="formFile" class="form-label">KTM</label>
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

          <div class=" mb-3">
            <button type="submit" class="btn btn-primary submit-btn w-100 fw-medium">
              Submit
            </button>
          </div>
        </form>
      </div>
    </div>
  </section>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

  <script>
    const form = document.querySelector(".form");
    form.addEventListener('submit', function () {
      document.querySelector("html").style.cursor = "wait";
      document.querySelector(".loader-wrapper").classList.remove('d-none');
    });
  </script>

</body>

</html>