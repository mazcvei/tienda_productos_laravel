<!DOCTYPE html>
<html lang="es">
@include('layouts.head')
<body>

    @include('layouts.header')

    @yield("content")

    @include('layouts.scripts')

    @yield('javascript')

    @include('layouts.footer')

</body>
</html>
