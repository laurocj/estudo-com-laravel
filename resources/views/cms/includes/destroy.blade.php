<form action="{{ $route }}" method="post" class="d-inline">
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm">{{ __('Delete') }}</button>
</form>
