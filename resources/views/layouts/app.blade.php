<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('layouts.head')
    </head>
    <body>
        @include('layouts.navbar')

        <main class="py-4">
            @yield('content')
        </main>

        @include('layouts.js')
    </body>
</html>
