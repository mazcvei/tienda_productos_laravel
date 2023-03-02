<?php

namespace App\Http\Controllers;

use App\Mail\MailContact;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;

class ContactController extends Controller
{
    public function index(){
        return view('contact');
    }
    public function enviarCorreo(Request $request)
    {

        if($request->agree == "false"){
            return response()->json(['status' => 'error_validación', 'message' => 'Debes aceptar los terminos y condiciones'],500);
        }

        $validator = Validator::make($request->all(),[
                'name'=>'required|string',
                'email'=>'required|email|string',
                'phone'=>'required',
                'msg'=>'required',
                'agree' => 'required',
        ]);
        if ($validator->fails()) {

            return response()->json(['status' => 'error_validación', 'message' => 'Los datos introducidos no son válidos.'],500);
        } else {
            $datos = $request->except('agree');
            //TODO=>Modificar
            Mail::to('mario.azcvei@hotmail.com')->send(new MailContact($datos));
            return response()->json(['status' => 'ok', 'message' => 'Se ha enviado el mensaje correctamente.'],200);

        }

    }

}
