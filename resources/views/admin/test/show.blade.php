@section('title')
    Test | Bobrovo
@endsection

@extends('admin.master')

@section('admin_content')
    <div class="row">
        <div class="col-lg-8 pt-3 pb-3">
            <h2>Test</h2>

            <div class="card mt-4 border-primary shadow">
                <div class="card-header bg-primary text-white">
                    Názov
                </div>
                <div class="card-body">
                    <h5 class="card-title mb-0">{{ $test->name}}</h5>
                </div>
            </div>

            <div class="card mt-4 border-success shadow">
                <div class="card-header bg-success text-white">
                    Skupina
                </div>
                <div class="card-body">
                    <p class="card-text">
                        <a href="{{ route('group.show', $test->group) }}"
                           title="Skupina {{ $test->group->name }}">
                            {{ $test->group->name }}
                        </a>
                    </p>
                </div>
            </div>

            <div class="card mt-4 border-info shadow">
                <div class="card-header bg-info text-white">
                    Popis
                </div>
                <div class="card-body">
                    {!! $test->description !!}
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="card mt-4 shadow">
                        <div class="card-header">
                            Odkedy je dostupný
                        </div>
                        <div class="card-body">
                            <p class="card-text">
                                {{ $test->available_from }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card mt-4 shadow">
                        <div class="card-header">
                            Dokedy je dostupný
                        </div>
                        <div class="card-body">
                            <p class="card-text">
                                {{ $test->available_to }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mt-4 shadow">
                        <div class="card-header">
                            Čas na vypracovanie
                        </div>
                        <div class="card-body">
                            {{ $test->time_to_do }} min.
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-4 border-secondary shadow">
                <div class="card-header text-white bg-secondary">
                    Nastavenia
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        Dostupný popis k
                        otázku: {!! $test->available_description ? '<span class="text-success">Áno <i class="fas fa-check"></i></span>' : '<span class="text-danger">Nie <i class="fas fa-times"></i></span>' !!}
                    </li>
                    <li class="list-group-item">
                        Náhodné poradie otázkov:
                        {!! $test->mix_questions ? '<span class="text-success">Áno <i class="fas fa-check"></i></span>' : '<span class="text-danger">Nie <i class="fas fa-times"></i></span>' !!}
                    </li>
                    <li class="list-group-item">
                        Dostupné správne riešenia:
                        {!! $test->available_answers ? '<span class="text-success">Áno <i class="fas fa-check"></i></span>' : '<span class="text-danger">Nie <i class="fas fa-times"></i></span>' !!}
                    </li>
                    <li class="list-group-item">
                        Verejný:
                        {!! $test->public ? '<span class="text-success">Áno <i class="fas fa-check"></i></span>' : '<span class="text-danger">Nie <i class="fas fa-times"></i></span>' !!}
                    </li>
                </ul>
            </div>

            @if ($test->questions->isNotEmpty())
                <div class="card mt-4 border-dark shadow">
                    <div class="card-header text-white bg-dark">
                        Otázky na teste
                    </div>
                    <ul class="list-group list-group-flush">
                        @foreach ($test->questions as $item)
                            <li class="list-group-item">
                                <a href="{{ route('question.show', $item->id) }}">{{ $item->title }}</a>
                                @include('admin.partials.remove', ['route' => route('test.remove-question', ['test' => $test, 'question' => $item])])
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="form-group mt-4">
                <a href="{{ route('test.index') }}" class="btn btn-link">Spať</a>
                <a href="{{ route('test.edit', $test) }}" class="btn btn-primary shadow"><i
                        class="far fa-edit"></i> Upraviť</a>
                <a href="{{ route('test.result', $test) }}" class="btn btn-success shadow"><i
                        class="fas fa-poll"></i> Výsledky</a>

            </div>
        </div>
    </div>
@endsection
