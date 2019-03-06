<div class="accordion" id="admin-menu">

  <!-- ADMIN PART -->
  @if(Auth::user()->is_admin == 1)
    <div class="card">
      <div class="card-header text-left">
        <h3 class="mb-0">
          <button class="btn btn-link btn-block" type="button" data-toggle="collapse" data-target="#news" aria-expanded="true" aria-controls="collapseOne">
            Novinky
          </button>
        </h3>
      </div>
      <div id="news" class="collapse" aria-labelledby="news" data-parent="#admin-menu">
        <div class="card-body">
          <ul class="list-group list-group-flush">
            <li class="list-group-item"><a href="{{ route('news.all') }}">Všetky novinky</a></li>
            <li class="list-group-item"><a href="{{ route('news.addnew') }}">Pridaj nový</a></li>
          </ul>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="card-header text-left">
        <h3 class="mb-0">
          <button class="btn btn-link btn-block" type="button" data-toggle="collapse" data-target="#faq" aria-expanded="true" aria-controls="collapseTwo">
            FAQ
          </button>
        </h3>
      </div>
      <div id="faq" class="collapse" aria-labelledby="faq" data-parent="#admin-menu">
        <div class="card-body">
          <ul class="list-group list-group-flush">
            <li class="list-group-item"><a href="{{ route('faq.all') }}">Všetky faq</a></li>
            <li class="list-group-item"><a href="{{ route('faq.addnew') }}">Pridaj nový</a></li>
          </ul>
        </div>
      </div>
    </div>
  @endif

  <!-- TEACHER PART -->
  <div class="card">
    <div class="card-header text-left">
      <h3 class="mb-0">
        <button class="btn btn-link btn-block" type="button" data-toggle="collapse" data-target="#messeges" aria-expanded="true" aria-controls="collapseSeven">
          Správy
        </button>
      </h3>
    </div>
    <div id="messeges" class="collapse" aria-labelledby="messeges" data-parent="#admin-menu">
      <div class="card-body">
        <ul class="list-group list-group-flush">
          <li class="list-group-item"><a href="{{ route('msg.all') }}">Všetky správy</a></li>
          <li class="list-group-item"><a href="{{ route('msg.send') }}">Napísať novú</a></li>
        </ul>
      </div>
    </div>
  </div>


  <div class="card">
    <div class="card-header text-left">
      <h3 class="mb-0">
        <button class="btn btn-link btn-block" type="button" data-toggle="collapse" data-target="#students" aria-expanded="true" aria-controls="collapseThree">
          Moje študenti
        </button>
      </h3>
    </div>
    <div id="students" class="collapse" aria-labelledby="students" data-parent="#admin-menu">
      <div class="card-body">
        <ul class="list-group list-group-flush">
          <li class="list-group-item"><a href="{{ route('students.all' ) }}">Všetky študenti</a></li>
          <li class="list-group-item"><a href="{{ route('students.add' ) }}">Pridaj nový</a></li>
          <li class="list-group-item"><a href="{{ route('students.file' ) }}">Import zo súboru</a></li>
        </ul>
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-header text-left">
      <h3 class="mb-0">
        <button class="btn btn-link btn-block" type="button" data-toggle="collapse" data-target="#classes" aria-expanded="true" aria-controls="collapseFour">
          Moje skupiny
        </button>
      </h3>
    </div>
    <div id="classes" class="collapse" aria-labelledby="classes" data-parent="#admin-menu">
      <div class="card-body">
        <ul class="list-group list-group-flush">
          <li class="list-group-item"><a href="{{ route('groups.all') }}">Všetky skupiny</a></li>
          <li class="list-group-item"><a href="{{ route('groups.add') }}">Pridaj novú</a></li>
        </ul>
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-header text-left">
      <h3 class="mb-0">
        <button class="btn btn-link btn-block" type="button" data-toggle="collapse" data-target="#tests" aria-expanded="true" aria-controls="collapseFive">
          Moje testy
        </button>
      </h3>
    </div>
    <div id="tests" class="collapse" aria-labelledby="tests" data-parent="#admin-menu">
      <div class="card-body">
        <ul class="list-group list-group-flush">
          <li class="list-group-item"><a href="{{ route('tests.all')}}">Všetky testy</a></li>
          <li class="list-group-item"><a href="{{ route('tests.add') }}">Pridaj nový</a></li>
        </ul>
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-header text-left">
      <h3 class="mb-0">
        <button class="btn btn-link btn-block" type="button" data-toggle="collapse" data-target="#questions" aria-expanded="true" aria-controls="collapseSix">
          Otázky
        </button>
      </h3>
    </div>
    <div id="questions" class="collapse" aria-labelledby="questions" data-parent="#admin-menu">
      <div class="card-body">
        <ul class="list-group list-group-flush">
          <li class="list-group-item"><a href="{{ route('questions.all') }}">Všetky otázky</a></li>
          <li class="list-group-item"><a href="#">Moje otázky</a></li>
          <li class="list-group-item"><a href="#">Pridaj nový</a></li>
        </ul>
      </div>
    </div>
  </div>

</div>
