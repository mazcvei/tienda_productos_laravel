@extends("layouts.main")
@section("content")
    <style>
        p {
            margin: unset;
        }
    </style>
    <h1 class="title titlemargin">ENCUENTRA TU RELIQUIA</h1>
    <div class="structure">
        <form action="#" method="POST">
            <div class="labelform">
                <label for="mercatavico">Productos de Mercatavico</label>
            </div>
            <div class="inputform">
                <input type="checkbox" id="mercatavico" name="mercatavico">
            </div>
            <div class="labelform">
                <label for="pmin">Precio mínimo</label>
            </div>
            <div class="inputform">
                <input type="number" id="pmin" name="pmin" min="0" placeholder="min ...">
            </div>
            <div class="labelform">
                <label for="pmax">Precio máximo</label>
            </div>
            <div class="inputform">
                <input type="number" id="pmax" name="pmax" min="0" placeholder="max ...">
            </div>
            <div class="labelform">
                <label for="state">Estado</label><br>
            </div>
            <select name="state" id="state">
                <option value="broke">Roto</option>
                <option value="restore">Restaurado</option>
            </select>
            <input type="submit" value="Filtrar">
        </form>
    </div>
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

@endsection
