@extends('student.master')

@section('title')
    Otázka | Bobrovo
@endsection

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 pt-5">

          @if (!empty($errors))
              @foreach ($errors->all() as $err)
                <div class="alert alert-danger mb-4">Potrebuješ označiť odpoveď!</div>
              @endforeach
          @endif

            <div class="question-container">
                <form action="" method="post">
                    <div class="card mb-3 border-danger">
                        <div class="card-header bg-danger text-white">
                            Otázka
                        </div>
                        <div class="card-body font-lg">
                            {!!$question->question!!}                            
                        </div>
                    </div>
                    @if (Session::get('testSettings')->available_description && !empty($question->description) && strlen($question->description))
                        <div class="card mb-3 border-secondary">
                            <div class="card-header bg-secondary text-white">
                                Popis
                            </div>
                            <div class="card-body">
                                {!!$question->description!!}                            
                            </div>
                        </div>
                    @endif
                    

                    @switch($question->type)
                        @case(1)
                            <div class="form-group">
                                <div class="answer-wrapper border rounded border-primary bg-white pt-2 pb-2 pl-3 pr-3 mb-2">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="customRadio-{{$question->id}}a" value="a" name="answer-{{$question->id}}" class="custom-control-input" {{ !empty($answer) && $answer->answer == 'a' ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="customRadio-{{$question->id}}a">{{$question->a}}</label>
                                    </div>
                                </div>
                                <div class="answer-wrapper border rounded border-primary bg-white pt-2 pb-2 pl-3 pr-3 mb-2">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="customRadio-{{$question->id}}b" value="b" name="answer-{{$question->id}}" class="custom-control-input" {{ !empty($answer) && $answer->answer == 'b' ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="customRadio-{{$question->id}}b">{{$question->b}}</label>
                                    </div>
                                </div>
                                <div class="answer-wrapper border rounded border-primary bg-white pt-2 pb-2 pl-3 pr-3 mb-2">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="customRadio-{{$question->id}}c" value="c" name="answer-{{$question->id}}" class="custom-control-input" {{ !empty($answer) && $answer->answer == 'c' ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="customRadio-{{$question->id}}c">{{$question->c}}</label>
                                    </div>
                                </div>
                                <div class="answer-wrapper border rounded border-primary bg-white pt-2 pb-2 pl-3 pr-3 mb-2">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="customRadio-{{$question->id}}d" value="d" name="answer-{{$question->id}}" class="custom-control-input" {{ !empty($answer) && $answer->answer == 'd' ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="customRadio-{{$question->id}}d">{{$question->d}}</label>
                                    </div>
                                </div>
                            </div>
                            @break
                        @case(2)
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="answer-wrapper border rounded border-primary bg-white pt-2 pb-2 pl-3 pr-3 mb-2">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="customRadio-{{$question->id}}a" value="a" name="answer-{{$question->id}}" class="custom-control-input" {{ !empty($answer) && $answer->answer == 'a' ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="customRadio-{{$question->id}}a">{{$question->a}}</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="answer-wrapper border rounded border-primary bg-white pt-2 pb-2 pl-3 pr-3 mb-2">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="customRadio-{{$question->id}}b" value="b" name="answer-{{$question->id}}" class="custom-control-input" {{ !empty($answer) && $answer->answer == 'b' ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="customRadio-{{$question->id}}b">{{$question->b}}</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="answer-wrapper border rounded border-primary bg-white pt-2 pb-2 pl-3 pr-3 mb-2">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="customRadio-{{$question->id}}c" value="c" name="answer-{{$question->id}}" class="custom-control-input" {{ !empty($answer) && $answer->answer == 'c' ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="customRadio-{{$question->id}}c">{{$question->c}}</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="answer-wrapper border rounded border-primary bg-white pt-2 pb-2 pl-3 pr-3 mb-2">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="customRadio-{{$question->id}}d" value="d" name="answer-{{$question->id}}" class="custom-control-input" {{ !empty($answer) && $answer->answer == 'd' ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="customRadio-{{$question->id}}d">{{$question->d}}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @break
                        @case(3)
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="answer-wrapper border rounded border-primary bg-white pt-2 pb-2 pl-3 pr-3 mb-2">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="customRadio-{{$question->id}}a" value="a" name="answer-{{$question->id}}" class="custom-control-input" {{ !empty($answer) && $answer->answer == 'a' ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="customRadio-{{$question->id}}a">{{$question->a}}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="answer-wrapper border rounded border-primary bg-white pt-2 pb-2 pl-3 pr-3 mb-2">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="customRadio-{{$question->id}}b" value="b" name="answer-{{$question->id}}" class="custom-control-input" {{ !empty($answer) && $answer->answer == 'b' ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="customRadio-{{$question->id}}b">{{$question->b}}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="answer-wrapper border rounded border-primary bg-white pt-2 pb-2 pl-3 pr-3 mb-2">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="customRadio-{{$question->id}}c" value="c" name="answer-{{$question->id}}" class="custom-control-input" {{ !empty($answer) && $answer->answer == 'c' ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="customRadio-{{$question->id}}c">{{$question->c}}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="answer-wrapper border rounded border-primary bg-white pt-2 pb-2 pl-3 pr-3 mb-2">
                                        <div class="custom-control custom-radio">
                                            <input type="radio" id="customRadio-{{$question->id}}d" value="d" name="answer-{{$question->id}}" class="custom-control-input" {{ !empty($answer) && $answer->answer == 'd' ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="customRadio-{{$question->id}}d">{{$question->d}}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @break
                        @case(4)
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="answer-wrapper border rounded border-primary bg-white pt-2 pb-2 pl-3 pr-3 mb-2">
                                        <div class="custom-control custom-radio question-img-type">
                                            <input type="radio" id="customRadio-{{$question->id}}a" value="a" name="answer-{{$question->id}}" class="custom-control-input" {{ !empty($answer) && $answer->answer == 'a' ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="customRadio-{{$question->id}}a">
                                                <img src="{{$question->a}}" alt="odpoveď A">
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="answer-wrapper border rounded border-primary bg-white pt-2 pb-2 pl-3 pr-3 mb-2">
                                        <div class="custom-control custom-radio question-img-type">
                                            <input type="radio" id="customRadio-{{$question->id}}b" value="b" name="answer-{{$question->id}}" class="custom-control-input" {{ !empty($answer) && $answer->answer == 'b' ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="customRadio-{{$question->id}}b">
                                                <img src="{{$question->b}}" alt="odpoveď B">
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="answer-wrapper border rounded border-primary bg-white pt-2 pb-2 pl-3 pr-3 mb-2">
                                        <div class="custom-control custom-radio question-img-type">
                                            <input type="radio" id="customRadio-{{$question->id}}c" value="c" name="answer-{{$question->id}}" class="custom-control-input" {{ !empty($answer) && $answer->answer == 'c' ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="customRadio-{{$question->id}}c">
                                                <img src="{{$question->c}}" alt="odpoveď C">
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="answer-wrapper border rounded border-primary bg-white pt-2 pb-2 pl-3 pr-3 mb-2">
                                        <div class="custom-control custom-radio question-img-type">
                                            <input type="radio" id="customRadio-{{$question->id}}d" value="d" name="answer-{{$question->id}}" class="custom-control-input" {{ !empty($answer) && $answer->answer == 'd' ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="customRadio-{{$question->id}}d">
                                                <img src="{{$question->d}}" alt="odpoveď D">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @default
                            
                    @endswitch
                    <div class="form-group mt-4">
                        {{ csrf_field() }}
                        <input type="hidden" name="question-id" id="" value="{{ $question->id }}">
                        <button type="submit" class="btn btn-lg btn-primary"><i class="fas fa-save"></i> Uložiť odpoveď</button>
                    </div>
                    <hr>
                </form>
            </div>
        </div>

        <div class="col-md-4 pt-5">
            @include('student.side_menu')
        </div>
    </div>
</div>   

<script>
$(document).ready(function() {
    $.ajaxSetup({
        beforeSend: function(xhr, type) {
            if (!type.crossDomain) {
                xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
            }
        },
    });
    var start = new Date();
    $(window).on('unload', function(e){
        var end = new Date();
        var time = (end - start) / 1000;
        $.ajax({ 
        method: "GET",
        url: "/ziak/measure",
        data: {
            test_id: {{ Session::get('testSettings')->id }},
            question_id: {{ $question->id }},
            time: time.toFixed(2),
            _token: $('meta[name="csrf-token"]').attr('content'),
            },
        async: false
        });
    });
});

</script>

@endsection
