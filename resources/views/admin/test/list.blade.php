@section('title')
    Všetky testy | Bobrovo
@endsection

@extends('admin.master')

@section('admin_content')
    <div class="row">
        <div class="col-lg-10 pt-3 pb-3">
            <h2>Všetky testy</h2>

            @if($tests->isNotEmpty())
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
                                    <a href="{{ route('test.show', $test) }}"
                                       title="{{ $test->name }}">{{ $test->name }}</a>
                                </td>
                                <td>
                                    <a href="{{ route('group.show', $test->group) }}"
                                       title="Skupina {{$test->group->name}}">
                                        {{ $test->group->name }}
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
                                    @include('admin.partials.delete', ['route' => route('test.destroy', $test)])
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
