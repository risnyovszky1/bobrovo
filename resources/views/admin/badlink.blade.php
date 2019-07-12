@section('title')
    Nespávny-link | Bobrovo
@endsection

@extends('admin.master')


@section('admin_content')
    <div class="row">
        <div class="col-lg-8 pt-4 pb-2">
            <div class="alert alert-danger mb-4" role="alert">
                <h4 class="alert-heading">Ste došli na nesrávny link.</h4>
                <p class="mb-0">Nemáte právo vykonať danú akciu alebo ste klili na nesrávny link.</p>
            </div>
        </div>
    </div>

@endsection
