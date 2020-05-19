@if (session('alert_type'))
    @switch(session('alert_type'))
        @case('error')
            <div class="alert alert-danger">
                {{ session('alert_message') }}
            </div>
            @break
        @case('success')
            <div class="alert alert-success">
                {{ session('alert_message') }}
            </div>
            @break
        @case('warning')
            <div class="alert alert-warning">
                {{ session('alert_message') }}
            </div>
            @break
    @endswitch
@endif
