@extends("layouts.main")
@section("content")
    <style>
        p {
            margin: unset;
        }
        .materials_list li{
            list-style: disclosure-closed;
        }
    </style>
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-6">
                <img style="width: 100%" src="{{asset('storage/productsImages/'.$producto->foto)}}">
            </div>
            <div class="col-12 col-md-6">
                <h1>{{$producto->title}}</h1>
                <p>{{$producto->description}}</p>

                @if($producto->materiales)
                <p>Materiales:</p>
                    <ul style="margin-left: 15px" class="materials_list">
                        @foreach($producto->materiales as $materialPivot)
                           <li>{{$materialPivot->material->nombre}}</li>
                        @endforeach

                    </ul>
                @endif
                <p style="font-weight: bold;font-size: 16px">Precio: {{$producto->price}}€</p>

                @auth
                    <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i> Añadir al carrito</button>
                @endauth
            </div>
        </div>
    </div>

@endsection
