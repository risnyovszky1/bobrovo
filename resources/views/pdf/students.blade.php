<style>
    h2 {
        text-align: center
    }

    .student-table {
        width: 100%;
        border-collapse: collapse
    }

    .student-table thead tr th {
        padding: 10px 10px;
        font-weight: bold;
        background: #efefef;
        border-color: #666666
    }

    .student-table tr td {
        padding: 6px 10px;
        vertical-align: middle;
        border-top: 1px solid #999;
    }

    .font-lg {
        font-size: 1.5em
    }

    .align-left {
        text-align: left
    }

    .align-center {
        text-align: center
    }

</style>

<h2>{{ empty(Session::get('printDocName')) ? 'Bobrovo' : Session::get('printDocName') }}</h2>


<table autosize="2.4" class="student-table">
    <thead>
    <tr>
        <th class="align-left">Meno</th>
        <th class="align-left">Priezvisko</th>
        <th class="align-center">Kód</th>
    </tr>
    </thead>
    <tbody>
    @if (Session::get('userStudents'))
        @foreach (Session::get('userStudents') as $student)
            <tr>
                <td>{{$student->first_name}}</td>
                <td>{{$student->last_name}}</td>
                <td class="font-lg align-center">{{$student->code}}</td>
            </tr>
        @endforeach
    @endif
    </tbody>
</table>