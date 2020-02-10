<ul class="nav flex-column">
    @can('category-list')
    <li class="nav-item">
        <a class="nav-link {{ Route::is('categorias.*') ? 'active' : '' }}"
            href="{{ route('categorias.index') }}">{{ __('Categories') }}</a>
    </li>
    @endcan

    @can('product-list')
    <li class="nav-item">
        <a class="nav-link {{ Route::is('produtos.*') ? 'active' : '' }}"
            href="{{ route('produtos.index') }}">{{ __('Products') }}</a>
    </li>
    @endcan

    @can('role-list')
    <li class="nav-item">
        <a class="nav-link {{ Route::is('regras.*') ? 'active' : '' }}"
            href="{{ route('regras.index') }}">{{ __('Roles') }}</a>
    </li>
    @endcan

    @can('user-list')
    <li class="nav-item">
        <a class="nav-link {{ Route::is('usuarios.*') ? 'active' : '' }}"
            href="{{ route('usuarios.index') }}">{{ __('Users') }}</a>
    </li>
    @endcan
</ul>
