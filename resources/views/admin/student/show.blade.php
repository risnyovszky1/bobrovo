@section('title')
    Profil žiaka | Bobrovo
@endsection

@extends('admin.master')


@section('admin_content')


    <div class="row">
        <div class="col-lg-8 pt-3 pb-3">

            <div class="row">
                <div class="col-md-12">
                    <h2>Profil žiaka</h2>
                </div>
            </div>

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

            <div class="row">
                <div class="col-md-6">
                    <div class="card mt-4 border-primary shadow">
                        <div class="card-header bg-primary text-white">
                            Meno
                        </div>
                        <div class="card-body">
                            <h5 class="card-title mb-0">{{ $student->first_name }}</h5>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card mt-4 border-danger shadow">
                        <div class="card-header bg-danger text-white">
                            Priezvisko
                        </div>
                        <div class="card-body">
                            <h5 class="card-title mb-0">{{ $student->last_name }}</h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card mt-4 border-secondary shadow">
                        <div class="card-header bg-secondary text-white">
                            Kód
                        </div>
                        <div class="card-body">
                            <h5 class="card-title mb-0">{{ $student->code }}</h5>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card mt-4 border-info shadow">
                        <div class="card-header bg-info text-white">
                            Registrovaný
                        </div>
                        <div class="card-body">
                            <p class="card-text">{{ $student->created_at }}</p>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-12">
                    <div class="card mt-4 border-success shadow">
                        <div class="card-header bg-success text-white">
                            Skupiny
                        </div>
                        @if($student->groups->count() > 0)
                            <ul class="list-group list-group-flush">
                                @foreach($student->groups as $group)
                                    <li class="list-group-item">
                                        <a href="{{ route('groups.one', [ 'id' => $group->id ]) }}">{{ $group->name }}</a>
                                        @include('admin.partials.remove', ['route' => route('student.remove-from-group', ['student' => $student->id, 'group' => $group->id])])
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="card-body">
                                <p class="card-text">Študent nie je v žiadnej skipine ešte.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>


        <div class="col-lg-4 pt-3 pb-3">
            <div class="row">
                <div class="col-md-12 text-right">
                    @include('admin.partials.delete', ['route' => route('student.destroy', $student), 'text' => 'Vymazať žiaka'])
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <form action="{{ route('student.update', $student) }}" method="POST">
                        <div class="form-group">
                            <label for="add-to-group">Pridať do skupiny</label>
                            <select name="add-to-group" id="add-to-group" class="form-control">
                                <option value="">-- vybrať skupinu --</option>
                                @foreach($groupList as $group)
                                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-block btn-primary"><i class="fas fa-user-plus"></i>
                                Pridaj do skupiny
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
