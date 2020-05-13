<div aria-hidden="true" class="navdrawer navdrawer-permanent-md " id="menuNav" tabindex="-1">
    <div class="navdrawer-content">
        <div class="navdrawer-header">
            <a class="navbar-brand px-0" href="{{ url('/') }}">
                {{ config('app.name') }}
            </a>
        </div>
        <nav class="navdrawer-nav">
            {{-- @can('category-list') --}}
                <a class="nav-item nav-link {{ Route::is('categorias.*') ? 'active' : '' }}"
                    aria-selected="{{ Route::is('categorias.*') ? 'true' : 'false' }}"
                    href="{{ route('categorias.index') }}">{{ __('Categories') }}</a>
            {{-- @endcan --}}

            {{-- @can('product-list') --}}
                <a class="nav-item nav-link {{ Route::is('produtos.*') ? 'active' : '' }}"
                    aria-selected="{{ Route::is('produtos.*') ? 'true' : 'false' }}"
                    href="{{ route('produtos.index') }}">{{ __('Products') }}</a>
            {{-- @endcan --}}

            {{-- @can('role-list') --}}
                <a class="nav-item nav-link {{ Route::is('regras.*') ? 'active' : '' }}"
                    aria-selected="{{ Route::is('regras.*') ? 'true' : 'false' }}"
                    href="{{ route('regras.index') }}">{{ __('Roles') }}</a>
            {{-- @endcan --}}

            {{-- @can('user-list') --}}
                <a class="nav-item nav-link {{ Route::is('usuarios.*') ? 'active' : '' }}"
                    aria-selected="{{ Route::is('usuarios.*') ? 'true' : 'false' }}"
                    href="{{ route('usuarios.index') }}">{{ __('Users') }}</a>
            {{-- @endcan --}}
        </nav>
        <div class="navdrawer-divider"></div>
        <p class="navdrawer-subheader">Navdrawer subheader</p>
        <ul class="navdrawer-nav">
            <li class="nav-item">
                <a class="nav-link active" href="#">
                    <i class="material-icons mr-3">alarm_on</i>
                    Active with icon
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link disabled" href="#">
                    <i class="material-icons mr-3">alarm_off</i>
                    Disabled with icon
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="material-icons mr-3">link</i>
                    Link with icon
                </a>
            </li>
        </ul>
    </div>
</div>
