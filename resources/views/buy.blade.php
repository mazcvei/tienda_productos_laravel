@extends("layouts.main")
@section("content")

    <h1 class="title titlemargin"> Mi compra</h1>
    <div class="structure">
        <form action="#" method="POST">
            <div class="labelform">
                <label for="foto">Foto</label>
            </div>
            <div class="inputform">
                <input type="text" id="foto" name="foto" placeholder="">
            </div>
            <ul class="errors"></ul>
            <div class="labelform">
                <label for="titulo">Título</label>
            </div>
            <div class="inputform">
                <input type="text" id="title" name="title" placeholder="">
            </div>
            <ul class="errors"></ul>
            <div class="labelform">
                <label for="precio">Precio</label>
            </div>
            <div class="inputform">
                <input type="number" id="prize" min="0" name="prize" placeholder="">
            </div>
            <ul class="errors"></ul>
            <div class="labelform">
                <label for="ref">Referencia</label>
            </div>
            <div class="inputform">
                <input type="text" id="ref" name="ref" placeholder="">
            </div>
            <ul class="errors"></ul>
            <br>
            <ul class="errors"></ul>
            <a href="https://www.paypal.com"><img src="{{asset('sources/data/paypal.png')}}" class="logo"></a>
            <input type="submit" value="Comprar">
            <input class="out" type="submit" value="Eliminar">

        </form>
    </div>

@endsection
