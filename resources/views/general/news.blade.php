@section('title')
  Novinky | Bobrovo
@endsection

@include('general.header')

<main id="root" class="pt-5 pb-5">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 col-md-12">
        <h1>Novinky</h1>
        <div class="row pt-3">
        @foreach($newsFeed as $news)
          <div class="col-md-6 col-lg-4 pb-4">
            <div class="card mb-2 equal-height border-bobrovo-green">
              <div class="card-body">
                <h5 class="card-title">{{ $news->title }}</h5>
                <p class="card-text text-muted">{{ $news->created_at }}</p>
              </div>
              <div class="card-body text-center pt-0">
                <a href="{{ route('newsonepage', ['news_id' => $news->news_id]) }}" class="btn btn-sm btn-success">Pozrieť <i class="far fa-eye"></i></a>
              </div>
            </div>
          </div>
        @endforeach
        </div>
      </div>
    </div>
  </div>
</main>


@include('general.footer')
