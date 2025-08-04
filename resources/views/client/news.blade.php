@extends('client.base')

@section('content')
<section class="news mt-5">
  <div class="container">
    <div class="header-wrapper">
      <p class="h2 text-center fw-bold">
        @lang('client.navbar.news')
      </p>
    </div>
    <div class="news-wrapper row row-cols-1 row-cols-sm-2 row-cols-md-3">
      @forelse ($news as $item)
      <a href="{{route('client.news.detail', $item->news_id)}}"
        class="col text-decoration-none p-1 text-black text-center align-items-center">
        <div class="news-wrap border rounded-2">
          <div class="thumbnail-wrapper p-1">
            <img class="img-fluid rounded" src="{{asset('storage/news_thumbnail/'.$item->thumbnail)}}" alt="thumbnail">
          </div>
          <div class="text-wrapper">
            <p class="title fw-bold mb-1">{{$item->title}}</p>
            <p class="date fw-light">{{$item->created_at_human}}</p>
          </div>
        </div>
      </a>
      @empty
      <p class="text-center fw-semibold text-secondary">Informasi Tidak Ditemukan</p>
      @endforelse
    </div>
    <div class="pagination-box d-flex justify-content-end">
      {{$news->links('pagination::simple-bootstrap-5')}}
    </div>
  </div>
</section>
@endsection