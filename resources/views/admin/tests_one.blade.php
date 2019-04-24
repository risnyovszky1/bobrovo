@section('title')
  Test | Bobrovo
@endsection

@extends('admin.master')

@section('admin_content')
  <div class="row">
    <div class="col-lg-8 pt-3 pb-3">
      <h2>Test</h2>

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

      <div class="card mt-3 border-primary">
        <div class="card-header bg-primary text-white">
          Názov
        </div>
        <div class="card-body">
            <h5 class="card-title mb-0">{{ $test->name}}</h5>
        </div>
      </div>

      <div class="card mt-3 border-success">
          <div class="card-header bg-success text-white">
              Skupina
          </div>
          <div class="card-body">
            <p class="card-text">
                <a href="{{ route('groups.one', ['id' => $test->group_id]) }}" title="Skupina {{ $test->group_name }}">
                    {{ $test->group_name }}
                </a>
            </p>
          </div>
      </div>

      <div class="card mt-3 border-info">
        <div class="card-header bg-info text-white">
          Popis
        </div>
        <div class="card-body">
            {!! $test->description !!}
        </div>
      </div>

      <div class="row">
          <div class="col-md-4">
            <div class="card mt-3">
                <div class="card-header">
                    Odkedy je dostupný
                </div>
                <div class="card-body">
                    <p class="card-text">
                        {{ $test->available_from }}
                    </p>  
                </div>
            </div>
          </div>

          <div class="col-md-4">
            <div class="card mt-3">
                <div class="card-header">
                    Dokedy je dostupný
                </div>
                <div class="card-body">
                    <p class="card-text">
                        {{ $test->available_to }}
                    </p>  
                </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card mt-3">
              <div class="card-header">
                Čas na vypracovanie
              </div>
              <div class="card-body">
                  {{ $test->time_to_do }} min.
              </div>
            </div>
          </div>
      </div>
      
      <div class="card mt-3 border-secondary">
        <div class="card-header text-white bg-secondary">
            Nastavenia
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                Dostupný popis k otázku: {!! $test->available_description ? '<span class="text-success">Áno <i class="fas fa-check"></i></span>' : '<span class="text-danger">Nie <i class="fas fa-times"></i></span>' !!}
            </li>
            <li class="list-group-item">
                Náhodné poradie otázkov: 
                {!! $test->mix_questions ? '<span class="text-success">Áno <i class="fas fa-check"></i></span>' : '<span class="text-danger">Nie <i class="fas fa-times"></i></span>' !!}
            </li>
            <li class="list-group-item">
                Dostupné správne riešenia: 
                {!! $test->available_answers ? '<span class="text-success">Áno <i class="fas fa-check"></i></span>' : '<span class="text-danger">Nie <i class="fas fa-times"></i></span>' !!}
            </li>
            <li class="list-group-item">
                Verejný: 
                {!! $test->public ? '<span class="text-success">Áno <i class="fas fa-check"></i></span>' : '<span class="text-danger">Nie <i class="fas fa-times"></i></span>' !!}
            </li>
        </ul>
      </div>

      @if (!empty($questions) && count($questions) > 0)
        <div class="card mt-3 border-dark">
            <div class="card-header text-white bg-dark">
                Otázky na teste
            </div>
            <ul class="list-group list-group-flush">
                @foreach ($questions as $item)
                    <li class="list-group-item">
                      <a href="{{ route('questions.one', ['id' => $item->id ]) }}">{{ $item->title }}</a>
                      <a href="{{ route('tests.delete.question', ['test_id'=> $test->id, 'question_id'=> $item->id]) }}" class="float-right text-danger" title="Vymazať z testu">
                        <i class="fas fa-trash"></i>
                      </a>
                    </li>
                @endforeach
            </ul>
        </div>
      @endif
      

      <div class="form-group mt-3">
        <a href="{{ route('tests.edit', ['id' => $test->id]) }}" class="btn btn-primary"><i class="far fa-edit"></i> Upraviť</a>
        <a href="{{ route('tests.results', ['id' => $test->id]) }}" class="btn btn-success"><i class="fas fa-poll"></i> Výsledky</a>
        
      </div>

        


      
    </div>
  </div>
@endsection
