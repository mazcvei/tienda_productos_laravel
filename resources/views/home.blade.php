@extends("layouts.main")
@section("content")
    <style>
        p {
            margin: unset;
        }
    </style>
    <section class="video">
        <video loop="true" autoplay="autoplay" muted>
            <source src="{{asset('sources/data/mercatavico.mp4')}}" type="video/mp4">
        </video>
    </section>

    <section class="titlemargin" id="slogan">
        <h1>Mercatavico</h1>
        <h2>Conoce el pasado</h2>
    </section>

    <br><br><br><br>

    <h1 class="title">Nuestros productos</h1>
    <br>
    <div class="container">
        <div class="row">
            @foreach($productos as $producto)
                <div class="col-12 col-md-4" style="margin-top: 40px">
                    <div class="card" style="width: 18rem;">
                        <div class="card-head">
                            <img style="width:100%;height: 200px;object-fit: cover" src="{{asset('storage/productsImages/'.$producto->foto)}}">
                        </div>
                        <div class="card-body" style="text-align: start">
                            <h3>{{$producto->title}}</h3>
                            <p>{{\Illuminate\Support\Str::limit($producto->description,100)}}</p>
                            <p>{{$producto->price}}€</p>
                        </div>
                        <div class="card-footer" style="text-align: center">
                            <a class="btn btn-success" href="{{route('product.show',$producto->id)}}">Ver producto</a>
                            @auth
                                <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i> Añadir al carrito</button>
                            @endauth

                        </div>

                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div id="carrousel-content">
        <div id="carrousel-box">
            <div class="carrousel-element">
                <a href="productos.html"><img class="images" src="{{asset('sources/data/varios.png')}}"
                                              alt="varios"></a>
            </div>
            <div class="carrousel-element">
                <a href="productos.html"><img class="images" src="{{asset('sources/data/deco.png')}}" alt="decoración"></a>
            </div>
            <div class="carrousel-element">
                <a href="productos.html"><img class="images" src="{{asset('sources/data/mueble.png')}}"
                                              alt="muebles"></a>
            </div>
        </div>
    </div>

@endsection
