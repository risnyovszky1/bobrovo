@section('title')
  Otázka| Bobrovo
@endsection

@extends('admin.master')

@section('admin_content')
  <div class="row">
    <div class="col-lg-8 pt-3 pb-3">
      <h2>Otázka</h2>
      

      <div class="card mt-3 border-primary">
        <div class="card-header bg-primary text-white">
          Názov
        </div>
        <div class="card-body">
            <h5 class="card-title mb-0">{{ $question->title }}</h5>
        </div>
      </div>

      <div class="card mt-3 border-success">
        <div class="card-header bg-success text-white">
          Otázka pre študenta
        </div>
        <div class="card-body">
            {!! $question->question !!}
        </div>
      </div>

      <div class="card mt-3 border-info">
        <div class="card-header bg-info text-white">
          Možné riešenia
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                {!! $question->answer == 'a' ? '<span class="text-success">'.  $question->a .' <i class="fas fa-check"></i></span>': '<span class="text-danger">'. $question->a .' <i class="fas fa-times"></i></span>' !!} 
            </li>
            <li class="list-group-item">
                {!! $question->answer == 'b' ? '<span class="text-success">'.  $question->b .' <i class="fas fa-check"></i></span>': '<span class="text-danger">'. $question->b .' <i class="fas fa-times"></i></span>' !!} 
            </li>
            <li class="list-group-item">
                {!! $question->answer == 'c' ? '<span class="text-success">'.  $question->c .' <i class="fas fa-check"></i></span>': '<span class="text-danger">'. $question->c .' <i class="fas fa-times"></i></span>' !!} 
            </li>
            <li class="list-group-item">
                {!! $question->answer == 'd' ? '<span class="text-success">'.  $question->d .' <i class="fas fa-check"></i></span>': '<span class="text-danger">'. $question->d .' <i class="fas fa-times"></i></span>' !!} 
            </li>
        </ul>
      </div>

      <div class="card mt-3 border-dark">
        <div class="card-header bg-dark text-white">
            Vysvetlenie pre učiteľa
        </div>
        <div class="card-body">
            {!! $question->description_teacher !!}
        </div>
      </div>

      <div class="card mt-3 border-secondary">
        <div class="card-header bg-secondary text-white">
            Vysvetlenie pre študenta
        </div>
        <div class="card-body">
            {!! $question->description !!}
        </div>
      </div>

      <code>
        <pre>
            @php
              var_dump($question)   
            @endphp
        </pre>
      </code>
      
    </div>
  </div>
@endsection


