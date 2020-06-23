@section('title')
    Pridať otázku | Bobrovo
@endsection

@extends('admin.master')


@section('admin_content')


    <div class="row">
        <div class="col-lg-8 pt-3 pb-3">
            <h2>Pridať otázku</h2>


            @if(!empty($success))
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-success mb-2">
                            {{ $success }}
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('question.store') }}" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="title">
                                Názov
                            </label>
                            <input type="text" name="title" id="" class="form-control form-control-lg"
                                   value="{{ old('title') }}">
                        </div>
                        <div class="form-group">
                            <label for="question">
                                Otázka
                            </label>
                            <tinymce
                                id="question"
                                name="question"
                                :content="`{{ old('question') }}`"
                            ></tinymce>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8">
                        <div class="form-group question-possibilities show" id="text-ans">
                            <label for="answer-a" class="mb-0">Odpoveď A</label>
                            <input type="text" name="answer-a" id="" class="form-control mb-2"
                                   value="{{ old('answer-a') }}">

                            <label for="answer-b" class="mb-0">Odpoveď B</label>
                            <input type="text" name="answer-b" id="" class="form-control mb-2"
                                   value="{{ old('answer-b') }}">

                            <label for="answer-c" class="mb-0">Odpoveď C</label>
                            <input type="text" name="answer-c" id="" class="form-control mb-2"
                                   value="{{ old('answer-c') }}">

                            <label for="answer-d" class="mb-0">Odpoveď D</label>
                            <input type="text" name="answer-d" id="" class="form-control mb-2"
                                   value="{{ old('answer-d') }}">
                        </div>

                        <div class="form-group question-possibilities hidden" id="picture-ans">
                            <label for="answer-a" class="mb-0">Odpoveď A</label>
                            <input type="file" name="answer-a-img" id="" class="form-control-file mb-2" value="">

                            <label for="answer-b" class="mb-0">Odpoveď B</label>
                            <input type="file" name="answer-b-img" id="" class="form-control-file mb-2" value="">

                            <label for="answer-c" class="mb-0">Odpoveď C</label>
                            <input type="file" name="answer-c-img" id="" class="form-control-file mb-2" value="">

                            <label for="answer-d" class="mb-0">Odpoveď D</label>
                            <input type="file" name="answer-d-img" id="" class="form-control-file mb-2" value="">
                        </div>

                        <div class="form-group question-possibilities hidden" id="interactive-ans">
                            <label for="answer-a" class="mb-0">JS súbor</label>
                            <input type="file" name="answer-a-js" id="" class="form-control-file mb-2" value="">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="answer" class="mb-0">Odpoveď</label>
                            <select name="answer" id="" class="form-control">
                                <option value="a" {{ old('answer') == 'a' ? 'selected' : '' }}>A</option>
                                <option value="b" {{ old('answer') == 'b' ? 'selected' : '' }}>B</option>
                                <option value="c" {{ old('answer') == 'c' ? 'selected' : '' }}>C</option>
                                <option value="d" {{ old('answer') == 'd' ? 'selected' : '' }}>D</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="type" class="mb-0">Typ</label>
                            <select name="type" id="question-type" class="form-control">
                                <option value="1" {{ old('type') == '1' ? 'selected' : '' }}>Pod seba</option>
                                <option value="2" {{ old('type') == '2' ? 'selected' : '' }}>Vedľa seba</option>
                                <option value="3" {{ old('type') == '3' ? 'selected' : '' }}>2x2</option>
                                <option value="4" {{ old('type') == '4' ? 'selected' : '' }}>Obrázok</option>
                                <option value="5" {{ old('type') == '5' ? 'selected' : '' }}>Interaktívna</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="difficulty" class="mb-0">Náročnosť</label>
                            <select name="difficulty" id="" class="form-control">
                                @for ($i = 1; $i < 8; $i++)
                                    <option
                                        value="{{$i}}" {{ old('difficulty') == $i ? 'selected' : '' }}>{{$i}}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="description">Vysvetlenie</label>
                            <tinymce
                                id="description"
                                name="description"
                                :content="`{{ old('description') }}`"
                            ></tinymce>
                        </div>

                        <div class="form-group">
                            <label for="description_teacher">Vysvetlenie pre učiteľa</label>
                            <tinymce
                                id="description_teacher"
                                name="description_teacher"
                                :content="`{{ old('description_teacher') }}`"
                            ></tinymce>
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <h5>Téma</h5>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="category-1" name="category[]"
                                       value="1" {{ in_array('1', old('category', [])) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="category-1">Informácie okolo nás</label>
                            </div>

                            <div class="pl-5 mt-1">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="category-6"
                                           name="category[]"
                                           value="6" {{ in_array('6', old('category', [])) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="category-6">kódovanie, šifrovanie,
                                        komprimácia informácie</label>
                                </div>

                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="category-7"
                                           name="category[]"
                                           value="7" {{ in_array('7', old('category', [])) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="category-7">číselné sústavy,
                                        prevody</label>
                                </div>

                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="category-8"
                                           name="category[]"
                                           value="8" {{ in_array('8', old('category', [])) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="category-8">reprezentácia údajov v počítači
                                        - diagramy, čísla, znaky a vzťahy medzi nimi</label>
                                </div>

                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="category-9"
                                           name="category[]"
                                           value="9" {{ in_array('9', old('category', [])) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="category-9">vyhľadávanie opakujúcich sa
                                        vzorov</label>
                                </div>

                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="category-10"
                                           name="category[]"
                                           value="10" {{ in_array('10', old('category', [])) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="category-10">informácie zobrazené pomocou
                                        údajových štruktúr - strom, graf, zásobník</label>
                                </div>

                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="category-11"
                                           name="category[]"
                                           value="11" {{ in_array('11', old('category', [])) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="category-11">výroková logika a jej
                                        využívanie pri práci s informáciami, kombinatorika</label>
                                </div>
                            </div>

                            <div class="pl-4 mt-2 mb-1">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="category-12"
                                           name="category[]"
                                           value="12" {{ in_array('12', old('category', [])) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="category-12">textová informácia -
                                        kompetencie potrebné na prácu v textovom editore</label>
                                </div>

                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="category-13"
                                           name="category[]"
                                           value="13" {{ in_array('13', old('category', [])) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="category-13">grafická informácia -
                                        kompetencie potrebné na prácu v grafickom editore</label>
                                </div>

                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="category-14"
                                           name="category[]"
                                           value="14" {{ in_array('14', old('category', [])) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="category-14">číselná informácia -
                                        kompetencie potrebné na prácu v tabuľkovom editore</label>
                                </div>

                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="category-15"
                                           name="category[]"
                                           value="15" {{ in_array('15', old('category', [])) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="category-15">zvuková informácia -
                                        kompetencie potrebné na prácu v zvukovom editore</label>
                                </div>

                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="category-16"
                                           name="category[]"
                                           value="16" {{ in_array('16', old('category', [])) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="category-16">prezentácia informácií -
                                        kompetencie potrebné na tvorbu prezentácií</label>
                                </div>

                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="category-17"
                                           name="category[]"
                                           value="17" {{ in_array('1', old('category', []))  ? 'checked' : ''}}>
                                    <label class="custom-control-label" for="category-17">prezentácia informácií na webe
                                        - kompetencie potrebné na tvorbu webových stránok</label>
                                </div>
                            </div>

                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="category-2" name="category[]"
                                       value="2" {{ in_array('2', old('category', [])) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="category-2">Komunikácia prostredníctvom
                                    digitálnych technológií</label>
                            </div>

                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="category-3" name="category[]"
                                       value="3" {{ in_array('3', old('category', [])) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="category-3">Postupy, riešenie problémov,
                                    algoritmické myslenie</label>
                            </div>

                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="category-4" name="category[]"
                                       value="4" {{ in_array('4', old('category', [])) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="category-4">Princípy fungovania digitálnych
                                    technológií</label>
                            </div>

                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="category-5" name="category[]"
                                       value="5" {{ in_array('5', old('category', [])) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="category-5">Informačná spoločnosť</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        @if (Auth::user()->is_admin)
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="public" value="yes"
                                           id="public" {{ old('public') == 'yes' ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="public">Verejný</label>
                                </div>
                            </div>
                        @endif
                        @csrf
                        <a href="{{ route('question.index') }}" class="btn btn-lg btn-link">Zrušiť</a>
                        <button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-save"></i> Uložiť</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
