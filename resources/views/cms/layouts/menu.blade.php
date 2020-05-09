<nav class="nav nav-tabs flex-column" role="tablist" aria-orientation="vertical">
    {{-- @can('category-list') --}}
        <a class="nav-link text-light {{ Route::is('categorias.*') ? 'active' : '' }}"
            aria-selected="{{ Route::is('categorias.*') ? 'true' : 'false' }}"
            href="{{ route('categorias.index') }}">{{ __('Categories') }}</a>
    {{-- @endcan --}}

    {{-- @can('product-list') --}}
        <a class="nav-link text-light {{ Route::is('produtos.*') ? 'active' : '' }}"
            aria-selected="{{ Route::is('produtos.*') ? 'true' : 'false' }}"
            href="{{ route('produtos.index') }}">{{ __('Products') }}</a>
    {{-- @endcan --}}

    {{-- @can('role-list') --}}
        <a class="nav-link text-light {{ Route::is('regras.*') ? 'active' : '' }}"
            aria-selected="{{ Route::is('regras.*') ? 'true' : 'false' }}"
            href="{{ route('regras.index') }}">{{ __('Roles') }}</a>
    {{-- @endcan --}}

    {{-- @can('user-list') --}}
        <a class="nav-link text-light {{ Route::is('usuarios.*') ? 'active' : '' }}"
            aria-selected="{{ Route::is('usuarios.*') ? 'true' : 'false' }}"
            href="{{ route('usuarios.index') }}">{{ __('Users') }}</a>
    {{-- @endcan --}}
</nav>
