<div class="form-group">

    @php
    $id = $id ?? Str::random(10);
    // quando o name é um array tipo plataformas[1] tem que remover a parte da chave [1]
    if(isset($name))
        $nameErrors = strstr($name,'[',true) !== false ? strstr($name,'[',true) : $name;
    @endphp

    <div class="custom-control custom-checkbox my-1 mr-sm-2">
        <input type="{{ $type ?? 'radio' }}"
            class="custom-control-input {{ $class ?? "" }} {{ isset($nameErrors) && $errors->has($nameErrors) ? 'is-invalid' :'' }}"
            id="{{ $id }}"
            value="{{ $value ?? true }}"
            {{ $name ? 'name=' . $name : '' }}
            {{ $elements ?? '' }}>
        <label class="custom-control-label" for="{{ $id }}">{!! $label !!}</label>

        @isset($nameErrors)
        <div class="invalid-feedback">
            @if($errors->has($nameErrors) )
                @foreach($errors->get($nameErrors) as $msg)
                    {{$msg}}<br />
                @endforeach
            @endif
        </div>
        @endisset
    </div>
</div>
