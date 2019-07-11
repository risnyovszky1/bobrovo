@section('title')
  Všetky testy | Bobrovo
@endsection

@extends('admin.master')

@section('admin_content')
  <div class="row">
    <div class="col-lg-10 pt-3 pb-3">
      <h2>Všetky testy</h2>

      @if(!empty($tests) && count($tests) > 0)
        <div class="table-responsive">
            <table class="table mt-2 table-hover table-light">
                <thead>
                    <tr class="table-secondary">
                        <th scope="col">Názov</th>
                        <th scope="col">Skupina</th>
                        <th scope="col" class="text-center">Verejný</th>
                        <th scope="col">Odkedy</th>
                        <th scope="col">Dokedy</th>
                        <th scope="col" class="text-center">Vymazať</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tests as $test)
                        <tr>
                            <td>   
                                <a href="{{ route('tests.one', ['id' => $test->id]) }}" title="{{ $test->name }}">{{ $test->name }}</a>
                            </td>
                            <td>
                                <a href="{{ route('groups.one', ['id' => $test->group_id]) }}" title="Skupina {{$test->group_name}}">
                                    {{ $test->group_name }}
                                </a>
                            </td>
                            <td class="text-center">
                                 @if($test->public)
                                    <span class="badge badge-pill badge-success">
                                        <i class="fas fa-check"></i>
                                    </span>
                                 @else
                                    <span class="badge badge-pill badge-danger">
                                        <i class="fas fa-times"></i>
                                    </span>
                                 @endif
                            </td>
                            <td>
                                {{ $test->available_from }}
                            </td>
                            <td>
                                {{ $test->available_to }}
                            </td>
                            <td class="text-center">
                                <a href="{{ route('tests.delete', ['id' => $test->id]) }}" class="text-danger" title="Vymazať {{ $test->name }}">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
      @else
        <p>Zaťiaľ žiadne testy sa tu nenachádzajú.</p>
      @endif
    </div>
  </div>
@endsection
