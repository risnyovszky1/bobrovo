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
                <a class="btn btn-link btn-block text-left" href="{{ route('user.index') }}">
                    <i class="fas fa-user"></i> Používateľia
                </a>
            </div>
            <div id="users"
                 class="collapse {{ Request::is('ucitel/user/*') || Request::is('ucitel/user') ? 'show': '' }}"
                 aria-labelledby="news" data-parent="#admin-menu">
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><a href="{{ route('user.index') }}">Všetky používatelia</a></li>
                        <li class="list-group-item"><a href="{{ route('user.create') }}">Pridať používateľa</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header text-left">
                <a class="btn btn-link btn-block text-left" href="{{ route('news.index') }}">
                    <i class="far fa-newspaper"></i> Novinky
                </a>
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
                <a class="btn btn-link btn-block text-left" href="{{ route('faq.index') }}">
                    <i class="fas fa-book-open"></i> FAQ
                </a>
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
            <a class="btn btn-link btn-block text-left" href="{{ route('message.index') }}">
                <i class="far fa-comment"></i>
                @php
                    $newMessagesCount = newMessagesCount();
                @endphp
                Správy @if ($newMessagesCount) <span
                    class="badge badge-warning">{{ $newMessagesCount }}</span>@endif
            </a>
        </div>
        <div id="messeges"
             class="collapse {{ Request::is('ucitel/message/*') || Request::is('ucitel/message') ? 'show': '' }}"
             aria-labelledby="messeges" data-parent="#admin-menu">
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><a href="{{ route('message.index') }}">Všetky správy</a></li>
                    <li class="list-group-item"><a href="{{ route('message.create') }}">Napísať novú</a></li>
                </ul>
            </div>
        </div>
    </div>


    <div class="card">
        <div class="card-header text-left">
            <a class="btn btn-link btn-block text-left" href="{{ route('student.index' ) }}">
                <i class="fas fa-user-graduate"></i> Moje študenti
            </a>
        </div>
        <div id="students"
             class="collapse {{ Request::is('ucitel/student/*') || Request::is('ucitel/student') ? 'show': '' }}"
             aria-labelledby="students" data-parent="#admin-menu">
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><a href="{{ route('student.index' ) }}">Všetky študenti</a></li>
                    <li class="list-group-item"><a href="{{ route('student.create' ) }}">Pridaj nový</a></li>
                    <li class="list-group-item"><a href="{{ route('student.import' ) }}">Import zo súboru</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header text-left">
            <a class="btn btn-link btn-block text-left" href="{{ route('group.index') }}">
                <i class="fas fa-users"></i> Moje skupiny
            </a>
        </div>
        <div id="classes"
             class="collapse {{ Request::is('ucitel/group/*') || Request::is('ucitel/group') ? 'show': '' }}"
             aria-labelledby="classes" data-parent="#admin-menu">
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><a href="{{ route('group.index') }}">Všetky skupiny</a></li>
                    <li class="list-group-item"><a href="{{ route('group.create') }}">Pridaj novú</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header text-left">
            <a class="btn btn-link btn-block text-left" href="{{ route('test.index')}}">
                <i class="far fa-file-alt"></i> Moje testy
            </a>
        </div>
        <div id="tests" class="collapse {{ Request::is('ucitel/test/*') || Request::is('ucitel/test') ? 'show': '' }}"
             aria-labelledby="tests" data-parent="#admin-menu">
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><a href="{{ route('test.index')}}">Všetky testy</a></li>
                    <li class="list-group-item"><a href="{{ route('test.create') }}">Pridaj nový</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header text-left">
            <a class="btn btn-link btn-block text-left" href="{{ route('question.index') }}">
                <i class="far fa-question-circle"></i> Otázky
            </a>
        </div>
        <div id="questions"
             class="collapse {{ Request::is('ucitel/question/*') || Request::is('ucitel/question') ? 'show': '' }}"
             aria-labelledby="questions" data-parent="#admin-menu">
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><a href="{{ route('question.index') }}">Všetky otázky</a></li>
                    <li class="list-group-item"><a href="{{ route('question.index.my') }}">Moje otázky</a></li>
                    @if (auth()->user()->is_admin)
                        <li class="list-group-item"><a href="{{ route('question.index.other') }}">Otázky od iných</a>
                        </li>
                    @endif
                    <li class="list-group-item"><a href="{{ route('question.create') }}">Pridaj nový</a></li>
                    <li class="list-group-item"><a href="{{ route('question.filter') }}">Filter otázkov</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header text-left">
            <a class="btn btn-link btn-block text-left" href="{{ route('profil.edit') }}">
                <i class="fas fa-cogs"></i> Profil
            </a>
        </div>
    </div>

</div>
