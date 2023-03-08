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
                <button type="button"  class="btn btn-danger deleteCartItem"  data-id="{{$item->id}}"  data-toggle="modal" data-target="#confirmDeleteCartModal">
                    <span class="glyphicon glyphicon-remove"></span> Eliminar
                </button>
            </td>
        </tr>
    @endforeach
    <tr>
        <td>   </td>
        <td>   </td>
        <td>   </td>
        <td><h3>Total</h3></td>
        <td class="text-right"><h3><strong>{{number_format($totalAmount,2,',','.')}}€</strong></h3></td>
    </tr>
    <tr>
        <td>   </td>
        <td>   </td>
        <td>   </td>
        <td><h4>Descuento puntos:</h4></td>
        <td class="text-right">
            <h4>
                <strong>
                    -{{Auth::user()->credits > $totalAmount ? $totalAmount : Auth::user()->credits }} puntos</strong>
            </h4>
        </td>
    </tr>
    <tr>
        <td>   </td>
        <td>   </td>
        <td>   </td>
        <td>   </td>
        <td>
            <form action="{{ url('charge') }}" method="post">
                <input type="hidden" name="amount" value="{{$totalAmount-Auth::user()->credits < 0 ? 0 : $totalAmount-Auth::user()->credits}}" />
                {{ csrf_field() }}
                <input type="submit" class="btn btn-success" name="submit" value="Pagar ({{number_format( $totalAmount-Auth::user()->credits< 0? 0 : $totalAmount-Auth::user()->credits,2,',','.')}}€)">
            </form>


        </td>
    </tr>
    </tbody>
</table>
<!-- Confirm delete cart Modal -->
<div class="modal fade" id="confirmDeleteCartModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h5 class="modal-title" id="exampleModalLongTitle">¿Seguro que quieres eliminar este elemento del carrito?</h5>
            </div>
            <input type="hidden" name="cartitem_id_delete_input">
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="confirm_delete_cart_btn" data-dismiss="modal">Eliminar</button>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
<script>
    $('.deleteCartItem').click((e)=>{
        $('input[name="cartitem_id_delete_input"]').val(e.currentTarget.dataset.id)
    })
    $('#confirm_delete_cart_btn').click(()=> {
        let data = new FormData();
        data.append('cart_id', $('input[name="cartitem_id_delete_input"]').val());
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            },
            url: '{{route('cart.destroy')}}',
            type: 'post',
            contentType: false,
            processData: false,
            data: data,
            success: function (data) {
                $('#table_cart').html(data.view)
                toastr.success(data.message);
            },
            error: function (error) {
                toastr.error(error.responseJSON.message);
            }
        })
    })
</script>
