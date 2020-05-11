@section('title')
    Správy | Bobrovo
@endsection

@extends('admin.master')

@section('admin_content')
    <div class="row">
        <div class="col-lg-8 pt-3 pb-3">
            <h2>Správy</h2>

            <div class="table-responsive">
                <table class="table table-hover mt-2 table-light">
                    <thead>
                    <tr class="table-secondary">
                        <th scope="col">Predmet</th>
                        <th scope="col">Od</th>
                        <th scope="col">Kedy</th>
                        <th scope="col" class="text-center">Videný</th>
                        <th scope="col" class="text-right">Delete</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($messages as $msg)
                        <tr>
                            <td><a href="{{ route('message.show', ['id' => $msg->id])}}">{{ $msg->subject }}</a></td>
                            <td>{{ $msg->sender->first_name . ' ' . $msg->sender->last_name . ' ('. $msg->sender->email . ')' }}</td>
                            <td>{{ $msg->created_at }}</td>
                            <td class="text-center">{!! $msg->seen ? '<i class="fas fa-eye text-success"></i>' : '<i class="fas fa-eye-slash text-secondary"></i>' !!}</td>
                            <td class="text-right">
                                @include('admin.partials.delete', ['route' => route('message.destroy', $msg)])
                            </td>
                        </tr>
                    @endforeach
                    </tbody>

                </table>
            </div>

        </div>
    </div>
@endsection
