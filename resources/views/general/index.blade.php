@section('title')
  Bobrovo
@endsection

@include('general.header')

<main id="root">
  <section class="home-section" id="welcome-text">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="jumbotron">
            <h2 class="display-4">
              Vítajte na stránke Bobrovo!
            </h2>
            <p class="lead">
              Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
              Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure
              dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
              proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="bg-secondary text-light pt-3 pb-2" id="about-section">
    <div class="container">
      <div class="row">
        <div class="col-md-12 col-lg-10 offset-lg-1 text-center pt-3 pb-3">
          <h1>O nás</h1>
          <p class="lead">
            Tart jelly-o sesame snaps cake wafer. Cake caramels oat cake pie chocolate bar. Jelly-o bear claw tootsie roll dragée
            jelly beans macaroon sweet roll. Oat cake powder bear claw fruitcake. Pastry jelly beans ice cream marzipan oat cake
            jelly danish liquorice. Biscuit candy canes bonbon pudding croissant cake.
          </p>
        </div>
      </div>
    </div>
  </section>

  <section class="home-section bg-bobrovo-green-light" id="count-up-section">
    <div class="container">
      <div class="row">
        <div class="col-md-12 text-center mb-4 pb-1">
          <h1>Bobrovo je skutoční</h1>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-6 text-center">
          <div class="count-up mb-4">
            <div class="logo">
              <i class="fas fa-users"></i>
            </div>
            <div class="counter">
              <strong>
                <span data-count="156">0</span>
              </strong>
            </div>
            <div class="title">
              <span class="h4">Učiteľov</span>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-6 text-center">
          <div class="count-up mb-4">
            <div class="logo">
              <i class="fas fa-user-graduate"></i>
            </div>
            <div class="counter">
              <strong>
                <span data-count="1238">0</span>
              </strong>
            </div>
            <div class="title">
              <span class="h4">Žiakov</span>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-6 text-center">
          <div class="count-up mb-4">
            <div class="logo">
              <i class="fas fa-file-alt"></i>
            </div>
            <div class="counter">
              <strong>
                <span data-count="47">0</span>
              </strong>
            </div>
            <div class="title">
              <span class="h4">Testov za deň</span>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-6 text-center">
          <div class="count-up">
            <div class="logo">
              <i class="far fa-smile-beam"></i>
            </div>
            <div class="counter">
              <strong>
                <span data-count="3453">0</span>
              </strong>
            </div>
            <div class="title">
              <span class="h4">Spokojných návštenvíkov</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="home-section" id="testimonial-section">
    <div class="container">
      <div class="row">
        <div class="col-md-12 text-center">
          <h1>Povedali o nás</h1>
        </div>
        <div class="row">
          <div class="col-lg-8 offset-lg-3 pt-4 pb-3">
            <div class="slick-slider">
              <div class="slider-item">
                <div class="testimonial">
                  <div class="row">
                    <div class="col-lg-3">
                      <div class="testimonial-img-holder">
                        <img src="/img/user.jpg" alt="" class="img-thumbnail mb-2">
                      </div>
                    </div>
                    <div class="col-lg-8">
                      <h3>Jozef Bobor</h3>
                      <p class="text-muted mb-1">Učiteľ</p>
                      <blockquote class="blockquote">
                        <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
                      </blockquote>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>


  <section class="home-section bg-bobrovo-green-light" id="home-news-feed">
    <div class="container">
      <div class="row">
        <div class="col-md-12 text-center mb-3">
          <h1>Novinky</h1>
        </div>
      </div>
      @if(count($newsFeed) > 0)
        <div class="row">
          @foreach($newsFeed as $news)
            <div class="col-md-4 pb-2">
              <div class="card mb-2 equal-height border-bobrovo-green">
                <div class="card-body">
                  <h5 class="card-title">{{ $news->title }}</h5>
                  <p class="card-text text-muted">{{ $news->created_at }}</p>
                </div>
                <div class="card-body text-center pt-0">
                  <a href="{{ route('newsonepage', ['news_id' => $news->news_id]) }}" class="btn btn-sm btn-success">Pozrieť <i class="far fa-eye"></i></a>
                </div>
              </div>
            </div>
          @endforeach
        </div>
        <div class="row">
          <div class="col-md-12 text-center pt-4">
            <a href="{{ route('newspage') }}" class="btn btn-lg btn-success">
              Všetky novinky
            </a>
          </div>
        </div>
        @else
          <div class="row">
            <div class="col-md-12 text-center">
              <p>Zaťiaľ nie sú žiadné novinky na stránke.</p>
            </div>
          </div>
        @endif
      </div>
    </div>
  </section>

  <section class="home-section" id="contact-form">
    <form action="" method="post">
      <div class="container">
        <div class="row">
          <div class="col-md-12 text-center mb-3">
            <h1>Kontaktujte nás</h1>
            <p>Keď máte nejakú otázku obraťte na náš tým!</p>
          </div>
        </div>

        @if(count($errors) > 0)
          <div class="row">
            <div class="col-md-12">
              @foreach($errors->all() as $err)
                <div class="alert alert-danger mb-2">
                  {{ $err }}
                </div>
              @endforeach
            </div>
          </div>
        @endif

        @if(!empty($success))
          <div class="row">
            <div class="col-md-12">
              <div class="alert alert-success mb-3 mt-2">
                {{ $success }}
              </div>
            </div>
          </div>
        @endif

        <div class="row">
          <div class="col-md-4">
            <div class="form-group">
              <label for="name"><i class="fas fa-user"></i> Meno: </label>
              <input type="text" name="name" class="form-control" placeholder="Zadajte svoje meno">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="e-mail"><i class="far fa-envelope"></i> E-mail: </label>
              <input type="email" name="e-mail" class="form-control" placeholder="Zadajte mailovú adresu">
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="telnumber"><i class="fas fa-phone"></i> Telefónne číslo: </label>
              <input type="tel" name="telnumber" class="form-control" placeholder="Zadajte svoje telefónne čislo">
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="form-group">
              <label for="message"><i class="far fa-comment"></i> Správa: </label>
              <textarea name="message" class="form-control" rows="3"></textarea>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 text-center mb-4 mt-2">
            <div class="custom-control custom-checkbox">
              <input type="checkbox" name="default-conditions" class="custom-control-input" id="default-conditions">
              <label class="custom-control-label" for="default-conditions">Súhlasím so <a href="{{ route('default_cond') }}" target="_blank">všeobecnými podmienkami používania</a></label>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 text-center mb-5">
            {{ csrf_field() }}
            <button type="submit" class="btn btn-lg btn-primary">
              Poslať <i class="fas fa-paper-plane"></i>
            </button>
          </div>
        </div>
      </div>
    </form>
  </section>
</main>


@include('general.footer')
