@extends('student.master')

@section('title')
    Test | Bobrovo
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-5 pt-4">
                <h3>{{ __('student.test-page') }}</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="card mt-2 border-primary">
                    <div class="card-header bg-primary text-white">
                        {{ __('student.title') }}
                    </div>
                    <div class="card-body">
                        <h4 class="card-title mb-0">{{ $test->name }}</h4>
                    </div>
                </div>

                <div class="card mt-3 border-secondary">
                    <div class="card-header bg-secondary text-white">
                        {{ __('student.description') }}
                    </div>
                    <div class="card-body">
                        {!! $test->description !!}
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="card mt-3 border-info">
                            <div class="card-header bg-info text-white">
                                {{ __('student.available_from') }}
                            </div>
                            <div class="card-body">
                                <p class="card-text">{{ $test->available_from }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="card mt-3 border-info">
                            <div class="card-header bg-info text-white">
                                {{ __('student.available_to') }}
                            </div>
                            <div class="card-body">
                                <p class="card-text">{{ $test->available_to }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mt-2 border-danger">
                    <div class="card-header text-white bg-danger">
                        {{ __('student.state') }}
                    </div>
                    <div class="card-body">
                        <p class="card-text">
                            @php
                                if (empty($state) || $state->state == 1){
                                    echo __('student.not-started');
                                }
                                else if ($state->state == 2){
                                    echo __('student.in-progress');
                                }
                                else{
                                    echo __('student.done');
                                }
                            @endphp
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 pt-3 pb-3">
                @php
                    $currTime = strtotime(date('Y-m-d H:i:s'));
                @endphp
                @if ((empty($state) || $state->state != 3) && strtotime($test->available_from) < $currTime && strtotime($test->available_to) > $currTime)
                    <a href="{{ route('solving_student', ['id' => $test->id]) }}" class="btn btn-primary">
                        <i class="fas fa-pencil-alt"></i> {{ __('student.start_solve') }}
                    </a>
                @endif

                @if (!empty($state) && $state->state == 3)
                    <a href="{{ route('results_student', ['id' => $test->id]) }}" class="btn btn-success">
                        <i class="far fa-check-square"></i> {{ __('student.see-results') }}
                    </a>
                @endif
            </div>
        </div>
    </div>

@endsection
