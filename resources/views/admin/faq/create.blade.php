@section('title')
    Pridaj FAQ | Bobrovo
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

            <form action="{{ route('faq.store') }}" method="post">
                <div class="row">
                    <div class="col-md-12">
                        <h2>Pidať FAQ</h2>
                        <div class="form-group">
                            <label for="answer">
                                Otázka
                            </label>
                            <input type="text" name="question" id="" class="form-control form-control-lg" value="{{old('question')}}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="answer">Odpoveď</label>
                            <textarea name="answer" rows="8" class="form-control" id="faq-content-input">{{old('answer')}}</textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 pt-3">
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-plus-circle"></i> Pridaj
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
