@section('title')
    Filter | Bobrovo
@endsection

@extends('admin.master')


@section('admin_content')
    <div class="admin-panel pt-2 pb-2">
        <h2>Filter</h2>

        <div class="row">
            <div class="col-lg-8 pt-2">
                <div id="filter">

                    @php
                        $filter = Session::get('questionFilter');
                        $category = !empty($filter['category']) ? $filter['category'] : null;
                        $type = !empty($filter['type']) ? $filter['type'] : null;
                        $diffFrom = !empty($filter['difficulty_from']) ? $filter['difficulty_from'] : null;
                        $diffTo = !empty($filter['difficulty_to']) ? $filter['difficulty_to'] : null;
                        $order = !empty($filter['order']) ? $filter['order'] : null;
                    @endphp

                    <form action="" method="post">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-8">
                                    <h5>Téma</h5>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="category-1"
                                               name="category[]"
                                               value="1" {{ $category && in_array(1, $category) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="category-1">Informácie okolo
                                            nás</label>
                                    </div>

                                    <div class="pl-5 mt-1">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="category-6"
                                                   name="category[]"
                                                   value="6" {{ $category && in_array(6, $category) ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="category-6">kódovanie, šifrovanie,
                                                komprimácia informácie</label>
                                        </div>

                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="category-7"
                                                   name="category[]"
                                                   value="7" {{ $category && in_array(7, $category) ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="category-7">číselné sústavy,
                                                prevody</label>
                                        </div>

                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="category-8"
                                                   name="category[]"
                                                   value="8" {{ $category && in_array(8, $category) ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="category-8">reprezentácia údajov v
                                                počítači - diagramy, čísla, znaky a vzťahy medzi nimi</label>
                                        </div>

                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="category-9"
                                                   name="category[]"
                                                   value="9" {{ $category && in_array(9, $category) ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="category-9">vyhľadávanie
                                                opakujúcich sa vzorov</label>
                                        </div>

                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="category-10"
                                                   name="category[]"
                                                   value="10" {{ $category && in_array(10, $category) ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="category-10">informácie zobrazené
                                                pomocou údajových štruktúr - strom, graf, zásobník</label>
                                        </div>

                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="category-11"
                                                   name="category[]"
                                                   value="11" {{ $category && in_array(11, $category) ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="category-11">výroková logika a jej
                                                využívanie pri práci s informáciami, kombinatorika</label>
                                        </div>
                                    </div>

                                    <div class="pl-4 mt-2 mb-1">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="category-12"
                                                   name="category[]"
                                                   value="12" {{ $category && in_array(12, $category) ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="category-12">textová informácia -
                                                kompetencie potrebné na prácu v textovom editore</label>
                                        </div>

                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="category-13"
                                                   name="category[]"
                                                   value="13" {{ $category && in_array(13, $category) ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="category-13">grafická informácia -
                                                kompetencie potrebné na prácu v grafickom editore</label>
                                        </div>

                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="category-14"
                                                   name="category[]"
                                                   value="14" {{ $category && in_array(14, $category) ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="category-14">číselná informácia -
                                                kompetencie potrebné na prácu v tabuľkovom editore</label>
                                        </div>

                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="category-15"
                                                   name="category[]"
                                                   value="15" {{ $category && in_array(15, $category) ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="category-15">zvuková informácia -
                                                kompetencie potrebné na prácu v zvukovom editore</label>
                                        </div>

                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="category-16"
                                                   name="category[]"
                                                   value="16" {{ $category && in_array(16, $category) ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="category-16">prezentácia informácií
                                                - kompetencie potrebné na tvorbu prezentácií</label>
                                        </div>

                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="category-17"
                                                   name="category[]"
                                                   value="17" {{ $category && in_array(17, $category) ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="category-17">prezentácia informácií
                                                na webe - kompetencie potrebné na tvorbu webových stránok</label>
                                        </div>
                                    </div>

                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="category-2"
                                               name="category[]"
                                               value="2" {{ $category && in_array(2, $category) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="category-2">Komunikácia prostredníctvom
                                            digitálnych technológií</label>
                                    </div>

                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="category-3"
                                               name="category[]"
                                               value="3" {{ $category && in_array(3, $category) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="category-3">Postupy, riešenie
                                            problémov, algoritmické myslenie</label>
                                    </div>

                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="category-4"
                                               name="category[]"
                                               value="4" {{ $category && in_array(4, $category) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="category-4">Princípy fungovania
                                            digitálnych technológií</label>
                                    </div>

                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="category-5"
                                               name="category[]"
                                               value="5" {{ $category && in_array(5, $category) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="category-5">Informačná
                                            spoločnosť</label>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <h5>Zoradiť podľa</h5>
                                    <div class="form-group">
                                        <select name="order" id="order" class="form-control">
                                            <option value="1" {{ $order && $order == 1 ? 'selected' : '' }}>Podľa
                                                názvu
                                            </option>
                                            <option value="2" {{ $order && $order == 2 ? 'selected' : '' }}>Podľa počtu
                                                kommentov
                                            </option>
                                            <option value="3" {{ $order && $order == 3 ? 'selected' : '' }}>Podľa
                                                hodnetiní
                                            </option>
                                            <option value="4" {{ $order && $order == 4 ? 'selected' : '' }}>Podľa počtu
                                                hodnotení
                                            </option>
                                            <option value="5" {{ $order && $order == 5 ? 'selected' : '' }}>Podľa
                                                použití v testoch
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="difficulty_from">Náročnosť od:</label>
                                    <select name="difficulty_from" id="difficulty_from" class="form-control">
                                        <option value="1" {{ $diffFrom == 1 ? 'selected' : ''}}>1</option>
                                        <option value="2" {{ $diffFrom == 2 ? 'selected' : ''}}>2</option>
                                        <option value="3" {{ $diffFrom == 3 ? 'selected' : ''}}>3</option>
                                        <option value="4" {{ $diffFrom == 4 ? 'selected' : ''}}>4</option>
                                        <option value="5" {{ $diffFrom == 5 ? 'selected' : ''}}>5</option>
                                        <option value="6" {{ $diffFrom == 6 ? 'selected' : ''}}>6</option>
                                        <option value="7" {{ $diffFrom == 7 ? 'selected' : ''}}>7</option>
                                    </select>
                                </div>

                                <div class="col-sm-6">
                                    <label for="difficulty_to">Náročnosť do:</label>
                                    <select name="difficulty_to" id="difficulty_to" class="form-control">
                                        <option value="1" {{ $diffTo == 1 ? 'selected' : ''}}>1</option>
                                        <option value="2" {{ $diffTo == 2 ? 'selected' : ''}}>2</option>
                                        <option value="3" {{ $diffTo == 3 ? 'selected' : ''}}>3</option>
                                        <option value="4" {{ $diffTo == 4 ? 'selected' : ''}}>4</option>
                                        <option value="5" {{ $diffTo == 5 ? 'selected' : ''}}>5</option>
                                        <option value="6" {{ $diffTo == 6 ? 'selected' : ''}}>6</option>
                                        <option value="7" {{ $diffTo == 7 || $diffTo == null ? 'selected' : ''}}>7
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <h5>Typ</h5>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="no-interactive" name="type" class="custom-control-input"
                                       value="no-interactive" {{ $type && $type == 'no-interactive' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="no-interactive">bez interaktívnych</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="with-interactive" name="type" class="custom-control-input"
                                       value="with-interactive" {{ $type && $type == 'with-interactive' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="with-interactive">aj interaktívne</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="just-interactive" name="type" class="custom-control-input"
                                       value="just-interactive" {{ $type && $type == 'just-interactive' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="just-interactive">iba interaktívne</label>
                            </div>
                        </div>

                        <div class="form-group">
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-primary"><i class="fas fa-filter"></i> Uložiť filter
                            </button>
                            <a href="{{ route('questions.filter.reset') }}" class="btn btn-danger"><i
                                        class="fas fa-redo-alt"></i> Zrušiť filter</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
