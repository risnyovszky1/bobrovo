@section('title')
  Registrácia | Bobrovo
@endsection

@include('general.header')

<main id="root" class="pt-5 pb-5">
  <div class="container">
    <div class="row">
      <div class="col-lg-8">
        <h1>Registrácia</h1>
        @if(count($errors) > 0)
          @foreach($errors->all() as $err)
            <div class="alert alert-danger mb-2">
              {{ $err }}
            </div>
          @endforeach
        @endif
        @if (!empty($message))
          <div class="alert alert-success mb-2">
            {{ $message }}
          </div>
        @endif
      </div>
    </div>
  </div>
  <form action="" method="post">
    <div class="container">
      <div class="row">
        <div class="col-lg-8">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="first-name">Meno</label>
                <input type="text" name="first-name" placeholder="Zadajte svoje meno" class="form-control">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="last-name">Priezvisko</label>
                <input type="text" name="last-name" placeholder="Zadajte svoje priezvisko" class="form-control">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" name="email" placeholder="Zadajte svoje mailovú adresu" class="form-control form-control-lg">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="password">Heslo</label>
                <input type="password" name="password" placeholder="Zadajte svoje heslo" class="form-control">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="password-rpt">Heslo ešte raz</label>
                <input type="password" name="password-rpt" placeholder="Zadajte svoje heslo ešte raz" class="form-control">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="custom-control custom-checkbox mb-2">
                <input type="checkbox" name="default-conditions" class="custom-control-input" value="yes" id="default-conditions">
                <label class="custom-control-label" for="default-conditions">Súhlasím so <a href="{{ route('default_cond') }}" target="_blank">všeobecnými podmienkami používania</a></label>
              </div>
            </div>
          </div>
          @php 
          /*
          <div class="row">
            <div class="col-md-12 mb-4">
              <div class="custom-control custom-radio">
                <input type="radio" id="customRadio1" name="is-admin" value="yes" class="custom-control-input">
                <label class="custom-control-label" for="customRadio1">Role admin</label>
              </div>
              <div class="custom-control custom-radio">
                <input type="radio" id="customRadio2" name="is-admin" value="no" class="custom-control-input">
                <label class="custom-control-label" for="customRadio2">Role teacher</label>
              </div>
            </div>
          </div>
          */
          @endphp
          <div class="row">
            <div class="col-md-12">
              {{ csrf_field() }}
              <button type="submit" class="btn btn-lg btn-success">
                <i class="fas fa-user-plus"></i> Registrovať
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</main>


@include('general.footer')
