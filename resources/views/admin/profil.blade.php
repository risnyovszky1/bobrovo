@section('title')
    Upraviť profil | Bobrovo
@endsection

@extends('admin.master')


@section('admin_content')
    <div class="admin-panel pt-2 pb-2">
        <h2>Upraviť profil</h2>

        <div class="row">
            <div class="col-lg-7 pt-2">
                @if (!empty($errors))
                    @foreach ($errors->all() as $err)
                        <div class="alert alert-danger mb-2">
                            {{$err}}
                        </div>
                    @endforeach
                @endif

                <form action="" method="post">
                    <div class="form-group row">
                        <label for="first-name" class="col-sm-3 col-form-label">Meno:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="first-name" name="first-name"
                                   value="{{Auth::user()->first_name}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="last-name" class="col-sm-3 col-form-label">Priezvisko:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="last-name" name="last-name"
                                   value="{{Auth::user()->last_name}}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-sm-3 col-form-label">E-mail:</label>
                        <div class="col-sm-9">
                            <input type="email" class="form-control" id="email" name="email"
                                   value="{{Auth::user()->email}}">
                        </div>
                    </div>

                    <hr>

                    <div class="form-group row">
                        <label for="password" class="col-sm-3 col-form-label">Nové heslo:</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password-rpt" class="col-sm-3 col-form-label">Nové heslo ešte raz:</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" id="password-rpt" name="password-rpt">
                        </div>
                    </div>

                    <hr>

                    <div class="form-group row" style="align-items: center;">
                        <label for="admin" class="col-sm-3 col-form-label">Admin: </label>
                        <div class="col-sm-9">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input disabled" disabled
                                       id="customCheck1" {{Auth::user()->is_admin ? 'checked' : ''}}>
                                <label class="custom-control-label" for="customCheck1">&nbsp;</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Uložiť
                        </button>
                    </div>

                </form>
            </div>
        </div>


    </div>

@endsection
