@extends('student.master')

@section('title')
    Žiak | Bobrovo
@endsection

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 pt-3">
            <h4>Vítaj, {{ Auth::user()->first_name . ' ' .  Auth::user()->last_name }}!</h4>
        </div>
    </div>
</div>   

@endsection
