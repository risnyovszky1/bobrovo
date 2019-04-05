@extends('student.master')

@section('title')
    Testy | Bobrovo
@endsection

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 pt-3">
            <h3>Testy</h3>
            @if (empty($groups))
                <p>Prepáč, ale ešte nemáš skupinu. <i class="fas fa-frown text-danger"></i></p>
            @endif
            
            @foreach ($groups as $group)
                <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    {{$group->name}}
                </div>
                @if ($tests[$group->id] && count($tests[$group->id]) > 0)
                    <ul class="list-group list-group-flush">
                        @foreach ($tests[$group->id] as $test)
                        <li class="list-group-item">
                            <a href="{{ route('testone_student', ['id' => $test->id]) }}">
                            @php
                                $currTime = time();
                                if (strtotime($test->available_to) < $currTime){
                                    // test is not available
                                    echo '<i class="fas fa-times text-danger"></i>';
                                }
                                else if (strtotime($test->available_from) < $currTime && (strtotime($test->available_to) > $currTime)){
                                    // test is going
                                    echo '<i class="fas fa-play text-warning"></i>';
                                }
                                else{
                                    // test is scheduled for another time
                                    echo '<i class="fas fa-calendar-alt text-info"></i>';
                                }
                            @endphp
                            {{ $test->name }}
                            </a>
                        </li>    
                        @endforeach
                    </ul>
                @else
                    <div class="card-body">
                    <p class="card-text">
                        K tejto skupine nie je priradený ešte žiadny test.
                    </p>
                    </div>
                @endif
                </div>
            @endforeach
        </div>
    </div>
</div>


@endsection
