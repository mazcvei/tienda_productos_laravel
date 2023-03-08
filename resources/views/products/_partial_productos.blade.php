@foreach($productos as $producto)
    <div class="col-12 col-md-4 product_item_list" style="margin-top: 40px"
         data-price="{{$producto->price}}"
         data-title="{{$producto->title}}" data-estado="{{$producto->state}}">

        <div class="card" style="width: 18rem;">
            <div class="card-head">
                <img style="width:100%;height: 200px;object-fit: cover" src="{{asset('storage/productsImages/'.$producto->foto)}}">
            </div>
            <div class="card-body" style="text-align: start">
                <h3>{{$producto->title}}</h3>
                <p>{{\Illuminate\Support\Str::limit($producto->description,100)}}</p>
                <p>{{$producto->price}}€</p>
                <p>Estado: {{$producto->state}}</p>
            </div>
            <div class="card-footer" style="text-align: center">
                <a class="btn btn-success" href="{{route('product.show',$producto->id)}}">Ver producto</a>
                @auth
                    @if($producto->user->id!=\Illuminate\Support\Facades\Auth::id())
                        <button type="button" class="btn btn-primary addCartBtn" data-product_id="{{$producto->id}}" ><i class="fa fa-plus"></i> Añadir al carrito</button>
                    @endif
                @endauth
            </div>

        </div>
    </div>
@endforeach
<script src="https://code.jquery.com/jquery-3.6.3.min.js"
        integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
<script>
    $('#btnFilter').click((e) => {

        $('#content_products').html('')
        let estado = $('#state').val().toLowerCase();
        let pmin = $('#pmin').val() ? $('#pmin').val() : 0;
        let pmax = $('#pmax').val() ? $('#pmax').val() : 999999999;
        let data = new FormData();
        data.append('estado',estado);
        data.append('pmin',pmin);
        data.append('pmax',pmax);


        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            url: '{{route('product.filter')}}',
            type: 'post',
            contentType: false,
            processData: false,
            data: data,
            success: function (data) {
                $('#content_products').html(data.view)
            },
            error: function (error) {
                toastr.error(error.responseJSON.message);
            }
        });
    })
</script>
