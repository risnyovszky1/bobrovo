@section('title')
    Pridaj žiaka | Bobrovo
@endsection

@extends('admin.master')


@section('admin_content')


    <div class="row">
        <div class="col-lg-8 pt-3 pb-3">

            <div class="row">
                <div class="col-md-12">
                    <h2>Pridať žiaka</h2>
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
                    <form action="{{ route('student.store') }}" method="post">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="title">Meno</label>
                                <input type="text" name="first-name" id="first-name" class="form-control" value="{{ old('first-name') }}">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="desc">Priezvisko</label>
                                <input type="text" name="last-name" id="last-name" class="form-control" value="{{ old('last-name') }}">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group mb-0 col-md-6">
                                <div class="form-group mb-0">
                                    <label for="code">Kód</label>
                                    <input type="text" name="code" id="code-input" class="form-control" @if(old('code')) value="{{ old('code') }}" @else disabled @endif>
                                </div>

                                <div class="form-group form-check">
                                    <input type="checkbox" class="form-check-input" value="yes"
                                           name="generate-random-code" id="generate-random-code" @if(old('generate-random-code', 'yes')) checked="checked" @endif>
                                    <label class="form-check-label" for="generate-random-code">Generuj kód</label>
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="groups[]">Skupiny</label>
                            <select name="groups[]" id="group-select" class="form-control" multiple="mulptiple">
                                @foreach($groups as $group)
                                    <option value="{{ $group->id }}" {{ in_array($group->id, old('groups', [])) ? 'checked' : ''}}>{{ $group->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            @csrf
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
