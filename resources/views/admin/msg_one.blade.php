@section('title')
  Správa | Bobrovo
@endsection

@extends('admin.master')

@section('admin_content')
  <div class="row">
    <div class="col-lg-8 pt-3 pb-3">
      <h2>Správa</h2>

      @if(count($errors) > 0)
        <div class="row">
          <div class="col-md-12">
            @foreach($errors->all() as $err)
              <div class="alert alert-danger mb-2">
                {{ $err }}
              </div>
            @endforeach
          </div>
        </div>
      @endif

        <div class="form-group">
          <label for="address">Od</label>
          <input type="text" name="address" id="address" value="{{ $msg->first_name . ' ' . $msg->last_name . ' ('. $msg->email . ')' }}" readonly class="form-control">
        </div>
        <div class="form-group">
          <label for="subject">Predmet </label>
          <input type="text" name="subject" id="subject" class="form-control" value="{{ $msg->subject }}" readonly>
        </div>
        <div class="form-group">
          <label for="content">Správa</label>
          <textarea name="content" rows="8" class="form-control" id="msg-text-editor" readonly>{{ $msg->content }}</textarea>
        </div>
        <div class="form-group">
          <a href="{{ route('msg.answer', ['id' => $msg->id]) }}" class="btn btn-lg btn-primary"><i class="fas fa-paper-plane"></i> Odpovedať </a>
        </div>
    </div>
  </div>
@endsection
