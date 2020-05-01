@if(count($errors) > 0)
    <div class="row">
        <div class="col-md-8 mt-4">
            <div class="alert alert-danger mb-2">
                <h3><i class="fas fa-exclamation-triangle"></i> Vyskytla sa chyba</h3>
                <hr>
                @foreach($errors->all() as $err)
                    <p class="mb-1">{{ $err }}</p>
                @endforeach
            </div>
        </div>
    </div>
@endif

<div class="row">
    <div class="col-md-8">
        @foreach(session('error') ?? [] as $msg)
            <div class="alert alert-danger mt-2">
                <button type="button" data-dismiss="alert" aria-hidden="true" class="close">&times;</button>
                <i class="fas fa-times"></i> {!! $msg !!}
            </div>
        @endforeach

        @foreach(session('success') ?? [] as $msg)
            <div class="alert alert-success mt-2">
                <button type="button" data-dismiss="alert" aria-hidden="true" class="close">&times;</button>
                <i class="fas fa-check"></i> {!! $msg !!}
            </div>
        @endforeach

        @foreach(session('warning') ?? [] as $msg)
            <div class="alert alert-warning mt-2">
                <button type="button" data-dismiss="alert" aria-hidden="true" class="close">&times;</button>
                <i class="fas fa-exclamation"></i> {!! $msg !!}
            </div>
        @endforeach

        @foreach(session('info') ?? [] as $msg)
            <div class="alert alert-info mt-2">
                <button type="button" data-dismiss="alert" aria-hidden="true" class="close">&times;</button>
                <i class="fas fa-info"></i> {!! $msg !!}
            </div>
        @endforeach
    </div>
</div>
