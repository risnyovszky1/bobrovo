@section('title')
    Používateľia | Bobrovo
@endsection

@extends('admin.master')


@section('admin_content')
    <div class="admin-panel pt-2 pb-2">
        <h2>Používateľia</h2>

        <div class="row">
            <div class="col-lg-10">
                <div class="table-responsive">
                    <table class="table mt-2 table-hover table-light">
                        <thead>
                        <tr class="table-secondary">
                            <th>Meno</th>
                            <th>Priezvisko</th>
                            <th>E-mail</th>
                            <th class="text-center">Počet študentov</th>
                            <th class="text-center">Je admin?</th>
                            <th class="text-center">Toggle admin</th>
                            <th class="text-center">Vymazať</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{$user->first_name}}</td>
                                <td>{{$user->last_name}}</td>
                                <td>{{$user->email}}</td>
                                <td class="text-center">{{$user->students->count()}}</td>
                                <td class="text-center">{!!$user->is_admin ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>'!!}</td>
                                <td class="text-center">
                                    @include('admin.partials.admin-toggle', ['route' => route('user.toggle', $user)])
                                </td>
                                <td class="text-center">
                                    @include('admin.partials.delete', ['route' => route('user.destroy', $user)])
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


    </div>

@endsection
