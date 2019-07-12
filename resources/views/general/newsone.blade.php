@section('title')
    {{ $news->title }} | Bobrovo
@endsection

@include('general.header')

<main id="root" class="pt-5 pb-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-12">
                <h1>{{ $news->title }}</h1>
                <p class="text-muted"></p>
                <div class="content">
                    {!! $news->content !!}
                </div>
            </div>
        </div>
    </div>
</main>


@include('general.footer')
