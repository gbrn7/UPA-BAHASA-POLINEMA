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
          <a class="text-decoration-none fs-3 text-black" target="blank" href="https://www.instagram.com/upabahasa/"><i
              class="bx bxl-instagram"></i></a>
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