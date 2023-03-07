@extends("layouts.main")
@section("content")

    <div class="container">
        <div class="row">
            <div class="col-12" style="text-align: center">
                <h1>Carrito de compra</h1>
            </div>
            <div class="col-sm-12 col-md-12">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th class="text-center">Pricio unitario</th>
                        <th class="text-center">Sub total</th>
                        <th>Eliminar</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($cartItems as $item)
                    <tr>
                        <td class="col-sm-8 col-md-6">
                            <div class="media">
                                <div class="thumbnail pull-left" style="margin-right: 25px">
                                    <img src="{{asset('storage/productsImages/'.$item->product->foto)}}" style="width: 72px; height: 72px;object-fit: cover">
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading">{{$item->product->title}}</h4>
                                    <h5 class="media-heading"> Vendido por <span>{{$item->product->user->name}}</span></h5>
                                    <span>Estado: </span><span class="text-success"><strong>{{$item->product->state}}</strong></span>
                                </div>
                            </div></td>
                        <td class="col-sm-1 col-md-1" style="text-align: center">
                            {{$item->quantity}} unidades
                        </td>
                        <td class="col-sm-1 col-md-1 text-center"><strong>{{$item->product->price}}€</strong></td>
                        <td class="col-sm-1 col-md-1 text-center"><strong>{{$item->product->price*$item->quantity}}€</strong></td>
                        <td class="col-sm-1 col-md-1">
                            <button type="button" class="btn btn-danger" data-producto_id="{{$item->id}}">
                                <span class="glyphicon glyphicon-remove"></span> Eliminar
                            </button></td>
                    </tr>
                     @endforeach

                    <tr>
                        <td>   </td>
                        <td>   </td>
                        <td>   </td>
                        <td><h5>Subtotal</h5></td>
                        <td class="text-right"><h5><strong>$24.59</strong></h5></td>
                    </tr>
                    <tr>
                        <td>   </td>
                        <td>   </td>
                        <td>   </td>
                        <td><h5>Estimated shipping</h5></td>
                        <td class="text-right"><h5><strong>$6.94</strong></h5></td>
                    </tr>
                    <tr>
                        <td>   </td>
                        <td>   </td>
                        <td>   </td>
                        <td><h3>Total</h3></td>
                        <td class="text-right"><h3><strong>$31.53</strong></h3></td>
                    </tr>
                    <tr>
                        <td>   </td>
                        <td>   </td>
                        <td>   </td>
                        <td>   </td>
                        <td>
                            <button type="button" class="btn btn-success">
                                Pagar <span class="glyphicon glyphicon-play"></span>
                            </button></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
