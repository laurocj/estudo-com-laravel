<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('cms.layouts.head')
    </head>

    <body class="container-fluid">
        <div class="row">
            <section class='d-none col-12 d-md-block col-md-3 col-xl-2 border-right bg-light'>
                <aside class="row navbar navbar-dark bg-dark">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name') }}
                    </a>
                </aside>
                @include('cms.layouts.menu')
            </section>

            <section class="col-12 col-sm">
                @include('cms.layouts.navbar')
                <main class="row">
                    @component('cms.layouts.component.alert')
                    @endcomponent
                    @yield('content')
                </main>
            </section>

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
