<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('cms.layouts.head')
    </head>

    <body class="container-fluid">
        <div class="row">
            <div class='col-12 col-sm-4 col-md-3 col-xl-2 bg-dark navbar-collapse' id="navbarSupportedContent">
                <div class="row navbar bg-light">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name') }}
                    </a>
                </div>
                @include('cms.layouts.menu')
            </div>

            <div class="col">
                @include('cms.layouts.navbar')
                <div class="row">
                    @component('cms.layouts.component.alert')
                    @endcomponent
                    <main class="col-12 pt-3">
                        @yield('content')
                    </main>
                </div>
            </div>

            <div class="modal fade" id="modalContent" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-body">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('cms.layouts.footer')

        @include('cms.layouts.js')

    </body>

</html>
