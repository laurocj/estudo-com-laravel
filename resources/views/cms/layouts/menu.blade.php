<ul class="nav flex-column">
    <li class="nav-item">
        <a class="nav-link {{ Route::is('categorias.*') ? 'active' : '' }}"
            href="{{ route('categorias.index') }}">{{ __('Categories') }}</a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ Route::is('produtos.*') ? 'active' : '' }}"
            href="{{ route('produtos.index') }}">{{ __('Products') }}</a>
    </li>

    @can('role-list')
    <li class="nav-item">
        <a class="nav-link {{ Route::is('regras.*') ? 'active' : '' }}"
            href="{{ route('regras.index') }}">{{ __('Roles') }}</a>
    </li>
    @endcan

    <li class="nav-item">
        <a class="nav-link {{ Route::is('users.*') ? 'active' : '' }}"
            href="{{ route('users.index') }}">{{ __('Users') }}</a>
    </li>
</ul>
