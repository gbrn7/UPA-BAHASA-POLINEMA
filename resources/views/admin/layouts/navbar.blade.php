<nav class="navbar navbar-expand-md">
  <div class="container-fluid">
    <div class="d-flex justify-content-between d-block d-lg-none">
      <a class="navbar-brand fs-5" href="#">UPA BAHASA POLINEMA</a>
      <button class="btn px-1 py-0 open-btn">
        <i class="fas fa-stream"></i>
      </button>
    </div>
    <div class="profile-wrap">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    </div>
    <div class="collapse navbar-collapse justify-content-end gap-3" id="navbarSupportedContent">
      <div class="dropdown">
        <a class="nav-link d-flex gap-2 pt-3 pt-md-0 align-items-center justify-content-end dropdown-toggle" href="#"
          role="button" aria-current="page" data-bs-toggle="dropdown" aria-expanded="false">
          <p class="my-0">{{auth()->user()->name}}</p>
          <img src={{asset('assets/images/default.png')}} class="img-fluid img-avatar ">
        </a>
        <ul class="dropdown-menu dropdown-menu-end px-2">
          <li class="rounded-2 dropdown-list"> <a href={{route('admin.editProfile')}} class="dropdown-item rounded-2"><i
                class="ri-profile-line me-2"></i>Edit Profil</a>
          </li>
          <li class="rounded-2 dropdown-list"> <a href={{route('admin.logout')}} class="dropdown-item rounded-2"><i
                class="ri-logout-circle-line me-2"></i>Sign
              Out</a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</nav>

<!-- Profile Modal -->
<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" class="p-0">
  <form action="#" id="profileForm" method="POST">
    @method('put')
    <div class="modal-dialog ">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="myModalLabel">Profile Saya</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-center">
          <div class="spinner-border text-black" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>


@push('js')
<script>
  function imageHandler(input) {
    const img = document.querySelector('.img-avatar-create')
    const file =input.files[0]; 
    let url = window.URL.createObjectURL(file);

    img.src =url;
  };

  function updateImageHandler(input) {
    const img = document.querySelector('.img-avatar-update')
    const file =input.files[0]; 
    let url = window.URL.createObjectURL(file);

    img.src =url;
  };      

</script>
@endpush