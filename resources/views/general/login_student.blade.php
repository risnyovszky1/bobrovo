@section('title')
    Prihlásiť ako študent | Bobrovo
@endsection

@include('general.header')

<main id="root" class="pt-5 pb-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-8">
                <h1>Prihlásenie ako študent</h1>
                <p>
                    Ak si dostal(a) od pán učiteľa (pani učiteľky) informatiky kód, po jeho zadaní uvidíš, či je pre
                    Teba pripravený test a aj to, kedy ho budeš môcť riešiť.
                </p>

                @if(!empty($errors))
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger mb-2">
                            {{$error}}
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
                        <div class="col-md-12 mb-4">
                            <label for="code">
                                Kód
                            </label>
                            <input class="form-control form-control-lg" type="text" name="code" placeholder="Zadaj kód">
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
