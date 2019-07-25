@extends('student.master')

@section('title')
    Žiak | Bobrovo
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-8 pt-3">
                <h4>{{  __('student.Welcome') }}, {{ Auth::user()->first_name . ' ' .  Auth::user()->last_name }}!</h4>

                <hr>

                <ul class="list-group">
                    <li class="list-group-item h5">Test s <i class="fas fa-times text-danger"></i> už nie je k dispozícií.</li>

                    <li class="list-group-item h5">Test s <i class="fas fa-calendar-alt text-info"></i> ešte nie je k dispozícií.</li>

                    <li class="list-group-item h5">Test s <i class="fas fa-play text-warning"></i> sa práve prebieha.</li>
                </ul>

            </div>
        </div>
    </div>

@endsection
