@section('title')
    Novinky | Bobrovo
@endsection

@include('general.header')

<main id="root" class="pt-5 pb-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-12">
                <h1>Novinky</h1>
                <div class="row pt-3">
                    @foreach($newsFeed as $news)
                        <div class="col-md-12 pb-4">
                            <div class="card mb-2 equal-height border-bobrovo-green">
                                @if(!empty($news->featured_img))
                                    <img src="{{$news->featured_img}}" alt="news featured img" class="card-img-top">
                                @endif
                                <div class="card-body">
                                    <h5 class="card-title">{{ $news->title }}</h5>
                                    <p class="card-text text-muted">{{ $news->created_at }}</p>
                                </div>
                                <div class="card-body pt-0">
                                    <a href="{{ route('general.news.show', $news) }}"
                                       class="btn btn-sm btn-success">Pozrieť <i class="far fa-eye"></i></a>
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
