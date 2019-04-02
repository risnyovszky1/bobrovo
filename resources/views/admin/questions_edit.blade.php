@section('title')
    Upraviť otázku | Bobrovo
@endsection

@extends('admin.master')


@section('admin_content')


<div class="row">
  <div class="col-lg-8 pt-3 pb-3">
        <h2>Upraviť otázku</h2>
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
          <div class="alert alert-success mb-2">
            {{ $success }}
          </div>
        </div>
      </div>
    @endif

    <form action="" method="post">
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label for="title">
              Názov
            </label>
            <input type="text" name="title" id="" class="form-control form-control-lg" value="{{$question->title}}">
          </div>
          <div class="form-group">
            <label for="question">
              Otázka
            </label>
            <textarea name="question" id="" rows="5" class="form-control">
                {{$question->question}}
            </textarea>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-8">
          <div class="form-group">
            <label for="answer-a" class="mb-0">Odpoveď A</label>
            <input type="text" name="answer-a" id="" class="form-control mb-2" value="{{$question->a}}">

            <label for="answer-b" class="mb-0">Odpoveď B</label>
            <input type="text" name="answer-b" id="" class="form-control mb-2" value="{{$question->b}}">

            <label for="answer-c" class="mb-0">Odpoveď C</label>
            <input type="text" name="answer-c" id="" class="form-control mb-2" value="{{$question->c}}">

            <label for="answer-d" class="mb-0">Odpoveď D</label>
            <input type="text" name="answer-d" id="" class="form-control mb-2" value="{{$question->d}}">
          </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label for="answer" class="mb-0">Odpoveď</label>
                <select name="answer" id="" class="form-control">
                    <option value="a" {{"a" == $question->answer ? 'selected' : ''}}>A</option>
                    <option value="b" {{"b" == $question->answer ? 'selected' : ''}}>B</option>
                    <option value="c" {{"c" == $question->answer ? 'selected' : ''}}>C</option>
                    <option value="d" {{"d" == $question->answer ? 'selected' : ''}}>D</option>
                </select>
            </div>

            <div class="form-group">
                <label for="type" class="mb-0">Typ</label>
                <select name="type" id="" class="form-control">
                    <option value="1" {{1 == $question->type ? 'selected' : ''}}>Pod seba</option>
                    <option value="2" {{2 == $question->type ? 'selected' : ''}}>Vedľa seba</option>
                    <option value="3" {{3 == $question->type ? 'selected' : ''}}>2x2</option>
                    <option value="4" {{4 == $question->type ? 'selected' : ''}}>Obrázok</option>
                    <option value="5" {{5 == $question->type ? 'selected' : ''}}>Interaktívna</option>
                </select>
            </div>

            <div class="form-group">
                <label for="difficulty" class="mb-0">Náročnosť</label>
                <select name="difficulty" id="" class="form-control">
                    @for ($i = 1; $i < 8; $i++)
                        <option value="{{$i}}" {{$i == $question->difficulty ? 'selected' : ''}}>{{$i}}</option>
                    @endfor
                </select>
            </div>
        </div>
      </div>

      <div class="row">
          <div class="col-md-12">
              <div class="form-group">
                    <label for="description">Vysvetlenie</label>
                    <textarea name="description" id="description" rows="5" class="form-control">{{$question->description}}</textarea>
              </div>

              <div class="form-group">
                    <label for="description_teacher">Vysvetlenie pre učiteľa</label>
                    <textarea name="description_teacher" id="description_teacher" rows="5" class="form-control">{{$question->description_teacher}}</textarea>
              </div>
            
          </div>
      </div>
      <div class="row">
        <div class="col-md-12">
            @if (Auth::user()->is_admin)
                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" name="public" value="yes" id="public" {{$question->public == true ? 'checked' : ''}}>
                        <label class="custom-control-label" for="public">Verejný</label>
                    </div>
                </div>
            @endif
          {{ csrf_field() }}
          <button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-save"></i> Uložiť zmeny</button>
        </div>
      </div>
    </form>
  </div>
</div>

@endsection
