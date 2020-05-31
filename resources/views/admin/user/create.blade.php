@section('title')
    Pridať používateľa | Bobrovo
@endsection

@extends('admin.master')


@section('admin_content')
    <div class="admin-panel pt-2 pb-2">
        <div class="row">
            <div class="col-lg-8">
                <h1>Pridať používateľa</h1>
                <form action="{{ route('user.store') }}" method="POST">
                    <div class="form-group">
                        <label for="first_name">Meno</label>
                        <input type="text" class="form-control" name="first_name" id="first_name"
                               value="{{ old('first_name') }}">
                    </div>

                    <div class="form-group">
                        <label for="last_name">Priezvisko</label>
                        <input type="text" class="form-control" name="last_name" id="last_name"
                               value="{{ old('last_name') }}">
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" class="form-control" name="email" id="email" value="{{ old('email') }}">
                    </div>

                    <div class="form-group">
                        <label for="password">Heslo</label>
                        <input type="password" class="form-control" name="password" id="password">
                    </div>

                    <div class="form-group">
                        <label for="password-rpt">Heslo ešte raz</label>
                        <input type="password" class="form-control" name="password-rpt" id="password-rpt">
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-checkbox mb-2">
                            <input type="checkbox" name="is_admin" class="custom-control-input"
                                   value="yes" id="is_admin">
                            <label class="custom-control-label" for="is_admin">Admin</label>
                        </div>
                    </div>

                    <div class="form-group">
                        @csrf
                        <a href="{{ route('user.index') }}" class="btn btn-lg btn-link">Zrušiť</a>
                        <button type="submit" class="btn btn-lg btn-primary">
                            <i class="fas fa-plus-circle"></i> Pridaj
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
