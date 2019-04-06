@section('title')
  Vymazať profil | Bobrovo
@endsection

@extends('admin.master')


@section('admin_content')
  <div class="admin-panel pt-2 pb-2">
    <h2>Vymazať profil</h2>

    <div class="row">
        <div class="col-lg-7 pt-2">
            <div class="alert alert-info mb-2">
                Keď vymažeš svoj profil, tak všetky dáta sa stratia nebudete mať možnosť ich vrátiť.
            </div>
            
            @if (!empty($errors))
                @foreach ($errors->all() as $err)
                    <div class="alert alert-danger mb-2">
                        {{$err}}
                    </div>
                @endforeach
            @endif

            <form action="" method="post">
                <div class="form-group">
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-danger btn-lg">
                        <i class="fas fa-trash"></i> Vymazať
                    </button>
                </div>
                
            </form>
        </div>
    </div>




  </div>

@endsection
