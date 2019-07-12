@extends('student.master')

@section('title')
    Testuj | Bobrovo
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-8 pt-3">
                <h3>Testuj</h3>

            </div>
        </div>

        <div class="row">
            <div class="col-md-8 pb-3">
                @if (!empty($state) && $state->state == 3)
                    <p>Test je už dokončený.</p>

                    <a href="{{ route('testone_student', ['id' => Session::get('testSettings')->id]) }}"
                       class="btn btn-primary">
                        <i class="fas fa-arrow-alt-circle-left"></i> Naspäť
                    </a>

                    <a href="{{ route('results_student', ['id' => Session::get('testSettings')->id]) }}"
                       class="btn btn-success">
                        <i class="far fa-check-square"></i> Pozri výsledky
                    </a>
                @else
                    <p class="text-muted">Veľa šťastia!</p>
                    <div class="card border-primary mb-3">
                        <div class="card-header bg-primary text-white">
                            Otázky
                        </div>
                        <ul class="list-group list-group-flush">
                            @php
                                $questions = Session::get('testQuestions');
                                for($i = 0; $i < count($questions); $i++){
                                    echo '<li class="list-group-item">';
                                        echo '<a href="'. route('question_student', ['id' => Session::get('testSettings')->id, 'ord' => $i + 1]) .'">'. $questions->get($i)->title .'</a>';
                                    echo '</li>';
                                }
                            @endphp
                        </ul>
                    </div>
                    <div class="form-group">
                        <a href="{{ route('question_student', ['id' => Session::get('testSettings')->id, 'ord' => 1])}}"
                           class="btn btn-success">
                            <i class="fas fa-play-circle"></i> Začať
                        </a>

                        <a href="{{ route('finish_student', ['id' => Session::get('testSettings')->id]) }}"
                           class="btn btn-danger">
                            <i class="fas fa-flag-checkered"></i> Dokončiť
                        </a>
                    </div>
                @endif

            </div>
        </div>
    </div>

@endsection
