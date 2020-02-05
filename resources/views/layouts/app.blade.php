<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('layouts.head')
    <body>
            @include('layouts.navbar')

            <main class="py-4">
                @yield('content')
            </main>

            @include('layouts.js')
    </body>
</html>
