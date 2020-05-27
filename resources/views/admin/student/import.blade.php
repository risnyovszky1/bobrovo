@section('title')
    Pridať žiakov zo súboru | Bobrovo
@endsection

@extends('admin.master')


@section('admin_content')


    <div class="row">
        <div class="col-lg-8 pt-3 pb-3">

            <div class="row">
                <div class="col-md-12">
                    <h2>Pridať žiakov zo súboru</h2>
                </div>
            </div>

            @if(!empty($success))
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-success mb-2">
                            {{ $success }}
                        </div>
                    </div>
                </div>
            @endif

            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-info">
                        Súbor vo formáte <strong>.csv</strong>, kde prvý stľpec je meno, druhý priezvisko a tretí je kód
                        žiaka (min. 12 znak).
                    </div>
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="group">Skupina</label>
                            <select name="group" id="group" class="form-control">
                                <option value="">-- Vyber skupinu --</option>
                                @foreach($groups as $group)
                                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="student-file" name="student_file">
                                <label class="custom-file-label" for="student_file">Vybrať súbor</label>
                            </div>
                        </div>

                        <div class="form-group">
                            {{ csrf_field() }}
                            <a href="{{ route('student.index') }}" class="btn btn-lg btn-link">Zrušiť</a>
                            <button type="submit" class="btn btn-lg btn-primary">
                                <i class="fas fa-plus-circle"></i> Pridaj
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
