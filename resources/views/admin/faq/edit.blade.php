@section('title')
    Upraviť FAQ | Bobrovo
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

            <form action="{{ route('faq.update', $faq) }}" method="POST">
                <div class="row">
                    <div class="col-md-12">
                        <h2>Upraviť</h2>
                        <div class="form-group">
                            <label for="answer">
                                Otázka
                            </label>
                            <input type="text" name="question" class="form-control form-control-lg"
                                   value="{{ old('question', $faq->question) }}">
                            <input type="hidden" name="faq-id" class="form-control form-control-lg"
                                   value="{{ $faq->id }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="answer">Odpoveď</label>
                            <tinymce
                                id="answer"
                                name="answer"
                                :content="`{{ old('answer', $faq->answer) }}`"
                            ></tinymce>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 pt-3">
                        @csrf
                        @method('PATCH')
                        <a href="{{ route('faq.index') }}" class="btn btn-lg btn-link">Zrušiť</a>
                        <button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-save"></i> Uložiť zmeny
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
