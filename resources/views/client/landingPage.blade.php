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
      <a class="navbar-brand d-flex" href="#">
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
          <a class="nav-link" aria-current="page" href="#home">Home</a>
          @isset($activeEvent)
          <a class="nav-link" href="#announcement">Announcement</a>
          @endisset
          <a class="nav-link" href="#program">Our Program</a>
          <a class="nav-link" href="#gallery">Our Gallery</a>
        </div>
      </div>
    </div>
  </nav>

  <!-- Home -->
  <section class="home mt-5" id="home">
    <div class="container">
      <div class="row align-items-center">
        <div class="header-section col-12 col-lg-7 text-center text-lg-start">
          <h4 class="title-head fw-bold">
            UPA BAHASA <br />
            <span class="mt-1">POLITEKNIK NEGERI MALANG</span>
          </h4>
          <div class="desc-content">
            UPT Bahasa merupakan salah satu unit kerja di Politeknik Negeri
            Malang, dan, dengan demikian, juga bertanggung jawab untuk
            mendukung visi, misi dan tujuan Politeknik Negeri Malang. Berbagai
            kegiatan yang dilakukan UPT Bahasa selama ini adalah
            kegiatan-kegaitan yang sebagian besar berkaitan dengan kebahasaan.
          </div>
        </div>
        <div class="col-12 col-lg-5 mt-3 mt-lg-0">
          <img src={{asset('assets/images/home-hero.png')}} alt="" class="img-fluid rounded-5" />
        </div>
      </div>
    </div>
  </section>

  @isset($activeEvent)
  <!-- Announcement -->
  <section class="announcement mt-5" id="announcement">
    <div class="container">
      <div class="header-section text-center">
        <p class="head-title mb-2">Announcement</p>
        <h3 class="title-content">Pengumuman</h3>
      </div>
      <div class="body-section mt-2 row justify-content-center">
        <div class="col-lg-10 col-12 rounded rounded-2">
          <p class="text-center">
            Polteknik Negeri Malang membuka Tes Kompetensi Bahasa Inggris TOIEC. Tes
            ini bertujuan untuk mengukur kemampuan bahasa Inggris para
            mahasiswa dan memberikan sertifikat sebagai bukti kompetensi
          </p>
          <div class="info-wrapper p-3 row bg-white rounded-3">
            <div class="info p-3 rounded-2 text-center">
              <div class="schedule-wrapper">
                <p class="mb-2"><strong>Jadwal Kegiatan : </strong></p>
                <p class="mb-1">Pendaftaran : {{date("d M Y", strtotime($activeEvent->register_start)) }} - {{date("d M
                  Y", strtotime($activeEvent->register_end)) }}
                </p>
                <p>Pelaksanaan Tes : {{date("d M Y", strtotime($activeEvent->execution)) }}</p>
              </div>
              <div class="quota">
                <p class="mb-2"><strong>Kuota : </strong></p>
                <p class="mb-1">{{$activeEvent->quota}} Orang</p>
              </div>
              <div class="quota">
                <p class="mb-2"><strong>Sisa Kuota : </strong></p>
                <p class="mb-1">{{$activeEvent->remaining_quota}} Orang</p>
              </div>
              <a class="btn btn-primary fw-medium mt-3" href={{route('client.form')}}>Daftar Sekarang</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  @endisset

  <!-- Our Program -->
  <section class="program mt-5" id="program">
    <div class="container">
      <div class="header-section text-center">
        <p class="head-title mb-2">Our Program</p>
        <h3 class="title-content">Program Kami</h3>
      </div>
      <div class="body-content mt-4 row row-gap-2 justify-content-center">
        <div class="activity-wrapper py-2 rounded-3 col-12 col-sm-6 col-lg-4">
          <div class="activity-wrap p-3 rounded-2 h-100">
            <div class="img-wrapper w-100">
              <img src={{asset('assets/images/nguyen-dang-hoang-nhu-6u1nVonp4fY-unsplash.jpg')}} alt=""
                class="img-fluid rounded-3" />
            </div>
            <div class="content-wrapper mt-2">
              <div class="content-title">
                <p class="mb-2 text-center">English Competence Tests</p>
              </div>
              <div class="content-desc text-center">
                Kegiatan ini merupakan kegiatan tahunan ujian Bahasa Inggris
                untuk mahasiswa di Politeknik Negeri Malang. Tes yang
                diberikan adalah TOEIC (Test of English for International
                Communication) dan PECT (Polytechnic English Competence Test)
              </div>
            </div>
          </div>
        </div>
        <div class="activity-wrapper py-2 rounded-3 col-12 col-sm-6 col-lg-4">
          <div class="activity-wrap p-3 rounded-2 h-100">
            <div class="img-wrapper w-100">
              <img src={{asset('assets/images/competition.jpg')}} alt="" class="img-fluid rounded-3" />
            </div>
            <div class="content-wrapper mt-2">
              <div class="content-title">
                <p class="mb-2 text-center">
                  Lomba Bahasa Inggris tingkat mahasiswa
                </p>
              </div>
              <div class="content-desc text-center">
                Kegiatan ini untuk menjaring mahasiswa yang mempunyai
                kompetensi Bahasa Inggris yang unggul dan dapat diikutsertakan
                dalam lomba-lomba tingkat nasional seperti National
                Polytechnic English Olympics (NPEO).
              </div>
            </div>
          </div>
        </div>
        <div class="activity-wrapper py-2 rounded-3 col-12 col-sm-6 col-lg-4">
          <div class="activity-wrap p-3 rounded-2 h-100">
            <div class="img-wrapper w-100">
              <img src={{asset('assets/images/seminar.jpg')}} alt="" class="img-fluid rounded-3" />
            </div>
            <div class="content-wrapper mt-2">
              <div class="content-title">
                <p class="mb-2 text-center">
                  Seminar Nasional dan Internastional
                </p>
              </div>
              <div class="content-desc text-center">
                UPT Bahasa memiliki tiga seminar tahunan, yaitu Seminar
                Nasional Industri Bahasa (SNIB) dan Seminar Nasional Bahasa
                dan Sastra (Senabasa), sedangkan untuk seminar tingkat
                internasional, UPT Bahasa menyelenggarakan kegiatan
                International Virtual Conference on Language and Literature
                (IVICOL).
              </div>
            </div>
          </div>
        </div>
        <div class="activity-wrapper py-2 rounded-3 col-12 col-sm-6 col-lg-4">
          <div class="activity-wrap p-3 rounded-2 h-100">
            <div class="img-wrapper w-100">
              <img src={{asset('assets/images/dharmamahasiswa.jpg')}} alt="" class="img-fluid rounded-3" />
            </div>
            <div class="content-wrapper mt-2">
              <div class="content-title">
                <p class="mb-2 text-center">Dharmasiswa</p>
              </div>
              <div class="content-desc text-center">
                Kegiatan ini merupakan kegiatan tahunan yang dlakukan oleh UPT
                Bahasa dengan tujuan mengenalkan dan memberikan pengalaman
                berbahasa Indonesia kepada mahasiswa asing. Program ini tidak
                berhenti menerima mahasiswa asing dalam masa pandemi.
              </div>
            </div>
          </div>
        </div>
        <div class="activity-wrapper py-2 rounded-3 col-12 col-sm-6 col-lg-4">
          <div class="activity-wrap p-3 rounded-2 h-100">
            <div class="img-wrapper w-100">
              <img src={{asset('assets/images/benchmark.jpg')}} alt="" class="img-fluid rounded-3" />
            </div>
            <div class="content-wrapper mt-2">
              <div class="content-title">
                <p class="mb-2 text-center">
                  Benchmarking dengan Politeknik dan Perguruan Tinggi Lain
                </p>
              </div>
              <div class="content-desc text-center">
                Benchmarking dilakukan untuk mempelajari program dan kinerja
                dari institusi lain guna pengembangan program dan kinerja dari
                UPT Bahasa.
              </div>
            </div>
          </div>
        </div>
        <div class="activity-wrapper py-2 rounded-3 col-12 col-sm-6 col-lg-4">
          <div class="activity-wrap p-3 rounded-2 h-100">
            <div class="img-wrapper w-100">
              <img src={{asset('assets/images/interview.jpg')}} alt="" class="img-fluid rounded-3" />
            </div>
            <div class="content-wrapper mt-2">
              <div class="content-title">
                <p class="mb-2 text-center">Workshop Job Interview</p>
              </div>
              <div class="content-desc text-center">
                Kegiatan ini bertujuan untuk meningkatkan kemampuan mahasiswa
                dalam memasuki dunia kerja, baik pada saat menghadapi proses
                rekruitmen maupun penyipan akselerasi karir setelah diterima
                di tempat kerja.
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Our Gallery -->
  <section class="gallery mt-5" id="gallery">
    <div class="container">
      <div class="header-section text-center">
        <p class="head-title mb-2">Our Gallery</p>
        <h3 class="title-content">Galeri Kegiatan</h3>
      </div>
      <div class="body-content mt-4">
        <div class="swiper mySwiper container">
          <div class="swiper-wrapper">
            <div class="swiper-slide rounded-2">
              <img src={{asset('assets/images/img-1.jpg')}} alt="" class="img-fluid rounded-2" />
            </div>
            <div class="swiper-slide rounded-2">
              <img src={{asset('assets/images/img-2.jpg')}} alt="" class="img-fluid rounded-2" />
            </div>
            <div class="swiper-slide rounded-2">
              <img src={{asset('assets/images/img-3.jpg')}} alt="" class="img-fluid rounded-2" />
            </div>
            <div class="swiper-slide rounded-2">
              <img src={{asset('assets/images/img-4.jpg')}} alt="" class="img-fluid rounded-2" />
            </div>
          </div>
          <div class="swiper-button-next"></div>
          <div class="swiper-button-prev"></div>
          <div class="swiper-pagination"></div>
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
            <p class="desc-brand">
              Jl. Soekarno Hatta No.9, Jatimulyo, Kec. Lowokwaru, Kota Malang,
              Jawa Timur 65141
            </p>
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
          <p class="title">Link Terkait</p>
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