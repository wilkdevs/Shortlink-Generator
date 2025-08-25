<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<x-template.main-header-component />

<body>

    <div class="mobile-view-wrapper">

        @yield('content')

    </div>

    @yield('script-top')

    <x-template.main-footer-component />

    @yield('script')

</body>

</html>
