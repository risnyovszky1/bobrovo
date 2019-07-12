@extends('student.master')

@section('title')
    Skupiny | Bobrovo
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-10 pt-4 pb-3" id="student-group-wrapper">
                <h1>Moje skupiny</h1>

                <div class="row">
                    @foreach($groups as $group)
                        <div class="col-md-6">
                            <div class="card border-danger mt-3">
                                <div class="card-img-top text-center card-img pt-4">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div class="card-body">
                                    <h4 class="cart-title"> {{ $group->name  }}</h4>
                                    {{ $group->description  }}
                                </div>
                                <div class="card-body text-right">
                                    <a href="{{route('groups_one_student', ['id' => $group->id])}}"
                                       class="btn btn-dark">Pozri <i class="fas fa-chevron-circle-right"></i></a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

@endsection
