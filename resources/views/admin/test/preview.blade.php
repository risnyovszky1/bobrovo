@extends('admin.master')


@section('admin_content')
    <div class="admin-panel pt-2 pb-2">
        <div class="row">
            <div class="col-lg-8">
                <h1>Náhľad testu: <strong>{{ $test->name }}</strong></h1>

                @foreach ($test->questions as $item)
                    <div class="card border-secondary mb-4 shadow mt-2">
                        <div class="card-header text-white bg-secondary">
                            {{ $item->title }}
                        </div>
                        <div class="card-body">
                            {!! $item->question !!}
                        </div>
                    </div>


                    @switch($item->type)
                        @case(5)
                        <div class="bg-white border rounded border-danger mb-2 pl-3 pr-3 pt-2 pb-2 shadow">
                            INTERACTIVE
                        </div>
                        @break
                        @case(4)
                        <div class="bg-white border rounded border-primary mb-2 pl-3 pr-3 pt-2 pb-2 shadow">
                            <img src="{{ $item->a }}" alt="" class="d-inline-block">
                        </div>
                        <div class="bg-white border rounded border-primary mb-2 pl-3 pr-3 pt-2 pb-2 shadow">
                            <img src="{{ $item->b }}" alt="" class="d-inline-block">
                        </div>
                        <div class="bg-white border rounded border-primary mb-2 pl-3 pr-3 pt-2 pb-2 shadow">
                            <img src="{{ $item->c }}" alt="" class="d-inline-block">
                        </div>
                        <div class="bg-white border rounded border-primary mb-2 pl-3 pr-3 pt-2 pb-2 shadow">
                            <img src="{{ $item->d }}" alt="" class="d-inline-block">
                        </div>
                        @break
                        @default
                        <div class="bg-white border rounded border-primary mb-2 pl-3 pr-3 pt-2 pb-2 shadow">
                            {{ $item->a }}
                        </div>
                        <div class="bg-white border rounded border-primary mb-2 pl-3 pr-3 pt-2 pb-2 shadow">
                            {{ $item->b }}
                        </div>
                        <div class="bg-white border rounded border-primary mb-2 pl-3 pr-3 pt-2 pb-2 shadow">
                            {{ $item->c }}
                        </div>
                        <div class="bg-white border rounded border-primary mb-2 pl-3 pr-3 pt-2 pb-2 shadow">
                            {{ $item->d }}
                        </div>
                    @endswitch
                    <hr>
                @endforeach

            </div>
        </div>
    </div>
@endsection
