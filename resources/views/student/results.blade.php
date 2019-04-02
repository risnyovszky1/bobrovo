@extends('student.master')

@section('title')
    Výsledky | Bobrovo
@endsection

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 pt-3">
            <h3>Výsledky</h3>

            @foreach ($questions as $question)
                <div class="card border-primary mt-3">
                    <div class="card-header text-white bg-primary">
                        Názov
                    </div>

                    <div class="card-body">
                        <h5 class="card-title mb-0">
                            {{ $question->title }}
                        </h5>
                    </div>
                </div>
                @if (Session::get('testSettings')->available_answers == 1)
                    @if (!empty($answers[$question->id]))
                        @if ($answers[$question->id] == $question->answer)
                            <div class="border-success border rounded bg-white mt-2 pt-2 pb-2 pl-3 pl-4">
                                <i class="fas fa-check text-success"></i>  
                                @switch($question->answer)
                                    @case('a')
                                        {{ $question->a }}
                                        @break
                                    @case('b')
                                        {{ $question->b }}
                                        @break
                                    @case('c')
                                        {{ $question->c }}
                                        @break
                                    @default
                                        {{ $question->d }}
                                @endswitch
                                <span class="text-muted"> (tvoja odpoveď)</span>
                            </div>
                        @else
                            <div class="border-danger border rounded bg-white mt-2 pt-2 pb-2 pl-3 pl-4">
                                <i class="fas fa-times text-danger"></i> 
                                @switch($answers[$question->id])
                                    @case('a')
                                        {{ $question->a }}
                                        @break
                                    @case('b')
                                        {{ $question->b }}
                                        @break
                                    @case('c')
                                        {{ $question->c }}
                                        @break
                                    @default
                                        {{ $question->d }}
                                @endswitch
                                <span class="text-muted"> (tvoja odpoveď)</span>
                            </div>

                            <div class="border-success border rounded bg-white mt-2 pt-2 pb-2 pl-3 pl-4">
                                <i class="fas fa-check text-success"></i>  
                                @switch($question->answer)
                                    @case('a')
                                        {{ $question->a }}
                                        @break
                                    @case('b')
                                        {{ $question->b }}
                                        @break
                                    @case('c')
                                        {{ $question->c }}
                                        @break
                                    @default
                                        {{ $question->d }}
                                @endswitch
                                <span class="text-muted"> (správna odpoveď)</span>
                            </div>
                        @endif
                    @else
                        <div class="border-danger border rounded bg-white mt-2 pt-2 pb-2 pl-3 pl-4">
                            <i class="fas fa-times text-danger"></i> 
                            Nezodpovedané
                        </div>
                        <div class="border-success border rounded bg-white mt-2 pt-2 pb-2 pl-3 pl-4">
                            <i class="fas fa-check text-success"></i>  
                            @switch($question->answer)
                                @case('a')
                                    {{ $question->a }}
                                    @break
                                @case('b')
                                    {{ $question->b }}
                                    @break
                                @case('c')
                                    {{ $question->c }}
                                    @break
                                @default
                                    {{ $question->d }}
                            @endswitch
                            <span class="text-muted"> (správna odpoveď)</span>
                        </div>
                    @endif
                @else
                    <div class="border-secondary border rounded bg-white mt-2 pt-2 pb-2 pl-3 pl-4">
                        <i class="fas fa-question text-secondary"></i>
                        @if (!empty($answers[$question->id]))
                            @switch($answers[$question->id])
                                @case('a')
                                    {{ $question->a }}
                                    @break
                                @case('b')
                                    {{ $question->b }}
                                    @break
                                @case('c')
                                    {{ $question->c }}
                                    @break
                                @default
                                    {{ $question->d }}
                            @endswitch
                            <span class="text-muted"> (tvoja odpoveď)</span>
                        @else
                            Nezodpovedané
                        @endif
                    </div>
                @endif
                <hr>
            @endforeach
        </div>
        <div class="col-md-4 pt-4">
            @if(Session::get('testSettings')->available_answers && !empty($stats))
                @php
                    $val = round( $stats['good'] / $stats['total'] * 100, 1);
                    $bg = 'bg-danger';
                    if ($val >= 90) $bg = 'bg-success';
                    else if ($val >= 75) $bg = 'bg-info';
                    else if ($val >= 50) $bg = 'bg-warning';
                @endphp
                Úspešnosť <span class="small">({{ $val }} %)</span>
                <div class="progress">
                    <div class="progress-bar progress-bar-striped {{ $bg }}" role="progressbar" style="width: {{ $val }}%;" aria-valuenow="{{ $val }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            @else
                <div class="alert alert-danger">Výsledky nie sú k dizpozícií.</div>
            @endif
        </div>
    </div>
</div>   

@endsection
