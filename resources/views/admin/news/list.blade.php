@section('title')
    Všetky novinky | Bobrovo
@endsection

@extends('admin.master')

@section('admin_content')
    <div class="row">
        <div class="col-lg-8 pt-3 pb-3">
            <h2>Všetky novinky</h2>

            @if(!empty($newsFeed) && count($newsFeed) > 0)
                <div id="news-feed">
                    <div class="table-responsive">
                        <table class="table mt-2 table-hover table-light">
                            <thead>
                            <tr class="table-secondary">
                                <th scope="col">Názov</th>
                                <th scope="col">Vytvoril</th>
                                <th scope="col">Čas</th>
                                <th scope="col" class="text-right">Vymazať</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($newsFeed as $news)
                                <tr>
                                    <td scope="row"><a
                                                href="{{ route('news.edit', $news) }}">{{ $news->title }}</a>
                                    </td>
                                    <td>{{ $news->user->first_name . ' ' . $news->user->last_name }}</td>
                                    <td>{{ $news->created_at }}</td>
                                    <td class="text-right">
                                        @include('admin.partials.delete', ['route' => route('news.destroy', $news)])
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <p>Zaťiaľ žiadne novinky sa tu nenacádzajú.</p>
            @endif
        </div>
    </div>
@endsection
