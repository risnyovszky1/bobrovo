@section('title')
    Všetky FAQ | Bobrovo
@endsection

@extends('admin.master')

@section('admin_content')
    <div class="row">
        <div class="col-lg-8 pt-3 pb-3">
            <h2>Všetky FAQ</h2>

            @if(!empty($faq) && count($faq) > 0)
                <div id="faq-feed">
                    <div class="table-responsive">
                        <table class="table mt-2 table-hover table-light">
                            <thead>
                            <tr class="table-secondary">
                                <th scope="col">Otázka</th>
                                <th scope="col">Čas</th>
                                <th scope="col" class="text-right">Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($faq as $f)
                                <tr>
                                    <td scope="row"><a
                                                href="{{ route('faq.edit', $f) }}">{{ $f->question }}</a>
                                    </td>
                                    <td>{{ $f->created_at }}</td>
                                    <td class="text-right">
                                        @include('admin.partials.delete', ['route' => route('faq.destroy', $f)])
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <p>Zaťiaľ žiadne FAQ sa tu nenachádzajú.</p>
            @endif
        </div>
    </div>
@endsection
