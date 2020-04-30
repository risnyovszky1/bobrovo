<form action="{{ $route }}" class="d-inline-block float-right" method="POST">
    @csrf
    @method('PATCH')
    <button type="submit" class="btn btn-sm btn-outline-danger" style="border: none !important;">
        <i class="fas fa-trash"></i>
    </button>
</form>
