@extends('student.master')

@section('title')
    Skupina | Bobrovo
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-10 pt-3 pb-3">
                <h1>Skupina</h1>

                <div class="card border-success mt-4">
                    <div class="card-header bg-success text-white">
                        Meno skupiny
                    </div>
                    <div class="card-body">
                        <h4 class="card-title mb-0"> {{$group->name}}</h4>
                    </div>
                </div>

                <div class="card border-info mt-4">
                    <div class="card-header bg-info text-white">
                        Učiteľ
                    </div>
                    <div class="card-body">
                        <p class="mb-0">{{ $group->teacher_name }}</p>
                    </div>
                </div>

                <div class="card border-secondary mt-4">
                    <div class="card-header bg-secondary text-white">
                        Popis skupiny
                    </div>
                    <div class="card-body">
                        {{$group->description}}
                    </div>
                </div>

                <div class="card border-primary mt-4">
                    <div class="card-header bg-primary text-white">
                        Testy priradené k skupine
                    </div>
                    @if(count($tests) > 0)
                        <ul class="list-group list-group-flush">
                            @foreach ($tests as $test)
                                <li class="list-group-item">
                                    <a href="{{ route('testone_student', ['id' => $test->id]) }}">
                                        @php
                                            $currTime = strtotime(date('Y-m-d H:i:s'));
                                            if (strtotime($test->available_to) < $currTime){
                                                // test is not available
                                                echo '<i class="fas fa-times text-danger"></i>';
                                            }
                                            else if (strtotime($test->available_from) < $currTime && strtotime($test->available_to) > $currTime){
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
                            <p class="mb-0">Ešte žiadny test nie je priradený ku skupine.</p>
                        </div>
                    @endif
                </div>

                <div class="card border-dark mt-4">
                    <div class="card-header bg-dark text-white">
                        Spolužiaci
                    </div>
                    <ul class="list-group list-group-flush">
                        @foreach($students as $student)
                            <li class="list-group-item">{{ $student }}</li>
                        @endforeach
                    </ul>
                </div>


            </div>
        </div>
    </div>

@endsection
