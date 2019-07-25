@section('title')
    {{ $news->title }} | Bobrovo
@endsection

@include('general.header')

<main id="root" class="pt-5 pb-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-12">
                <h1>{{ $news->title }}</h1>
                <p class="text-muted">{{ $news->created_at }}</p>

                @if (!empty($news->featured_img))
                    <img src="{{ $news->featured_img }}" class="rounded d-block img-thumbnail mt-1 mb-4" alt="news featured img">
                @endif

                <div class="content">
                    {!! $news->content !!}
                </div>
            </div>
        </div>
    </div>
</main>


@include('general.footer')
