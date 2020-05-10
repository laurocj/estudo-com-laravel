@php
$id = isset($id) ? $id : Str::random(10);

$class = isset($class) ? "form-control $class" : "form-control ";

if($errors->has($name)) {
    $class .= " is-invalid ";
} else if(old($name) !== null) {
    $class .= " is-valid ";
}
@endphp

<div class="form-group">
    <label for="{{ $id }}">{!! __($label) !!}</label>

    <input id="{{ $id }}"
        name="{{ $name }}"
        class="{{ $class }}"
        value="{{ $value ?? null }}"
        type="{{ $type ?? 'text' }}"
        @isset($help) aria-describedby="{{ $id }}Help" @endisset
        @isset($placeholder) placeholder="{{ $placeholder }}" @endisset
        {{ $attributes ?? null }}>

    @isset($help)
        <small id="{{ $id }}Help" class="form-text text-muted">{{ $help }}</small>
    @endisset

    <div class="invalid-feedback">
        @if($errors->has($name))
            @foreach($errors->get($name) as $msg)
            {{$msg}}<br />
            @endforeach
        @endif
    </div>
</div>
