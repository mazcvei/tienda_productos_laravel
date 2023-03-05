<table class="table" id="tableProducts">

<thead class="thead-dark">
<tr>
    <th scope="col">Id</th>
    <th scope="col">Nombre y apellidos</th>
    <th scope="col">Email</th>
    <th scope="col">Créditos</th>
    <th scope="col">Rol</th>
    <th scope="col">Dirección</th>
    <th scope="col">Ciudad</th>
    <th scope="col">Código postal</th>
    <th scope="col">Editar/Borrar/Administrador</th>
</tr>
</thead>
<tbody>
@if(count($usuarios)>0)

    @foreach($usuarios as $usuario)
        <tr>
            <td>{{$usuario->id}}</td>
            <td>{{$usuario->name}}</td>
            <td>{{$usuario->email}}</td>
            <td>{{$usuario->credits}}</td>
            <td>{{$usuario->rol->name}}</td>
            <td>{{$usuario->addressUser ?  $usuario->addressUser->address : ''}}</td>
            <td>{{$usuario->addressUser ? $usuario->addressUser->city : ''}}</td>
            <td>{{$usuario->addressUser ? $usuario->addressUser->cp : ''}}</td>
            <td>
                <button class="btn btn-success edit_user" data-toggle="modal" data-target="#modalEditUsers" data-name="{{$usuario->name}}"
                        data-id="{{$usuario->id}}" data-email="{{$usuario->email}}" data-credits="{{$usuario->credits}}"
                        data-rol="{{$usuario->rol->name}}" data-address="{{$usuario->addressUser ? $usuario->addressUser->address : ''}}"
                        data-city="{{$usuario->addressUser ? $usuario->addressUser->city : ''}}"
                        data-cp="{{$usuario->addressUser ? $usuario->addressUser->cp : ''}}"
                >Editar</button>
                <button class="btn btn-danger deleteUser"  data-id="{{$usuario->id}}"  data-toggle="modal" data-target="#confirmDeleteUserModal">Eliminar</button>
                <button class="btn btn-warning btnSetAdmin" style="margin-top: 10px"  data-id="{{$usuario->id}}" >Convertir Administrador</button>

            </td>
        </tr>
    @endforeach
@else
    <p>No tienes produtos</p>

@endif

</tbody>
</table>

<!-- Edit user Modal -->
<div class="modal fade" id="modalEditUsers" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar usuario</h5>
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
                                <label for="mobile"><h4>Código postal</h4></label>
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
<!-- Confirm delete User Modal -->
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


    $('.edit_user').click((e)=>{
        console.log(e.currentTarget.dataset)
        $('input[name="user_id"]').val(e.currentTarget.dataset.id)
        $('input[name="name"]').val(e.currentTarget.dataset.name);
        $('input[name="email"]').val(e.currentTarget.dataset.email);
        $('input[name="credits"]').val(e.currentTarget.dataset.credits);
        $('input[name="address"]').val(e.currentTarget.dataset.address);
        $('input[name="city"]').val(e.currentTarget.dataset.city);
        $('input[name="cp"]').val(e.currentTarget.dataset.cp);
    })
    /*
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
    */
    $('.btnSetAdmin').click((e)=>{
        console.log( e.currentTarget.dataset.id)
        let data = new FormData();
        data.append('user_id', e.currentTarget.dataset.id);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            },
            url: '{{route('change.rol')}}',
            type: 'post',
            contentType: false,
            processData: false,
            data: data,
            success: function (data) {
                toastr.success(data.message);
                $('#contentUsers').html(data.view)
            },
            error: function (error) {
                toastr.error(error.responseJSON.message);
            }
        });
    })

     /*
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
