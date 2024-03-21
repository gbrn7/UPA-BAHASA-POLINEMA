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
  <section class="form vh-100">
    <div class="container h-100 d-flex p-3 flex-column justify-content-start align-items-center">
      <a class="navbar-brand d-flex" href={{route('client')}}>
        <div class="img-wrapper">
          <img src={{asset('assets/images/POLINEMA.png')}} class="img-logo img-fluid" />
        </div>
        <div class="title-wrapper d-flex flex-column justify-content-center ms-2">
          <p class="mb-1 fw-medium">UPA BAHASA</p>
          <p class="mb-0 fw-medium">POLITEKNIK NEGERI MALANG</p>
        </div>
      </a>
      <div class="col-12 col-lg-10 mt-4">
        <form action="#">
          <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Nama Lengkap</label>
            <input type="Text" class="form-control" placeholder="Masukkan nama anda" />
          </div>
          <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">NIK (Nomor Induk Kependudukan)</label>
            <input type="Text" class="form-control" placeholder="Masukkan NIM anda" />
          </div>
          <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">NIM</label>
            <input type="Text" class="form-control" placeholder="Masukkan NIM anda" />
          </div>
          <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Jurusan</label>
            <select class="form-select" aria-label="Default select example">
              <option selected>Open this select menu</option>
              <option value="1">Teknik Elektro</option>
              <option value="1">Teknik Mesin</option>
              <option value="1">Teknologi Informasi</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Program Studi</label>
            <select class="form-select" aria-label="Default select example">
              <option selected>Open this select menu</option>
              <option value="1">D4 Sistem Informasi Bisnis</option>
              <option value="1">D4 Teknik Informatik</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Semester</label>
            <select class="form-select" aria-label="Default select example">
              <option selected>Open this select menu</option>
              <option value="4">4</option>
              <option value="6">6</option>
              <option value="8">8</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Email</label>
            <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="Masukkan email anda" />
          </div>
          <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">No WA</label>
            <input type="number" class="form-control" id="exampleFormControlInput1"
              placeholder="Masukkan no telepon anda" />
          </div>
          <div class="mb-3">
            <label for="formFile" class="form-label">KTP</label>
            <input class="form-control" type="file" id="formFile">
          </div>
          <div class="mb-3">
            <label for="formFile" class="form-label">KTM</label>
            <input class="form-control" type="file" id="formFile">
          </div>
          <div class="mb-3">
            <label for="formFile" class="form-label">Surat Pernyataan Nominasi IISMA (dari KPS)</label>
            <input class="form-control" type="file" id="formFile">
          </div>
          <div class="mb-3">
            <label for="formFile" class="form-label">Pas Foto</label>
            <input class="form-control" type="file" id="formFile">
          </div>

          <div class="mb-3">
            <button type="submit" class="btn btn-primary w-100 fw-medium">
              Submit
            </button>
          </div>
        </form>
      </div>
    </div>
  </section>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <script src={{asset('assets/js/script.js')}}></script>
</body>

</html>