@section('title')
  Výsledky testu | Bobrovo
@endsection

@extends('admin.master')


@section('admin_content')
  <div class="admin-panel pt-2 pb-2">

    <div class="row">
        <div class="col-lg-8">
            <h2>Výsledky testu</h2>

            <div class="card border-primary mt-3">
                <div class="card-header bg-primary text-white">
                    Test
                </div>
                <div class="card-body">
                    <h5 class="card-title mb-0">{{$test->name}}</h5>
                </div>
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover mt-3 mb-3">
                    <thead>
                        <tr class="table-secondary">
                            <th>Meno a priezvisko</th>
                            <th class="text-center">Stav</th>
                            <th class="text-center">Úspešnosť</th>
                            <th class="text-center">Pozrieť</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $item)
                            <tr>
                                <td><a href="{{ route('students.profil', ['id' => $item->id ])}}">{{ $item->first_name . ' ' . $item->last_name }}</a></td>
                                <td class="text-center">
                                    @switch($item->state)
                                        @case(1)
                                            <span class="text-danger">Nezačatý</span>
                                            @break
                                        @case(2)
                                            <span class="text-primary">Začatý</span>
                                            @break
                                        @case(3)
                                            <span class="text-success">Dokončený</span>
                                                @break
                                        @default
                                    @endswitch
                                </td>
                                <td class="text-center">{{ $item->percent}} %</td>
                                <td class="text-center"><a href="{{ route('tests.results.student', ['id' => $test->id, 'sid' => $item->id]) }}" class="text-info"><i class="fas fa-eye"></i></a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <a href="{{ route('tests.one', ['id'=>$test->id]) }}" class="btn btn-primary"><i class="fas fa-arrow-circle-left"></i> Spať na test</a>
            </div>
        </div>
    </div>
    
  </div>

@endsection
