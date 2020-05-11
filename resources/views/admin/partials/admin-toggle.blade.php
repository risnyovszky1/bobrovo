<form action="{{ $route }}" class="" method="POST">
    @csrf
    @method('PATCH')
    <button type="submit" class="btn btn-sm btn-outline-info">
        <i class="fas fa-users-cog"></i>
    </button>
</form>
