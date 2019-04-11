@section('title')
  Výsledky študenta | Bobrovo
@endsection

@extends('admin.master')


@section('admin_content')
  <div class="admin-panel pt-2 pb-2">

    <div class="row">
        <div class="col-lg-8">
            <h2>Výsledky študenta</h2>
            <div class="card border-success mt-3">
                <div class="card-header bg-success text-white">
                    Študent
                </div>
                <div class="card-body">
                    <h5 class="card-title mb-0">{{ $student->first_name . ' ' . $student->last_name }}</h5>
                </div>
            </div>

            <div class="card border-primary mt-3">
                <div class="card-header bg-primary text-white">
                    Študent
                </div>
                <div class="card-body">
                    <h5 class="card-title mb-0">{{ $test->name }}</h5>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
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
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <hr>
            <h4>Otázky</h4>
            @foreach ($questions as $item)
                <div class="card border-secondary mb-3">
                    <div class="card-header text-white bg-secondary">
                        {{ $item->title }}
                    </div>
                    <div class="card-body">
                        {!! $item->question !!}
                    </div>
                </div>

                @if (empty($answers[$item->id]))
                    <div class="bg-white border rounded border-danger mb-2 pl-3 pr-3 pt-2 pb-2">
                        <i class="fas fa-times text-danger"></i> Nezodpovedané
                    </div>
                @else
                    @if ($answers[$item->id] == $item->answer)
                        @switch($item->type)
                            @case(4)
                                <div class="bg-white border rounded border-success mb-2 pl-3 pr-3 pt-2 pb-2">
                                    <i class="fas fa-check text-success"></i> <img src="{{ getQuestionsAnswerText($item, $answers[$item->id]) }}" alt="" class="d-inline-block"> <span class="text-muted">(odpoveď študenta)</span>
                                </div>
                                @break
                            @case(5)
                                <div class="bg-white border rounded border-secondary mb-2 pl-3 pr-3 pt-2 pb-2">
                                    INTERACTIVE
                                </div>
                                @break
                            @default
                                <div class="bg-white border rounded border-success mb-2 pl-3 pr-3 pt-2 pb-2">
                                    <i class="fas fa-check text-success"></i> {{ getQuestionsAnswerText($item, $answers[$item->id]) }} <span class="text-muted">(odpoveď študenta)</span>
                                </div>
                        @endswitch
                    @else
                        @switch($item->type)
                            @case(4)
                                <div class="bg-white border rounded border-danger mb-2 pl-3 pr-3 pt-2 pb-2">
                                    <i class="fas fa-times text-danger"></i> <img src="{{ getQuestionsAnswerText($item, $answers[$item->id]) }}" alt="" class="d-inline-block"> <span class="text-muted">(odpoveď študenta)</span>
                                </div>
                                <div class="bg-white border rounded border-success mb-2 pl-3 pr-3 pt-2 pb-2">
                                    <i class="fas fa-check text-success"></i> <img src="{{ getQuestionsAnswerText($item, $item->answer) }}" alt="" class="d-inline-block"> <span class="text-muted">(správna odpoveď)</span>
                                </div>
                                @break
                            @case(5)
                                <div class="bg-white border rounded border-secondary mb-2 pl-3 pr-3 pt-2 pb-2">
                                    INTERACTIVE
                                </div>
                                @break
                            @default
                                <div class="bg-white border rounded border-danger mb-2 pl-3 pr-3 pt-2 pb-2">
                                    <i class="fas fa-times text-danger"></i> {{ getQuestionsAnswerText($item, $answers[$item->id]) }} <span class="text-muted">(odpoveď študenta)</span>
                                </div>
                                <div class="bg-white border rounded border-success mb-2 pl-3 pr-3 pt-2 pb-2">
                                    <i class="fas fa-check text-success"></i> {{ getQuestionsAnswerText($item, $item->answer) }} <span class="text-muted">(správna odpoveď)</span>
                                </div>
                        @endswitch
                    @endif
                @endif
                <hr>
            @endforeach
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <a href="{{ route('tests.results', ['id' => $test->id]) }}" class="btn btn-primary">Späť na výsledky testu</a>
        </div>
    </div>
    
  </div>

@endsection
