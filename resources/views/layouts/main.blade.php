<!DOCTYPE html>
<html lang="es">
@include('layouts.head')
<body>

    @include('layouts.header')
    @include('layouts.flash-message')
    @yield("content")

    @include('layouts.scripts')

    @yield('javascript')

    @include('layouts.footer')

</body>
</html>
