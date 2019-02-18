@section('title')
  Skupina | Bobrovo
@endsection

@extends('admin.master')

@section('admin_content')
  <div class="row">
    <div class="col-lg-8 pt-3 pb-3">
      <h2>Skupina</h2>

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
          <h5 class="card-title mb-0">{{ $group->name }}</h5>
        </div>
      </div>

      <div class="card mt-3 border-secondary">
        <div class="card-header bg-secondary text-white">
          Popis
        </div>
        <div class="card-body">
          <p class="card-text">{{ $group->description }}</p>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6">
          <div class="card mt-3 border-info">
            <div class="card-header bg-info text-white">
              Vytvorený
            </div>
            <div class="card-body">
              <p class="card-text">{{ $group->created_at }}</p>
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="card mt-3 border-info">
            <div class="card-header bg-info text-white">
              Počet žiakov
            </div>
            <div class="card-body">
              <p class="card-text">{{ count($students) }}</p>
            </div>
          </div>
        </div>
      </div>

      <div class="card mt-3 border-success">
        <div class="card-header bg-success text-white">
          Žiaci
        </div>
        @if(count($students) > 0)
          <ul class="list-group list-group-flush">
            @foreach($students as $student)
              <li class="list-group-item">
                <a href="{{ route('students.profil', ['id' => $student->id ]) }}">{{ $student->first_name . ' ' . $student->last_name }}</a>
                <a href="{{ route('students.delete.from.group', ['student_id' => $student->id, 'group_id' => $group->id]) }}" class="float-right text-danger" title="Vymazať zo skupiny">
                      <i class="fas fa-trash"></i>
                </a>
              </li>
            @endforeach
          </ul>
        @else
          <div class="card-body">
            <p class="card-text">Ešte nemáte žiakov v skupine.</p>
          </div>
        @endif
      </div>

      <div class="form-group mt-3">
        <a href="{{ route('groups.edit', ['id' => $group->id]) }}" class="btn btn-primary"><i class="far fa-edit"></i> Upraviť</a>
      </div>
    </div>
  </div>
@endsection
