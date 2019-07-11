@section('title')
  {{ $title }} | Bobrovo
@endsection

@extends('admin.master')

@section('admin_content')
<form action="" method="post">
  <div class="row">
    <div class="col-lg-9 pt-3 pb-3">
        <h2>{{ $title }} <span class="badge badge-secondary badge-pill">{{ $total }}</span></h2>

      @if(count($errors) > 0)
            @foreach($errors->all() as $err)
                <div class="alert alert-danger mb-2">
                    {{ $err }}
                </div>
            @endforeach
      @endif

      @if(!empty($questions) && count($questions) > 0)
        <div class="table-responsive">
            <table class="table table-hover mt-2 table-light">
                <thead>
                    <tr class="table-secondary">
                        <td scope="col">#</td>
                        <td scope="col">Názov</td>
                        <td scope="col">Kategória</td>
                        <td scope="col" class="text-center">Náročnosť</td>
                        <td scope="col" class="text-center">Typ</td>
                        <td scope="col" class="text-center">Hodnotenie</td>
                        <td scope="col" class="text-center">Počet <br>hodnotení</td>
                        <td scope="col" class="text-center">Počet <br>kommentov</td>
                        <td scope="col" class="text-center">Počet <br>použití</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($questions as $item)
                        <tr>
                            <td><input type="checkbox" name="questions[]" id="" value="{{$item->id}}"></td>
                            <td><a href="{{ route('questions.one', ['id' => $item->id ]) }}">{{ $item->title }}</a></td>
                            <td>
                                <span class="extra-small">
                                    @if(count(explode(',', $item->categories)) > 0)
                                        @foreach( explode(',', $item->categories) as $itemCategory)
                                            {!! $itemCategory ? $categories[trim($itemCategory)] . '<br>' : '' !!}
                                        @endforeach
                                    @else
                                        Bez kategórie
                                    @endif
                                </span>
                            </td>
                            <td class="text-center">{{ $item->difficulty }}</td>
                            <td class="text-center">
                                @switch($item->type)
                                    @case(1)
                                    @case(2)
                                    @case(3)
                                        <i class="fas fa-align-left text-primary" title="Textový typ"></i>
                                        @break
                                    @case(4)
                                        <i class="fas fa-image text-success" title="Obrázkový typ"></i>
                                        @break
                                    @default
                                        <i class="fas fa-puzzle-piece text-danger" title="Interaktívny typ"></i>
                                @endswitch
                            </td>
                            <td class="text-center">
                                @if($item->rating < 1)
                                    <span class="badge badge-pill badge-danger">Nehodnotené</span>
                                @elseif($item->rating >= 4 )
                                    <span class="badge badge-pill badge-success">{{round($item->rating, 1)}}</span>
                                @else
                                    <span class="badge badge-pill badge-warning">{{round($item->rating, 1)}}</span>
                                @endif
                            </td>
                            <td class="text-center">
                                {{ $item->rating_count }}
                            </td>
                            <td class="text-center">
                                {{ $item->comments }}
                            </td>
                            <td class="text-center">
                                {{ $item->popularity }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

          <div id="pagination" class="text-center pt-3 pb-3">
              @php
                $totalPages = intval(ceil($total / 50));
                $actualPage = \Illuminate\Support\Facades\Input::get('page') ? \Illuminate\Support\Facades\Input::get('page') - 1 :  0;
              @endphp
              @for($i = 0; $i < $totalPages; $i++)
                  <a href="{{ route('questions.all') . '?page=' . ($i+1) }}" class="btn {{ $actualPage == $i ? 'btn-dark' : 'btn-secondary' }}">{{ $i+1 }}</a>
              @endfor
          </div>
      @else
        <p>Zaťiaľ žiadne otázky sa tu nenachádzajú.</p>
      @endif

      
    </div>
    <div class="col-lg-3 pt-3 pb-3">
        <div class="form-group text-right">
            <button class="btn btn-sm btn-danger" id="unselect-all" data-select="questions[]">Zrušiť označenie</button>
            <button class="btn btn-sm btn-success" id="select-all" data-select="questions[]">Označit všetko</button>
        </div>
        @if (!empty($tests) && count($tests) > 0)
            <div class="form-group">
                <label for="test-select">Test</label>
                <select name="test-select" id="test-select" class="form-control">
                    @foreach ($tests as $item)
                        <option value="{{$item->id}}">{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                {{ csrf_field() }}
                <button type="submit" class="btn btn-primary btn-block">Pridaj do testu</button>
            </div>

            <div class="form-group">
                <a href="{{ route('questions.filter.reset') }}" class="btn btn-danger btn-block"><i class="fas fa-redo-alt"></i> Zrušiť filter</a>
            </div>
        @endif
        
    </div>
  </div>
</form>
@endsection


