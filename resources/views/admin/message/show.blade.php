@section('title')
    Správa | Bobrovo
@endsection

@extends('admin.master')

@section('admin_content')
    <div class="row">
        <div class="col-lg-8 pt-3 pb-3">
            <h2>Správa</h2>

            <div class="form-group">
                <label for="address">Od</label>
                <input type="text" name="address" id="address"
                       value="{{ $msg->sender->first_name . ' ' . $msg->sender->last_name . ' ('. $msg->sender->email . ')' }}"
                       readonly
                       class="form-control">
            </div>
            <div class="form-group">
                <label for="subject">Predmet </label>
                <input type="text" name="subject" id="subject" class="form-control" value="{{ $msg->subject }}"
                       readonly>
            </div>
            <div class="form-group">
                <label for="content">Správa</label>
                <textarea name="content" rows="8" class="form-control" id="msg-text-editor"
                          readonly>{{ $msg->content }}</textarea>
            </div>
            <div class="form-group">
                <a href="{{ route('message.answer', $msg) }}" class="btn btn-lg btn-primary"><i
                        class="fas fa-paper-plane"></i> Odpovedať </a>
            </div>
        </div>
    </div>
@endsection
