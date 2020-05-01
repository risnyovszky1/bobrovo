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

            <form action="{{ route('question.update', $question) }}" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="title">
                                Názov
                            </label>
                            <input type="text" name="title" id="" class="form-control form-control-lg"
                                   value="{{$question->title}}">
                        </div>
                        <div class="form-group">
                            <label for="question">
                                Otázka
                            </label>
                            <textarea name="question" id="" rows="5" class="form-control wyswyg-editor">
                {{$question->question}}
            </textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8">
                        <div class="form-group question-possibilities {{ $question->type <= 3 ? 'show' : 'hidden' }}"
                             id="text-ans">
                            <label for="answer-a" class="mb-0">Odpoveď A</label>
                            <input type="text" name="answer-a" id="" class="form-control mb-2" value="{{$question->a}}">

                            <label for="answer-b" class="mb-0">Odpoveď B</label>
                            <input type="text" name="answer-b" id="" class="form-control mb-2" value="{{$question->b}}">

                            <label for="answer-c" class="mb-0">Odpoveď C</label>
                            <input type="text" name="answer-c" id="" class="form-control mb-2" value="{{$question->c}}">

                            <label for="answer-d" class="mb-0">Odpoveď D</label>
                            <input type="text" name="answer-d" id="" class="form-control mb-2" value="{{$question->d}}">
                        </div>

                        <div class="form-group question-possibilities show {{ $question->type == 4 ? 'show' : 'hidden' }}"
                             id="pic-ans">
                            <div class="row">
                                <div class="col-md-12 mb-2">
                                    <span>A: </span>
                                    <img src="{{ $question->a }}" alt="answer img a"
                                         class="img-thumbnail d-inline-block mr-1 ml-1">
                                    <input type="file" name="answer-a-img" id=""
                                           class="form-control-file d-inline-block w-auto" value="">
                                </div>
                                <div class="col-md-12 mb-2">
                                    <span>B: </span>
                                    <img src="{{ $question->b }}" alt="answer img b"
                                         class="img-thumbnail d-inline-block mr-1 ml-1">
                                    <input type="file" name="answer-b-img" id=""
                                           class="form-control-file d-inline-block w-auto" value="">
                                </div>
                                <div class="col-md-12 mb-2">
                                    <span>C: </span>
                                    <img src="{{ $question->c }}" alt="answer img c"
                                         class="img-thumbnail d-inline-block mr-1 ml-1">
                                    <input type="file" name="answer-c-img" id=""
                                           class="form-control-file d-inline-block w-auto" value="">
                                </div>
                                <div class="col-md-12 mb-2">
                                    <span>D: </span>
                                    <img src="{{ $question->d }}" alt="answer img d"
                                         class="img-thumbnail d-inline-block mr-1 ml-1">
                                    <input type="file" name="answer-d-img" id=""
                                           class="form-control-file d-inline-block w-auto" value="">
                                </div>
                            </div>
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
                            <select name="type" id="" class="form-control disabled" disabled>
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
                            <textarea name="description" id="description" rows="5"
                                      class="form-control wyswyg-editor">{{$question->description}}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="description_teacher">Vysvetlenie pre učiteľa</label>
                            <textarea name="description_teacher" id="description_teacher" rows="5"
                                      class="form-control wyswyg-editor">{{$question->description_teacher}}</textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <h5>Téma</h5>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="category-1" name="category[]"
                                       value="1" {{ in_array(1, $categories) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="category-1">Informácie okolo nás</label>
                            </div>

                            <div class="pl-5 mt-1">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="category-6"
                                           name="category[]" value="6" {{ in_array(6, $categories) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="category-6">kódovanie, šifrovanie,
                                        komprimácia informácie</label>
                                </div>

                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="category-7"
                                           name="category[]" value="7" {{ in_array(7, $categories) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="category-7">číselné sústavy,
                                        prevody</label>
                                </div>

                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="category-8"
                                           name="category[]" value="8" {{ in_array(8, $categories) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="category-8">reprezentácia údajov v počítači
                                        - diagramy, čísla, znaky a vzťahy medzi nimi</label>
                                </div>

                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="category-9"
                                           name="category[]" value="9" {{ in_array(9, $categories) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="category-9">vyhľadávanie opakujúcich sa
                                        vzorov</label>
                                </div>

                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="category-10"
                                           name="category[]"
                                           value="10" {{ in_array(10, $categories) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="category-10">informácie zobrazené pomocou
                                        údajových štruktúr - strom, graf, zásobník</label>
                                </div>

                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="category-11"
                                           name="category[]"
                                           value="11" {{ in_array(11, $categories) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="category-11">výroková logika a jej
                                        využívanie pri práci s informáciami, kombinatorika</label>
                                </div>
                            </div>

                            <div class="pl-4 mt-2 mb-1">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="category-12"
                                           name="category[]"
                                           value="12" {{ in_array(12, $categories) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="category-12">textová informácia -
                                        kompetencie potrebné na prácu v textovom editore</label>
                                </div>

                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="category-13"
                                           name="category[]"
                                           value="13" {{ in_array(13, $categories) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="category-13">grafická informácia -
                                        kompetencie potrebné na prácu v grafickom editore</label>
                                </div>

                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="category-14"
                                           name="category[]"
                                           value="14" {{ in_array(14, $categories) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="category-14">číselná informácia -
                                        kompetencie potrebné na prácu v tabuľkovom editore</label>
                                </div>

                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="category-15"
                                           name="category[]"
                                           value="15" {{ in_array(15, $categories) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="category-15">zvuková informácia -
                                        kompetencie potrebné na prácu v zvukovom editore</label>
                                </div>

                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="category-16"
                                           name="category[]"
                                           value="16" {{ in_array(16, $categories) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="category-16">prezentácia informácií -
                                        kompetencie potrebné na tvorbu prezentácií</label>
                                </div>

                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="category-17"
                                           name="category[]"
                                           value="17" {{ in_array(17, $categories) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="category-17">prezentácia informácií na webe
                                        - kompetencie potrebné na tvorbu webových stránok</label>
                                </div>
                            </div>

                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="category-2" name="category[]"
                                       value="2" {{ in_array(2, $categories) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="category-2">Komunikácia prostredníctvom
                                    digitálnych technológií</label>
                            </div>

                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="category-3" name="category[]"
                                       value="3" {{ in_array(3, $categories) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="category-3">Postupy, riešenie problémov,
                                    algoritmické myslenie</label>
                            </div>

                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="category-4" name="category[]"
                                       value="4" {{ in_array(4, $categories) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="category-4">Princípy fungovania digitálnych
                                    technológií</label>
                            </div>

                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="category-5" name="category[]"
                                       value="5" {{ in_array(5, $categories) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="category-5">Informačná spoločnosť</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" name="public" value="yes"
                                       id="public" {{$question->public == true ? 'checked' : ''}} {{Auth::user()->is_admin ? '' : 'disabled'}}>
                                <label class="custom-control-label" for="public">Verejný</label>
                            </div>
                        </div>
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-save"></i> Uložiť zmeny
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
