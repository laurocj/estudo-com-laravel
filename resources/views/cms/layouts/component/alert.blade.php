@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
@if (session('status_error'))
    <div class="alert alert-danger">
        {{ session('status_error') }}
    </div>
@endif