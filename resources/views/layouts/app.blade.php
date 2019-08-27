<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('layouts.head')

<body>
    <!-- Header Area wrapper Starts -->
    <header id="header-wrap">
        @include('layouts.navbar')
        @yield('hero')
    </header>
    <!-- Header Area wrapper End -->

    @yield('content')
    @include('layouts.footer')
    @include('layouts.scripts')
</body>

</html>