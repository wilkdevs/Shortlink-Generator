<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <x-template.admin-header-component />

    <body class="g-sidenav-show  bg-gray-200">

        <x-template.admin-sidebar-component />

        <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">

            <x-template.admin-nav-component :title="$title" />

            <div class="container-fluid py-4">

                @yield('content')

                @yield('script-top')

                <x-template.admin-footer-component />

                @yield('script')
            </div>
        </main>
    </body>
</html>






































{{-- //// --}}
