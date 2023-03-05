<table class="table" id="tableProducts">

<thead class="thead-dark">
<tr>
    <th scope="col">Id</th>
    <th scope="col">Nombre</th>
    <th scope="col">Editar/borrar</th>
</tr>
</thead>
<tbody>
@if(count($materials)>0)

    @foreach($materials as $material)
        <tr>
            <td>{{$material->id}}</td>
            <td>{{$material->nombre}}</td>

            <td>
                <button class="btn btn-success edit_material" data-toggle="modal" data-target="#modalEditMaterials" data-name="{{$material->nombre}}"
                        data-id="{{$material->id}}">Editar</button>
                <button class="btn btn-danger deleteMaterial"  data-id="{{$material->id}}"  data-toggle="modal" data-target="#confirmDeleteMaterialModal">Eliminar</button>

            </td>
        </tr>
    @endforeach
@else
    <p>No tienes produtos</p>

@endif

</tbody>
</table>

<!-- Edit product Modal -->
<div class="modal fade" id="modalEditUsers" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editProduct">
                    <div class="row" style="width: 100%">
                        <input type="hidden" class="form-control" name="user_id" id="user_id">

                        <div class="form-group col-12 col-md-6">

                            <div class="col-xs-6">
                                <label for="title"><h4>Nombre y apellidos</h4></label>
                                <input type="text" class="form-control" name="name" id="name">
                            </div>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <div class="col-xs-6">
                                <label for="last_name"><h4>Email</h4></label>
                                <input type="text" class="form-control" name="email">
                            </div>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <div class="col-xs-6">
                                <label for="phone"><h4>Créditos</h4></label>
                                <input type="number" required step="1" class="form-control" name="credits">
                            </div>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <div class="col-xs-6">
                                <label for="mobile"><h4>Driección</h4></label>
                                <input  required type="text"  class="form-control" name="address">
                            </div>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <div class="col-xs-6">
                                <label for="mobile"><h4>Ciudad</h4></label>
                                <input  required type="text"  class="form-control" name="city">
                            </div>
                        </div>
                        <div class="form-group col-12 col-md-6">
                            <div class="col-xs-6">
                                <label for="mobile"><h4>Código postla</h4></label>
                                <input  required type="text"  class="form-control" name="cp">
                            </div>
                        </div>

                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btnUpdateProduct" data-dismiss="modal">Guardar producto</button>
            </div>
        </div>
    </div>
</div>
<!-- Confirm delte Modal -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-body">
                <h5 class="modal-title" id="exampleModalLongTitle">¿Seguro que quieres eliminar este usuario?</h5>
            </div>
            <input type="hidden" name="user_id_delete_input">
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary confirm_delete_btn" data-dismiss="modal">Eliminar</button>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
<script>
    /*
    $('.edit_product').click((e)=>{
        console.log(e.currentTarget.dataset)
        $('.img-thumbnail_edit').attr('src','{{asset('storage/productsImages/')}}/'+e.currentTarget.dataset.foto)
        $('input[name="product_id"]').val(e.currentTarget.dataset.id)
        $('input[name="title_edit"]').val(e.currentTarget.dataset.title);
        $('textarea[name="descripcion_edit"]').val(e.currentTarget.dataset.description);
        $('input[name="price_edit"]').val(e.currentTarget.dataset.price);
        $('input[name="stock_edit"]').val(e.currentTarget.dataset.stock);
        $('select[name="state_edit"]').val(e.currentTarget.dataset.state);
    })
    $('.deleteProduct').click((e)=>{
        $('input[name="user_id_delete_input"]').val(e.currentTarget.dataset.id)
    })
    $('.confirm_delete_btn').click(()=> {
        let data = new FormData();
        data.append('product_id', $('input[name="product_id_delete_input"]').val());
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            },
            url: '{{route('product.destroy')}}',
            type: 'post',
            contentType: false,
            processData: false,
            data: data,
            success: function (data) {
                $('#contentProductos').html(data.view)
                $('input[name="product_id_delete_input"]').val('')
                $('.modal-backdrop').remove()
                $('body').removeClass('modal-open')
                toastr.success(data.message);
            },
            error: function (error) {
                toastr.error(error);
            }
        })
    })
    $('#btnUpdateProduct').click(()=>{

        let data = new FormData();
        data.append('product_id', $('input[name="product_id"]').val());
        data.append('title', $('input[name="title_edit"]').val());
        data.append('foto', $('input[name="foto_edit"]')[0].files[0]);
        data.append('descripcion', $('textarea[name="descripcion_edit"]').val());
        data.append('price', $('input[name="price_edit"]').val());
        data.append('stock', $('input[name="stock_edit"]').val());
        data.append('state', $('select[name="state_edit"]').val());
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            },
            url: '{{route('product.update')}}',
            type: 'post',
            contentType: false,
            processData: false,
            data: data,
            success: function (data) {
                console.log(data)
                $('#contentProductos').html(data.view)
                $('#editProduct')[0].reset();
                $('.img-thumbnail').attr('src','')
                $('.modal-backdrop').remove()
                $('body').removeClass('modal-open')
                toastr.success(data.message);
            },
            error: function (error) {
                toastr.error(error);
            }
        });
        var readURL = function (input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('.img-thumbnail_edit').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#foto_edit_input").change(()=>{
            console.log('cambiandp')
            readURL(this);
        })
    })
    */

</script>
