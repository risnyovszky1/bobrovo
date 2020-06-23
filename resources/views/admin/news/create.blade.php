@section('title')
    Pridaj novinku | Bobrovo
@endsection

@extends('admin.master')


@section('admin_content')


    <div class="row">
        <div class="col-lg-8 pt-3 pb-3">
            @if(!empty($success))
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-success mb-2">
                            {{ $success }}
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('news.store') }}" method="post">
                <div class="row">
                    <div class="col-md-12">
                        <h2>Pidať novinku</h2>
                        <div class="form-group">
                            <label for="title">
                                Názov
                            </label>
                            <input type="text" name="content" id="" class="form-control form-control-lg" value="{{old('content')}}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="content">Text</label>
                            <tinymce
                                id="content"
                                name="content"
                                :content="`{{ old('content') }}`"
                            ></tinymce>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="custom-control custom-radio">
                            <input type="radio" id="customRadio1" name="is-visible" value="yes"
                                   class="custom-control-input" @if(old('is-visible') == 'yes') checked @endif>
                            <label class="custom-control-label" for="customRadio1">Visible</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="customRadio2" name="is-visible" value="no"
                                   class="custom-control-input" @if(old('is-visible') == 'noe') checked @endif>
                            <label class="custom-control-label" for="customRadio2">Not visible</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 pt-3">
                        @csrf
                        <a href="{{ route('news.index') }}" class="btn btn-lg btn-link">Zrušiť</a>
                        <button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-plus-circle"></i> Pridaj
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
