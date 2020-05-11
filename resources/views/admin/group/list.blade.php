@section('title')
    Všetky skupiny | Bobrovo
@endsection

@extends('admin.master')

@section('admin_content')
    <div class="row">
        <div class="col-lg-8 pt-3 pb-3">
            <h2>Všetky skupiny</h2>

            @if(!empty($groups) && count($groups) > 0)
                <div class="table-responsive">
                    <table class="table table-hover mt-2 table-light">
                        <thead>
                        <tr class="table-secondary">
                            <th scope="col">Názov</th>
                            <th scope="col" class="text-center">Počet študentov s skupine</th>
                            <th scope="col">Čas</th>
                            <th scope="col" class="text-center">Vymazať</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($groups as $group)
                            <tr>
                                <td scope="row">
                                    <a href="{{ route('group.show', $group) }}">
                                        {{ $group->name }}
                                    </a>
                                </td>

                                <td class="text-center">
                                    <span
                                        class="badge badge-pill {{ $group->students_count > 0 ? 'badge-success' : 'badge-secondary'}}">
                                      {{ $group->students_count }}
                                    </span>
                                </td>
                                <td>
                                    {{ $group['created_at']}}
                                </td>
                                <td class="text-center">
                                    @include('admin.partials.delete', ['route' => route('group.destroy', $group)])
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p>Zaťiaľ žiadne skupiny nemáš.</p>
            @endif
        </div>
    </div>
@endsection
