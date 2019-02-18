@section('title')
  Admin panel | Bobrovo
@endsection

@extends('admin.master')


@section('admin_content')
  <div class="admin-panel pt-2 pb-2">
    <h2>Ahoj, {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}!</h2>
  </div>

@endsection
