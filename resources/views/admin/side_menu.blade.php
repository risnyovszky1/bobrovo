<div class="row d-md-none">
    <div class="col-md-12 pt-3 pb-3 pl-4 pr-4">
        <button id="toggle-admin-menu"
                class="btn btn-success btn-block justify-content-between d-flex align-self-center"><span>Menu </span> <i
                class="fas fa-caret-down"></i></button>
    </div>
</div>

<div class="accordion display-none d-md-block d-lg-block d-xl-block" id="admin-menu">
    <!-- ADMIN PART -->
    @if(Auth::user()->is_admin == 1)
        <div class="card">
            <div class="card-header text-left">
                <h3 class="mb-0">
                    <button class="btn btn-link btn-block" type="button" data-toggle="collapse" data-target="#users"
                            aria-expanded="true" aria-controls="collapseOne">
                        <i class="fas fa-user"></i> Používateľia
                    </button>
                </h3>
            </div>
            <div id="users"
                 class="collapse {{ Request::is('ucitel/pouzivatelia/*') || Request::is('ucitel/pouzivatelia') ? 'show': '' }}"
                 aria-labelledby="news" data-parent="#admin-menu">
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><a href="{{ route('users.all') }}">Všetky používateľia</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header text-left">
                <h3 class="mb-0">
                    <button class="btn btn-link btn-block" type="button" data-toggle="collapse" data-target="#news"
                            aria-expanded="true" aria-controls="collapseOne">
                        <i class="far fa-newspaper"></i> Novinky
                    </button>
                </h3>
            </div>
            <div id="news"
                 class="collapse {{ Request::is('ucitel/news/*') || Request::is('ucitel/news') ? 'show': '' }}"
                 aria-labelledby="news" data-parent="#admin-menu">
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><a href="{{ route('news.index') }}">Všetky novinky</a></li>
                        <li class="list-group-item"><a href="{{ route('news.create') }}">Pridaj nový</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header text-left">
                <h3 class="mb-0">
                    <button class="btn btn-link btn-block" type="button" data-toggle="collapse" data-target="#faq"
                            aria-expanded="true" aria-controls="collapseTwo">
                        <i class="fas fa-book-open"></i> FAQ
                    </button>
                </h3>
            </div>
            <div id="faq" class="collapse {{ Request::is('ucitel/faq/*') || Request::is('ucitel/faq') ? 'show': '' }}"
                 aria-labelledby="faq" data-parent="#admin-menu">
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><a href="{{ route('faq.index') }}">Všetky faq</a></li>
                        <li class="list-group-item"><a href="{{ route('faq.create') }}">Pridaj nový</a></li>
                    </ul>
                </div>
            </div>
        </div>
@endif

<!-- TEACHER PART -->
    <div class="card">
        <div class="card-header text-left">
            <h3 class="mb-0">
                <button class="btn btn-link btn-block" type="button" data-toggle="collapse" data-target="#messeges"
                        aria-expanded="true" aria-controls="collapseSeven">
                    <i class="far fa-comment"></i>
                    @php
                        $newMessagesCount = newMessagesCount();
                    @endphp
                    Správy @if ($newMessagesCount) <span class="badge badge-warning">{{ $newMessagesCount }}</span>@endif
                </button>
            </h3>
        </div>
        <div id="messeges"
             class="collapse {{ Request::is('ucitel/spravy/*') || Request::is('ucitel/spravy') ? 'show': '' }}"
             aria-labelledby="messeges" data-parent="#admin-menu">
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
                <button class="btn btn-link btn-block" type="button" data-toggle="collapse" data-target="#students"
                        aria-expanded="true" aria-controls="collapseThree">
                    <i class="fas fa-user-graduate"></i> Moje študenti
                </button>
            </h3>
        </div>
        <div id="students"
             class="collapse {{ Request::is('ucitel/ziaci/*') || Request::is('ucitel/ziaci') ? 'show': '' }}"
             aria-labelledby="students" data-parent="#admin-menu">
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
                <button class="btn btn-link btn-block" type="button" data-toggle="collapse" data-target="#classes"
                        aria-expanded="true" aria-controls="collapseFour">
                    <i class="fas fa-users"></i> Moje skupiny
                </button>
            </h3>
        </div>
        <div id="classes"
             class="collapse {{ Request::is('ucitel/skupiny/*') || Request::is('ucitel/skupiny') ? 'show': '' }}"
             aria-labelledby="classes" data-parent="#admin-menu">
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
                <button class="btn btn-link btn-block" type="button" data-toggle="collapse" data-target="#tests"
                        aria-expanded="true" aria-controls="collapseFive">
                    <i class="far fa-file-alt"></i> Moje testy
                </button>
            </h3>
        </div>
        <div id="tests" class="collapse {{ Request::is('ucitel/testy/*') || Request::is('ucitel/testy') ? 'show': '' }}"
             aria-labelledby="tests" data-parent="#admin-menu">
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
                <button class="btn btn-link btn-block" type="button" data-toggle="collapse" data-target="#questions"
                        aria-expanded="true" aria-controls="collapseSix">
                    <i class="far fa-question-circle"></i> Otázky
                </button>
            </h3>
        </div>
        <div id="questions"
             class="collapse {{ Request::is('ucitel/otazky/*') || Request::is('ucitel/otazky') ? 'show': '' }}"
             aria-labelledby="questions" data-parent="#admin-menu">
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><a href="{{ route('questions.all') }}">Všetky otázky</a></li>
                    <li class="list-group-item"><a href="{{ route('questions.my') }}">Moje otázky</a></li>
                    @if (auth()->user()->is_admin)
                        <li class="list-group-item"><a href="{{ route('questions.other') }}">Otázky od iných</a></li>
                    @endif
                    <li class="list-group-item"><a href="{{ route('questions.add') }}">Pridaj nový</a></li>
                    <li class="list-group-item"><a href="{{ route('questions.filter') }}">Filter otázkov</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header text-left">
            <h3 class="mb-0">
                <button class="btn btn-link btn-block" type="button" data-toggle="collapse" data-target="#profile"
                        aria-expanded="true" aria-controls="collapseSeven">
                    <i class="fas fa-cogs"></i> Profil
                </button>
            </h3>
        </div>
        <div id="profile"
             class="collapse {{ Request::is('ucitel/profil/*') || Request::is('ucitel/profil') ? 'show': '' }}"
             aria-labelledby="profile" data-parent="#admin-menu">
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><a href="{{ route('admin.profil') }}">Upraviť profil</a></li>
                    <li class="list-group-item"><a href="{{ route('admin.profil.delete') }}">Vymazať profil</a></li>
                </ul>
            </div>
        </div>
    </div>

</div>
