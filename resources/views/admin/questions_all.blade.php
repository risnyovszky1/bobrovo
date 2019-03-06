@section('title')
  Všetky otázky | Bobrovo
@endsection

@extends('admin.master')

@section('admin_content')
  <div class="row">
    <div class="col-lg-8 pt-3 pb-3">
      <h2>Všetky otázky</h2>

      <div id="filter" class="col-md-0">
          
          <form action="" method="GET">
              <div class="form-group">
                <h5>Téma</h5>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="category-1" name="category[]" value="1">
                    <label class="custom-control-label" for="category-1">Informácie okolo nás</label>
                </div>

                <div class="pl-5 mt-1">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="category-6" name="category[]" value="6">
                        <label class="custom-control-label" for="category-6">kódovanie, šifrovanie, komprimácia informácie</label>
                    </div>

                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="category-7" name="category[]" value="7">
                        <label class="custom-control-label" for="category-7">číselné sústavy, prevody</label>
                    </div>

                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="category-8" name="category[]" value="8">
                        <label class="custom-control-label" for="category-8">reprezentácia údajov v počítači - diagramy, čísla, znaky a vzťahy medzi nimi</label>
                    </div>

                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="category-9" name="category[]" value="9">
                        <label class="custom-control-label" for="category-9">vyhľadávanie opakujúcich sa vzorov</label>
                    </div>

                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="category-10" name="category[]" value="10">
                        <label class="custom-control-label" for="category-10">informácie zobrazené pomocou údajových štruktúr - strom, graf, zásobník</label>
                    </div>

                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="category-11" name="category[]" value="11">
                        <label class="custom-control-label" for="category-11">výroková logika a jej využívanie pri práci s informáciami, kombinatorika</label>
                    </div>
                </div>

                <div class="pl-4 mt-2 mb-1">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="category-12" name="category[]" value="12">
                        <label class="custom-control-label" for="category-12">textová informácia - kompetencie potrebné na prácu v textovom editore</label>
                    </div>

                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="category-13" name="category[]" value="13">
                        <label class="custom-control-label" for="category-13">grafická informácia - kompetencie potrebné na prácu v grafickom editore</label>
                    </div>

                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="category-14" name="category[]" value="14">
                        <label class="custom-control-label" for="category-14">číselná informácia - kompetencie potrebné na prácu v tabuľkovom editore</label>
                    </div>

                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="category-15" name="category[]" value="15">
                        <label class="custom-control-label" for="category-15">zvuková informácia - kompetencie potrebné na prácu v zvukovom editore</label>
                    </div>

                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="category-16" name="category[]" value="16">
                        <label class="custom-control-label" for="category-16">prezentácia informácií - kompetencie potrebné na tvorbu prezentácií</label>
                    </div>

                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="category-17" name="category[]" value="17">
                        <label class="custom-control-label" for="category-17">prezentácia informácií na webe - kompetencie potrebné na tvorbu webových stránok</label>
                    </div>
                </div>

                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="category-2" name="category[]" value="2">
                    <label class="custom-control-label" for="category-2">Komunikácia prostredníctvom digitálnych technológií</label>
                </div>

                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="category-3" name="category[]" value="3">
                    <label class="custom-control-label" for="category-3">Postupy, riešenie problémov, algoritmické myslenie</label>
                </div>

                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="category-4" name="category[]" value="4">
                    <label class="custom-control-label" for="category-4">Princípy fungovania digitálnych technológií</label>
                </div>

                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="category-5" name="category[]" value="5">
                    <label class="custom-control-label" for="category-5">Informačná spoločnosť</label>
                </div>
              </div>

                <div class="form-group">
                    <label for="difficulty">Náročnosť</label>
                    <input type="range" class="custom-range" value="1" min="1" max="7" step="1" id="difficulty" name="difficulty">
                </div>

                <div class="form-group">
                    <h5>Typ</h5>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="no-interactive" name="type" class="custom-control-input" value="no-interactive">
                        <label class="custom-control-label" for="no-interactive">bez interaktívnych</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="with-interactive" name="type" class="custom-control-input" value="with-interactive">
                        <label class="custom-control-label" for="with-interactive">aj interaktívne</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="just-interactive" name="type" class="custom-control-input" value="just-interactive">
                        <label class="custom-control-label" for="just-interactive">iba interaktívne</label>
                    </div>
                </div>

              <div class="form-group">
                  <button type="submit" class="btn btn-primary">Filtruj</button>
              </div>
          </form>
      </div>

      @if(!empty($questions) && count($questions) > 0)
        <div class="table-responsive">
            <table class="table table-hover mt-2">
                <thead>
                    <tr class="table-secondary">
                        <td scope="col">Názov</td>
                        <td scope="col">Kategória</td>
                        <td scope="col" class="text-center">Náročnosť</td>
                        <td scope="col" class="text-center">Typ</td>
                        <td scope="col" class="text-center">Hodnotenie</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($questions as $item)
                        <tr>
                            <td><a href="{{ route('questions.one', ['id' => $item->id ]) }}">{{ $item->title }}</a></td>
                            <td>####</td>
                            <td class="text-center">{{ $item->difficulty }}</td>
                            <td class="text-center">{{ $item->type }}</td>
                            <td class="text-center">####</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
        </div>
      @else
        <p>Zaťiaľ žiadne otázky sa tu nenachádzajú.</p>
      @endif
    </div>
  </div>
@endsection


