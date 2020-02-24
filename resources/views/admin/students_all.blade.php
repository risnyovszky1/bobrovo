@section('title')
    Všetky študenty | Bobrovo
@endsection

@extends('admin.master')

@section('admin_content')
    <form action="" method="post">
        <div class="row">
            <div class="col-lg-8 pt-3 pb-3">
                <h2>Všetky študenty</h2>

                @if(!empty($students) && count($students) > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mt-2 table-light">
                            <thead>
                            <tr class="table-secondary">
                                <th class="text-center">#</th>
                                <th scope="col">Meno a priezvisko</th>
                                <th scope="col" class="text-center">Kód</th>
                                <th scope="col" class="text-center">Vymazať</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($students as $student)
                                <tr>
                                    <td class="text-center">
                                        <input type="checkbox" value="{{ $student->id }}" name="students[]">
                                    </td>
                                    <td scope="row">
                                        <a href="{{ route('students.profil', ['id'=>$student->id]) }}"
                                           title="Profil {{ $student->first_name . ' ' . $student->last_name }}">
                                            {{ $student->first_name . ' ' . $student->last_name }}
                                        </a>
                                    </td>
                                    <td class="text-center">{{ $student->code }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('students.delete', ['id' => $student->id]) }}"
                                           class="btn btn-danger btn-sm"
                                           title="Vymazať {{ $student->first_name . ' ' . $student->last_name }}">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p>Zaťiaľ žiadnych študentov nemáš.</p>
                @endif
            </div>
            <div class="col-lg-4 pt-3 pb-3">
                <div class="form-group text-right">
                    <button class="btn btn-sm btn-danger" id="unselect-all" data-select="students[]">Zrušiť označenie
                    </button>
                    <button class="btn btn-sm btn-success" id="select-all" data-select="students[]">Označit všetko
                    </button>
                </div>
                <div class="form-group">
                    <label for="group">Skupina</label>
                    <select name="group" id="add-to-group" class="form-control">
                        <option value="">-- Vyber skupinu --</option>
                        @foreach($groups as $group)
                            <option value="{{ $group->id }}">{{ $group->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-block btn-primary"><i class="fas fa-user-plus"></i> Pridaj do
                        skupiny
                    </button>
                </div>

                <div class="form-grou">
                    <a href="{{ route('students.export') }}" class="btn btn-block btn-secondary" target="_blank"><i
                                class="fas fa-print"></i> Vytlačiť</a>
                </div>
            </div>
        </div>
    </form>
@endsection
