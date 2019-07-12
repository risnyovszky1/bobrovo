@section('title')
    Prihlásiť ako učiteľ | Bobrovo
@endsection

@include('general.header')

<main id="root" class="pt-5 pb-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-8">
                <h1>Prihlásenie ako učiteľ</h1>
                <p>Po prihlásení sa do tohto prostredia budete mať k dispozícii úlohy súťaže iBobor zo všetkých
                    doterajších ročníkov - môžete si z nich niektoré vybrať a zostaviť svoj vlastný test.</p>
                @if(count($errors) > 0)
                    @foreach($errors->all() as $err)
                        <div class="alert alert-danger mb-2">
                            {{ $err }}
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    <form action="" method="post">
        <div class="container">
            <div class="row">

                <div class="col-lg-6 col-md-8">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="email">
                                E-mail
                            </label>
                            <input class="form-control form-control-lg" type="email" name="email"
                                   placeholder="Zadajte mailovú adresu">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <label for="password">
                                Heslo
                            </label>
                            <input class="form-control form-control-lg" type="password" name="password"
                                   placeholder="Zadajte heslo">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-sign-in-alt"></i>
                                Prihlásiť
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</main>


@include('general.footer')
