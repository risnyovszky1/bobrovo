@extends('student.master')

@section('title')
    Dokončiť test | Bobrovo
@endsection

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 pt-5">
            <h2 class="mb-4">Dokončiť test</h2>

            <div class="alert alert-info mb-1 mt-1">
                    Určite chceš dokončiť test? Po dokončení nebudeš môcť upravovať odpovede.
            </div>


            <form action="" method="post">
                <div class="form-group">
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-lg btn-danger mt-4"><i class="fas fa-flag-checkered"></i> Dokončiť test</button>
                </div>
            </form>
        </div>
        <div class="col-md-4 pt-5">
            @include('student.side_menu')
        </div>
    </div>
</div>   

@endsection
