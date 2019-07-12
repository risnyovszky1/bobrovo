@section('title')
    FAQ | Bobrovo
@endsection

@include('general.header')

<main id="root" class="pt-5 pb-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-12">
                <h1>FAQ</h1>
                @if(count($faqs) > 0)
                    <div id="faq-container" class="accordion mt-3">
                        <?php $count = 1; ?>
                        @foreach($faqs as $faq)
                            <div class="card">
                                <div class="card-header text-left">
                                    <h3 class="mb-0">
                                        <button class="btn btn-link btn-block text-left" type="button"
                                                data-toggle="collapse" data-target="#faq-{{ $count }}"
                                                aria-expanded="true" aria-controls="collapseOne">
                                            {{ $faq->question }}
                                        </button>
                                    </h3>
                                </div>
                                <div id="faq-{{ $count }}" class="collapse" aria-labelledby=""
                                     data-parent="#faq-container">
                                    <div class="card-body">
                                        {!! $faq->answer !!}
                                    </div>
                                </div>
                            </div>
                            <?php $count++; ?>
                        @endforeach
                    </div>
                @else
                    <p>Ešte nebolo žiadny FAQ pridaný na stránku.</p>
                @endif

            </div>
        </div>
    </div>
</main>


@include('general.footer')
