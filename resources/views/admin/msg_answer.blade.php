@section('title')
    Odpovedať na správu | Bobrovo
@endsection

@extends('admin.master')

@section('admin_content')
    <div class="row">
        <div class="col-lg-8 pt-3 pb-3">
            <h2>Odpovedať na správu</h2>

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

            @if(!empty($success))
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-success mb-2">
                            {{ $success }}
                        </div>
                    </div>
                </div>
            @endif

            <form action="" method="post">
                <div class="form-group">
                    <label for="address">Komu</label>
                    <input type="text" name="address" id="address" class="form-control"
                           value="{{ $msg->first_name . ' ' . $msg->last_name . ' ('. $msg->email . ')' }}" readonly>
                    <input type="hidden" name="address_id" value="{{ $msg->uid }}">
                </div>
                <div class="form-group">
                    <label for="subject">Predmet </label>
                    <input type="text" name="subject" id="subject" class="form-control" value="RE: {{ $msg->subject}}">
                </div>
                <div class="form-group">
                    <label for="content">Správa</label>
                    <textarea name="content" rows="8" class="form-control" id="msg-text-editor">
Odpoveď sem : 

-------------------------
{{ $msg->content }}
          </textarea>
                </div>
                <div class="form-group">
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-lg btn-primary"><i class="fas fa-paper-plane"></i> Poslať
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
