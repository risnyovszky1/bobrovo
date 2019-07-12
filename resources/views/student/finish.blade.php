@extends('student.master')

@section('title')
    Dokončiť test | Bobrovo
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-8 pt-5">
                <h2 class="mb-4">{{ __('student.finish-test') }}</h2>

                <div class="alert alert-info mb-1 mt-1">
                    {{ __('student.want-to-finish') }}
                </div>


                <form action="" method="post">
                    <div class="form-group">
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-lg btn-danger mt-4"><i
                                    class="fas fa-flag-checkered"></i> {{ __('student.finish-test') }}</button>
                    </div>
                </form>
            </div>
            <div class="col-md-4 pt-5">
                @include('student.side_menu')
            </div>
        </div>
    </div>

@endsection
