@extends('student.master')

@section('title')
    Test | Bobrovo
@endsection

@section('content')

<div class="container">
    <div class="row">
        <div class="col-lg-5 pt-4">
                <h3>Stránka testu</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="card mt-2 border-primary">
                <div class="card-header bg-primary text-white">
                    Názov
                </div>
                <div class="card-body">
                    <h4 class="card-title mb-0">{{ $test->name }}</h4>
                </div>
            </div>

            <div class="card mt-3 border-secondary">
                <div class="card-header bg-secondary text-white">
                    Popis
                </div>
                <div class="card-body">
                    {!! $test->description !!}
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="card mt-3 border-info">
                        <div class="card-header bg-info text-white">
                            Dostupný od
                        </div>
                        <div class="card-body">
                            <p class="card-text">{{ $test->available_from }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="card mt-3 border-info">
                        <div class="card-header bg-info text-white">
                            Dostupný do
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
                    Stav
                </div>
                <div class="card-body">
                    <p class="card-text">
                        @php
                            if (empty($state) || $state->state == 1){
                                echo 'Nezačatý';
                            }
                            else if ($state->state == 2){
                                echo 'Začatý';
                            }
                            else{
                                echo 'Dokončený';
                            }
                        @endphp
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 pt-3 pb-3">
            @if (empty($state) || $state->state != 3)
                <a href="{{ route('solving_student', ['id' => $test->id]) }}" class="btn btn-primary">
                    <i class="fas fa-pencil-alt"></i> Začni riešiť
                </a>
            @endif
            @if (!empty($state) && $state->state == 3)
                <a href="{{ route('results_student', ['id' => $test->id]) }}" class="btn btn-success">
                    <i class="far fa-check-square"></i> Pozri výsledky
                </a>
            @endif
        </div>
    </div>
</div>   

@endsection
