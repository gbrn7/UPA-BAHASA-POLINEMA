@extends('admin.layouts.base')

@section('content')
<div class="title-box  d-flex gap-2 align-items-baseline"><i class="ri-dashboard-line fs-2"></i>
  <p class="fs-3 m-0">Beranda</p>
</div>
<div class="breadcrumbs-box rounded rounded-2 bg-white p-2 mt-2">
  <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
    <ol class="breadcrumb m-0">
      <li class="breadcrumb-item d-flex gap-2 align-items-center"><i class="ri-apps-line"></i>UPA Bahasa</li>
      <li class="breadcrumb-item active" aria-current="page">Beranda</li>
    </ol>
  </nav>
</div>
<div class="content-box mt-3 rounded rounded-2 bg-white">
  <div class="content rounded rounded-2 border border-1 p-3">
    <div class="row mt-3 row-gap-2 row-cols-1 row-cols-md-2">
      <a href='#' class="card-dashboard text-decoration-none">
        <div class="card h-100">
          <div class="card-body  row justify-content-between align-items-center">
            <div class="card-body-content col-9">
              <h3 class="card-title">Data Produk</h3>
              <p class="card-text text-secondary fw-normal">Fitur ini digunakan untuk mengolah data produk seperti
                menambah, memperbarui, atau menghapus data produk.</p>
            </div>
            <div class="col-2 col-sm-3 d-flex justify-content-center img-menu">
              <i class="fs-1 ri-instance-line "></i>
            </div>
          </div>
        </div>
      </a>
      <a href='#' class="card-dashboard text-decoration-none">
        <div class="card h-100">
          <div class="card-body  row justify-content-between align-items-center">
            <div class="card-body-content col-9">
              <h3 class="card-title">Data Transaksi</h3>
              <p class="card-text text-secondary fw-normal">Fitur ini digunakan untuk mengolah data transaksi seperti
                memperbarui data transaksi.</p>
            </div>
            <div class="col-2 col-sm-3 d-flex justify-content-center img-menu"><i
                class="fs-1 ri-arrow-left-right-line me-2"></i>
            </div>
          </div>
        </div>
      </a>
      <a href='#' class="card-dashboard text-decoration-none">
        <div class="card h-100">
          <div class="card-body  row justify-content-between align-items-center">
            <div class="card-body-content col-9">
              <h3 class="card-title">Pemesanan Produk</h3>
              <p class="card-text text-secondary fw-normal">Pemesanan produk merupakan fitur yang digunakan untuk
                melakukan pemesanan produk.</p>
            </div>
            <div class="col-2 col-sm-3 d-flex justify-content-center img-menu"> <i class="fs-1 ri-survey-line"></i>
            </div>
          </div>
        </div>
      </a>
    </div>
  </div>
</div>
@endsection