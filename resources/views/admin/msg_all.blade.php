@section('title')
  Správy | Bobrovo
@endsection

@extends('admin.master')

@section('admin_content')
  <div class="row">
    <div class="col-lg-8 pt-3 pb-3">
      <h2>Správy</h2>

      <div class="table-responsive">
        <table class="table table-hover mt-2">
          <thead>
            <tr class="table-secondary">
              <th scope="col">Predmet</th>
              <th scope="col">Od</th>
              <th scope="col">Kedy</th>
              <th scope="col">Videný</th>
              <th scope="col" class="text-center" >Delete</th>
            </tr>
          </thead>
          <tbody>
            @foreach($messages as $msg)
              <tr>
                <td><a href="{{ route('msg.one', ['id' => $msg->id])}}">{{ $msg->subject }}</a></td>
                <td>{{ $msg->first_name . ' ' . $msg->last_name . ' ('. $msg->email . ')' }}</td>
                <td>{{ $msg->created_at }}</td>
                <td>{!! $msg->seen ? '<i class="fas fa-eye text-success"></i>' : '<i class="fas fa-eye-slash text-secondary"></i>' !!}</td>
                <td class="text-center">
                  <a href="{{ route('msg.delete', ['id' => $msg->id]) }}" class="text-danger" title="Vymazať {{ $msg->subject }}">
                    <i class="fas fa-trash"></i>
                  </a>
                </td>
              </tr>
            @endforeach
          </tbody>
          
        </table>
      </div>
      
    </div>
  </div>
@endsection
