<!-- Header -->
<header width="500" height="600">
    <a href="{{ route('home') }}"><img src="{{asset('sources/data/logo_blanco.png')}}" class="logo"></a>

    <!-- Icono Hamburguesa -->
    <input class="lateral-menu" type="checkbox" id="lateral-menu">
    <label class="hamb" for="lateral-menu">
        <span class="hamb-line"></span>
    </label>
    <!-- Menu -->
    <nav class="nav">
        <ul class="menu">
            <li><a href="{{ route('home') }}">Home</a></li>
            <li><a href="">Acerca de</a> </li>
            <li><a href="{{route('contact.index')}}">Contacto</a></li>
            <li><a href="{{route('products.index')}}">Productos</a></li>
            @guest
            <li><a href="{{ route('login') }}">Login</a></li>
            @endguest
            @auth
            <li><a href="{{route('profile.edit')}}">Perfil</a></li>
            @if(\Illuminate\Support\Facades\Auth::user()->rol_id==5)
                <li><a href="">Admin</a></li>
            @endif
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <a href="#" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                        Cerrar sesión
                    </a>
                </form>
            </li>
            @endauth
            <li id="basket"><a href=""><img src="{{asset('sources/data/cesta.png')}}" class="logo" alt="carrito"></a></li>
        </ul>
    </nav>

</header>
