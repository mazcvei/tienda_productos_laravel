@extends("layouts.main")
@section('late_head')
    {!! RecaptchaV3::initJs() !!}
@endsection
@section("content")

    <div class="container">
        <h1 class="title">Contáctanos</h1>
        <br>
        <div class="box">
            <div class="info-business">
                <h1>Mercatavico</h1>
                    <br>
                    <ul class="services">
                        <li>Celso Emilio Ferreiro - 15320 As Pontes (A Coruña)</li>
                        <li>Teléfono:000 ​000 ​000</li>
                        </a>
                        <li><a href="mailto:mercatavico@gmail.com" title="mercatavico@gmail.com" target="_blank">E-mail:
                                mercatavico@gmail.com</a></li>
                    </ul>
                    <br>
                    <div class="map-responsive">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2896.4100714214933!2d-7.846619984679673!3d43.45203537343374!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd2e01642b9c38c3%3A0x7023b247ce7ccd80!2sR%C3%BAa%20Celso%20Emilio%20Ferreiro%2C%2015320%20As%20Pontes%20de%20Garc%C3%ADa%20Rodr%C3%ADguez%2C%20A%20Coru%C3%B1a!5e0!3m2!1ses!2ses!4v1669289724619!5m2!1ses!2ses"
                                width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
            </div>
            <div class="contact">
                <h3>Enviar Correo</h3>
                <form class="form">
                    @csrf
                    <div class="name">
                        <label for="name">Nombre</label>
                        <span class="input"><input type="text" id="name" name="name" maxlength="32"
                                                   pattern="^[a-zA-ZñÑáéíóúÁÉÍÓÚ]+$" required></span>
                        <ul class="errors"></ul>
                    </div>
                    <div class="email">
                        <label for="email">Correo</label>
                        <span class="input"><input type="text" id="email" name="email" maxlength="64"
                                                   pattern="[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{1,5}"
                                                   required></span>
                        <ul class="errors"></ul>
                    </div>
                    <div class="phone">
                        <label for="phone">Teléfono</label>
                        <span class="input"><input type="text" id="phone" name="phone" maxlength="32" pattern="[0-9]*"
                                                   required></span>
                        <ul class="errors"></ul>
                    </div>
                    <div class="message">
                        <label for="message">Mensaje</label>
                        <span class="textarea"><textarea rows="4" cols="50" type="text" id="message" name="msg"
                                                         maxlength="512" required></textarea></span>
                        <ul class="errors"></ul>
                    </div>
                    <br>
                    <div class="full">
                        <p>Al marcar, acepto y consiento el tratamiento de los datos facilitados para su tratamiento, de
                            acuerdo a lo dispuesto en el Reglamento (UE) 2016/679, de 27 de abril (RGPD), y la Ley
                            Orgánica 3/2018, de 5 de diciembre (LOPDGDD) y con la finalidad de atender y gestionar la
                            petición realizada, en base al consentimiento expresamente proporcionado. Los datos, tanto
                            los de carácter voluntario como los obligatorios, necesarios para atender las finalidades,
                            se conservados durante el tiempo necesario para atender a los fines del tratamiento y no
                            serán comunicados a terceros, salvo obligación legal. Como interesado puede ejercitar los
                            derechos de acceso, rectificación, portabilidad y supresión de sus datos y los de limitación
                            u oposición a su tratamiento ante Mercatavico, S.L. Parque Empresarial ​Mercatavico 00000
                            Ferrol (A Coruña). E-mail: imercatavico@gmail.com.</p>
                    </div>
                    <br>
                    <br>
                    <div class="form-group" style="display: flex">
                        <label>Acepto </label>
                        <input style="width: 20px;margin-left: 10px" type="checkbox" id="agree" name="agree" value="accept" required>
                    </div>

                    <div class="form-group{{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
                        {!! RecaptchaV3::field('contact') !!}
                        @if ($errors->has('g-recaptcha-response'))
                            <span class="help-block">
                                        <strong>Error: {{ $errors->first('g-recaptcha-response') }}</strong>
                                    </span>
                        @endif
                    </div>
                    <div class="full">
                        <button class="button-send" style="width: 100%;height: 75px" type="button">Enviar consulta</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('javascript')
    <script>
        $('.button-send').click(() => {
            let data = new FormData();
            data.append('name', $('input[name="name"]').val());
            data.append('email', $('input[name="email"]').val());
            data.append('phone', $('input[name="phone"]').val());
            data.append('msg', $('textarea[name="msg"]').val());
            data.append('g-recaptcha-response', $('input[name="g-recaptcha-response"]').val());
            data.append('agree',$('#agree').is(':checked'));

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                },
                url: '{{route('send.email')}}',
                type: 'post',
                contentType: false,
                processData: false,
                data: data,
                success: function (data) {
                    console.log(data)
                    toastr.success(data.message);
                    $('input[name="name"]').val('')
                    $('input[name="email"]').val('')
                    $('input[name="phone"]').val('')
                    $('textarea[name="msg"]').val('')
                    $('#agree').prop('checked',false)
                },
                error: function (error) {
                    console.log(error)
                    toastr.error(error.responseJSON.message);
                }
            });
        })
    </script>
@endsection
