@section('title')
  Pridať test | Bobrovo
@endsection

@extends('admin.master')


@section('admin_content')


<div class="row">
  <div class="col-lg-8 pt-3 pb-3">

    <div class="row">
      <div class="col-md-12">
        <h2>Pridať test</h2>
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
          <div class="alert alert-success mb-2">
            {{ $success }}
          </div>
        </div>
      </div>
    @endif

    <div class="row">
      <div class="col-md-12">
        <form action="" method="post">
          <div class="form-group">
            <label for="title">Názov</label>
            <input type="text" name="title" id="title" class="form-control form-control-lg" value="">
          </div>

          <div class="form-group">
              <label for="group">Skupina</label>
              <select name="group" id="add-to-group" class="form-control">
                  @foreach ($groups as $group)
                    <option value="{{ $group->id }}">{{ $group->name }}</option>   
                  @endforeach
              </select>
          </div>

          <div class="form-group">
            <label for="desc">Popis</label>
            <textarea name="desc" id="" rows="8" class="form-control" id="group-description"></textarea>
          </div>

          <div class="row">
              <div class="col-md-6">
                  <div class="form-group">
                    <label for="available_from">Dostupný od</label>
                    <input type="text" value="" name="available_from" id="available_from" class="form-control">
                  </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                    <label for="available_to">Dostupný do</label>
                    <input type="text" value="" name="available_to" id="available_to" class="form-control">
                </div>
              </div>
          </div>

          <div class="form-group">
                <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input" id="available-desc" name="available-desc" value="yes">
                    <label class="custom-control-label" for="available-desc">Dostupný popis</label>
                </div>

                <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input" id="mix-questions" name="mix-questions" value="yes">
                    <label class="custom-control-label" for="mix-questions">Náhodné poradie otázkov</label>
                </div>

                <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input" id="available-ans" name="available-ans" value="yes">
                    <label class="custom-control-label" for="available-ans">Dostupné odpoveďe</label>
                </div>

                <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input" id="public" name="public" value="yes">
                    <label class="custom-control-label" for="public">Verejný</label>
                </div>
          </div>
          
          <div class="form-group">
            {{ csrf_field() }}
            <button type="submit" class="btn btn-lg btn-primary">
                <i class="fas fa-plus-circle"></i> Pridaj
              </button>
          </div>
          
        </form>
      </div>
    </div>
  </div>
</div>

@endsection
