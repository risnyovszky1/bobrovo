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

                <form action="{{ route('profil.update') }}" method="post">
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
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Uložiť
                        </button>

                        <button class="btn btn-danger" data-toggle="modal" data-target="#delete-modal" type="button">
                            <i class="fas fa-trash"></i> Vymazať profil
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('additional_html')
    <div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('profil.destroy')}}" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title">Vymazať profil</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-info">
                            Keď vymažete svoj profil, tak všetky dáta sa stratia a nebudete mať možnosť ich vrátiť.
                        </div>
                    </div>
                    <div class="modal-footer">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-light" data-dismiss="modal">Zatvoriť</button>
                        <button type="submit" class="btn btn-danger">Vymazať</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
