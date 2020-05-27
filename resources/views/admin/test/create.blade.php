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
                    <form action="{{ route('test.store') }}" method="post">
                        <div class="form-group">
                            <label for="title">Názov</label>
                            <input type="text" name="title" id="title" class="form-control form-control-lg" value="{{ old('title') }}">
                        </div>

                        <div class="form-group">
                            <label for="group">Skupina</label>
                            <select name="group" id="add-to-group" class="form-control">
                                @foreach ($groups as $group)
                                    <option value="{{ $group->id }}" {{ old('group') ==  $group->id ? 'selected' : '' }}>{{ $group->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="desc">Popis</label>
                            <textarea name="desc" id="" rows="8" class="form-control wyswyg-editor"
                                      id="group-description">{{ old('desc') }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-lg-5">
                                <div class="form-group">
                                    <label for="available_from">Dostupný od</label>
                                    <div class="input-group form-datetime date">
                                        <input type="text" value="{{ old('available_from') }}" name="available_from" id="available_from"
                                               class="form-control">
                                        <div class="input-group-append ">
                                            <span class="input-group-text "><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="form-group">
                                    <label for="available_to">Dostupný do</label>
                                    <div class="input-group form-datetime date">
                                        <input type="text" value="{{ old('available_to') }}" name="available_to" id="available_to"
                                               class="form-control">
                                        <div class="input-group-append ">
                                            <span class="input-group-text "><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-2">
                                <div class="form-group">
                                    <label for="time_to_do">Čas</label>
                                    <select name="time_to_do" id="" class="form-control">
                                        <option value="">---</option>
                                        @for ($i = 0; $i < 15; $i++)
                                            <option value="{{ ($i + 1) * 5 }}" {{ old('time_to_do') ==  ($i + 1) * 5 ? 'selected' : '' }}>{{ ($i + 1) * 5 }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-checkbox custom-control-inline">
                                <input type="checkbox" class="custom-control-input" id="available-desc"
                                       name="available-desc" value="yes" {{ old('available-desc') ? 'checked' : '' }}>
                                <label class="custom-control-label" for="available-desc">Dostupný popis</label>
                            </div>

                            <div class="custom-control custom-checkbox custom-control-inline">
                                <input type="checkbox" class="custom-control-input" id="mix-questions"
                                       name="mix-questions" value="yes" {{ old('mix-questions') ? 'checked' : '' }}>
                                <label class="custom-control-label" for="mix-questions">Náhodné poradie otázkov</label>
                            </div>

                            <div class="custom-control custom-checkbox custom-control-inline">
                                <input type="checkbox" class="custom-control-input" id="available-ans"
                                       name="available-ans" value="yes" {{ old('available-ans') ? 'checked' : '' }}>
                                <label class="custom-control-label" for="available-ans">Dostupné odpoveďe</label>
                            </div>

                            <div class="custom-control custom-checkbox custom-control-inline">
                                <input type="checkbox" class="custom-control-input" id="public" name="public"
                                       value="yes" {{ old('public') ? 'checked' : '' }}>
                                <label class="custom-control-label" for="public">Verejný</label>
                            </div>
                        </div>

                        <div class="form-group">
                            @csrf
                            <a href="{{ route('test.index') }}" class="btn btn-lg btn-link">Zrušiť</a>
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
