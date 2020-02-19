<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('cms.layouts.head')

<body>

    @include('cms.layouts.navbar')

    <div class="container-fluid h-100">

        <div class="row h-100">

            <nav class='d-none d-sm-block col-sm-4 col-md-3 col-xl-2 border bg-light'>
                @include('cms.layouts.menu')
            </nav>

            <main class="col-12 col-sm">
                @yield('content')
            </main>

        </div>

    </div>

    @include('cms.layouts.js')

</body>


</html>
