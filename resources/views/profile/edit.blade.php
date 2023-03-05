@extends("layouts.main")
@section("content")
    <style>
        label {
            display: inline-block;
            margin-bottom: .1rem;
        }
        .card {
            text-align: center;
        }
        .contenedor_datos{
            margin-top: 50px;height: 50vh;overflow: auto;
        }
    </style>
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-8" style="margin:auto">
                <div class="card">
                    <div class="card-head" style="text-align: center">
                        <h1>Mis datos</h1>
                        @if($errors->any())
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li style="color:red;font-weight: bold">- {{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                    <div class="card-body">
                        <form method="POST" id="form_edit_user">
                            @csrf
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <div class="labelform">
                                            <label for="name">Nombre y apellidos</label>
                                        </div>
                                        <div class="inputform">
                                            <input type="text" id="name" name="name" placeholder=""
                                                   value="{{\Illuminate\Support\Facades\Auth::user()->name}}">
                                        </div>
                                        <ul class="errors"></ul>
                                    </div>
                                    <div class="form-group">
                                        <div class="labelform">
                                            <label for="email">Correo</label>
                                        </div>
                                        <div class="inputform">
                                            <input required type="text" id="email" name="email" value="{{Auth::user()->email}}">
                                        </div>
                                        <ul class="errors"></ul>
                                    </div>
                                    <div class="form-group">
                                        <div class="labelform">
                                            <label for="password">Contraseña</label>
                                        </div>
                                        <div class="inputform">
                                            <input type="password" id="password" autocomplete="new-password" name="password"
                                                   placeholder=""><br>
                                            <small>Dejar en blanco para mantener la misma</small>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="labelform">
                                            <label for="password_c">Confirmar contraseña</label>
                                        </div>
                                        <div class="inputform">
                                            <input type="password" id="password_c" autocomplete="new-password"
                                                   name="password_confirmation"><br>
                                            <small>Dejar en blanco para mantener la misma</small>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <div class="labelform">
                                            <fieldset>
                                                <legend>Datos de facturación</legend>
                                                <div class="labelform">
                                                    <label for="address">Direccion</label>
                                                </div>
                                                <div class="inputform">
                                                    <input required type="text" id="address" name="address"
                                                           value="{{Auth::user()->addressUser ? Auth::user()->addressUser->address : ''}}">
                                                </div>
                                                <div class="labelform">
                                                    <label for="ciudad">Ciudad</label>
                                                </div>
                                                <div class="inputform">
                                                    <input required type="text" id="ciudad" name="ciudad"
                                                           value="{{Auth::user()->addressUser ? Auth::user()->addressUser->city : ''}}">
                                                </div>
                                                <div class="labelform">
                                                    <label for="cp">Codigo postal</label>
                                                </div>
                                                <div class="inputform">
                                                    <input required type="text" id="cp" name="cp"
                                                           value="{{Auth::user()->addressUser ? Auth::user()->addressUser->cp : ''}}">
                                                </div>
                                            </fieldset>
                                        </div>
                                        <ul class="errors"></ul>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <ul class="errors"></ul>
                            <button id="btn_submit_user" class="btn btn-primary" type="button">Editar</button>
                        </form>

                    </div>
                    <div>
                        <p style="color:red"></p>
                    </div>
                </div>
            </div>
            <div class="col-12" style="text-align: center;margin-top: 50px">
                <h1>Mis productos</h1>
                <button class="btn btn-primary" data-toggle="modal" data-target="#modalAddProducts">Añadir
                    producto
                </button>
                    <div id="contentProductos" class="contenedor_datos">
                        @include('profile._partial_mis_productos',$userProducts)
                    </div>
            </div>
            @if(\Illuminate\Support\Facades\Auth::user()->rol->name=="administrador")
                <div class="col-12" style="text-align: center;margin-top: 50px">
                    <h1>Usuarios</h1>

                    <div id="contentUsers" style="margin-top: 50px">
                        @include('profile._partial_usuarios',$userProducts)
                    </div>
                </div>

                <div class="col-12" style="text-align: center;margin-top: 50px">
                    <h1>Materiales</h1>

                    <div id="contentMaterials" style="margin-top: 50px">
                        @include('profile._partial_materials',$materials)
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalAddProducts" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Añadir producto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addProduct">
                        <div class="row" style="width: 100%">

                            <div class="form-group col-12" style="text-align: center">
                                <img style="width:200px" src="http://ssl.gstatic.com/accounts/ui/avatar_2x.png"
                                     class="avatar img-circle img-thumbnail" alt="image">
                                <h6>Añade una foto</h6>
                                <input type="file" name="foto" accept="image/*" class="text-center center-block file-upload">
                            </div>
                            <div class="form-group col-12 col-md-6">

                                <div class="col-xs-6">
                                    <label for="title"><h4>Titulo</h4></label>
                                    <input type="text" class="form-control" name="title" id="title">
                                </div>
                            </div>
                            <div class="form-group col-12 col-md-6">
                                <div class="col-xs-6">
                                    <label for="last_name"><h4>Descripcion</h4></label>
                                    <textarea type="text" class="form-control" name="descripcion"></textarea>
                                </div>
                            </div>
                            <div class="form-group col-12 col-md-6">

                                <div class="col-xs-6">
                                    <label for="phone"><h4>Precio</h4></label>
                                    <input type="number" required step="0.01" class="form-control" name="price">
                                </div>
                            </div>
                            <div class="form-group col-12 col-md-6">
                                <div class="col-xs-6">
                                    <label for="mobile"><h4>Stock</h4></label>
                                    <input  required type="number" step="1" class="form-control" name="stock">
                                </div>
                            </div>
                            <div class="form-group col-12 col-md-6">

                                <div class="col-xs-6">
                                    <label for="email"><h4>Estado</h4></label>
                                    <select class="form-control" name="state">
                                        <option value="Nuevo">Nuevo</option>
                                        <option value="Usado">Usado</option>
                                        <option value="Estropeado">Estropeado</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-12 col-md-6">
                                <div class="col-xs-6">
                                    <label for="state"><h4>Materiales (múltiple)</h4></label>
                                    <select class="form-control" id="inputSelectMateriales" name="materiales" multiple="multiple">
                                        @foreach($materials as $material)
                                            <option value="{{$material->id}}">{{$material->nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="btnSaveProduct" data-dismiss="modal">Guardar producto</button>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('javascript')
    <script>
        $('#btn_submit_user').click(() => {
            console.log($('input[name="_token"]').val())
            let data = new FormData();
            data.append('name', $('input[name="name"]').val());
            data.append('email', $('input[name="email"]').val());
            data.append('password', $('input[name="password"]').val());
            data.append('password_confirmation', $('input[name="password_confirmation"]').val());
            data.append('address', $('input[name="address"]').val());
            data.append('ciudad', $('input[name="ciudad"]').val());
            data.append('cp', $('input[name="cp"]').val());
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                },
                url: '{{route('profile.update')}}',
                type: 'post',
                contentType: false,
                processData: false,
                data: data,
                success: function (data) {
                    toastr.success(data.message);
                },
                error: function (error) {
                    toastr.error(error);
                }
            });
        })

        var readURL = function (input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('.avatar').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
        $(".file-upload").on('change', function () {
            readURL(this);
        });
        $('#btnSaveProduct').click(()=>{
            let data = new FormData();
            data.append('title', $('input[name="title"]').val());
            data.append('foto', $('input[name="foto"]')[0].files[0]);
            data.append('descripcion', $('textarea[name="descripcion"]').val());
            data.append('price', $('input[name="price"]').val());
            data.append('stock', $('input[name="stock"]').val());
            data.append('state', $('select[name="state"]').val());
            data.append('materiales', $('#inputSelectMateriales').val());
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                url: '{{route('product.store')}}',
                type: 'post',
                contentType: false,
                processData: false,
                data: data,
                success: function (data) {
                    console.log(data)
                    $('#contentProductos').html(data.view)
                    $('#addProduct')[0].reset();
                    $('.img-thumbnail').attr('src','http://ssl.gstatic.com/accounts/ui/avatar_2x.png')
                    toastr.success(data.message);
                },
                error: function (error) {
                    toastr.error(error);
                }
            });
        })





    </script>

@endsection
