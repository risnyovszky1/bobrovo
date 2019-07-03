@section('title')
  Upraviť FAQ | Bobrovo
@endsection

@extends('admin.master')


@section('admin_content')


<div class="row">
  <div class="col-lg-8 pt-3 pb-3">
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
          <h2>Upraviť</h2>
          <div class="form-group">
            <label for="answer">
              Otázka
            </label>
            <input type="text" name="question" id="" class="form-control form-control-lg" value="{{ $faq->question }}">
            <input type="hidden" name="faq-id" id="" class="form-control form-control-lg" value="{{ $faq->id }}">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <label for="answer">Odpoveď</label>
            <textarea name="answer" rows="8" class="form-control" id="faq-content-input">{{ $faq->answer }}</textarea>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12 pt-3">
          {{ csrf_field() }}
          <button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-save"></i> Uložiť zmeny</button>
        </div>
      </div>
    </form>
  </div>
</div>

@endsection
