@extends('student.master')

@section('title')
    Výsledky | Bobrovo
@endsection

@section('content')

<div class="container">
    <div class="row">
        <div class="col-lg-8 pt-4">
            <h3>{{ __('student.results') }}</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8">
            
            @foreach ($questions as $question)
                <div class="card border-primary mt-2">
                    <div class="card-header text-white bg-primary">
                        {{ __('student.title') }}
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
                                @if ($question->type <= 3 )
                                    {{ getQuestionsAnswerText($question, $answers[$question->id]) }}
                                @else 
                                    <img src="{{ getQuestionsAnswerText($question, $answers[$question->id]) }}" alt="tvoja odpoved" class="ml-3">
                                @endif
                                <span class="text-muted"> ({{ __('student.your-asnwer') }})</span>
                            </div>
                        @else
                            <div class="border-danger border rounded bg-white mt-2 pt-2 pb-2 pl-3 pl-4">
                                <i class="fas fa-times text-danger"></i> 
                                @if ($question->type <= 3 )
                                    {{ getQuestionsAnswerText($question, $answers[$question->id]) }}
                                @else 
                                    <img src="{{ getQuestionsAnswerText($question, $answers[$question->id]) }}" alt="tvoja odpoved" class="ml-3">
                                @endif
                                <span class="text-muted"> ({{ __('student.your-asnwer') }})</span>
                            </div>
                            
                            <div class="border-success border rounded bg-white mt-2 pt-2 pb-2 pl-3 pl-4">
                                <i class="fas fa-check text-success"></i>  
                                @if ($question->type <= 3 )
                                    {{ getQuestionsAnswerText($question, $question->answer) }}
                                @else 
                                    <img src="{{ getQuestionsAnswerText($question, $question->answer) }}" alt="tvoja odpoved" class="ml-2">
                                @endif
                                <span class="text-muted"> ({{ __('student.correct-asnwer') }})</span>
                            </div>
                        @endif
                    @else
                        <div class="border-danger border rounded bg-white mt-2 pt-2 pb-2 pl-3 pl-4">
                            <i class="fas fa-times text-danger"></i>
                            {{ __('student.not-answered') }}
                        </div>
                        <div class="border-success border rounded bg-white mt-2 pt-2 pb-2 pl-3 pl-4">
                            <i class="fas fa-check text-success"></i>  
                            @if ($question->type <= 3 )
                                {{ getQuestionsAnswerText($question, $question->answer) }}
                            @else 
                                <img src="{{ getQuestionsAnswerText($question, $question->answer) }}" alt="spravna odpoved">
                            @endif
                            <span class="text-muted"> ({{ __('student.correct-asnwer') }})</span>
                        </div>
                    @endif
                @else
                    <div class="border-secondary border rounded bg-white mt-2 pt-2 pb-2 pl-3 pl-4">
                        <i class="fas fa-question text-secondary"></i>
                        @if (!empty($answers[$question->id]))
                            @if ($question->type <= 3 )
                                {{ getQuestionsAnswerText($question, $answers[$question->id]) }}
                            @else 
                                <img src="{{ getQuestionsAnswerText($question, $answers[$question->id]) }}" alt="tvoja odpoved">
                            @endif
                            <span class="text-muted"> ({{ __('student.your-asnwer') }})</span>
                        @else
                            {{ __('student.not-answered') }}
                        @endif
                    </div>
                @endif
                <hr>
            @endforeach
        </div>
        <div class="col-lg-4 pt-2">
            @if(Session::get('testSettings')->available_answers && !empty($stats))
                @php
                    $val = round( $stats['good'] / $stats['total'] * 100, 1);
                    $bg = 'bg-danger';
                    if ($val >= 90) $bg = 'bg-success';
                    else if ($val >= 75) $bg = 'bg-info';
                    else if ($val >= 50) $bg = 'bg-warning';
                @endphp
                {{ __('student.prediction') }} <span class="small">({{ $val }} %)</span>
                <div class="progress">
                    <div class="progress-bar progress-bar-striped {{ $bg }}" role="progressbar" style="width: {{ $val }}%;" aria-valuenow="{{ $val }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            @else
                <div class="alert alert-danger">{{ __('student.results-not-available') }}</div>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8 pb-2">
            <a href="{{route('testone_student', ['id' => Session::get('testSettings')->id])}}" class="btn btn-primary">
                <i class="fas fa-arrow-circle-left"></i> {{ __('student.back-to-test') }}
            </a>
        </div>
    </div>
</div>   

@endsection
