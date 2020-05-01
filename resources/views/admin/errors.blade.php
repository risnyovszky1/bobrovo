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
