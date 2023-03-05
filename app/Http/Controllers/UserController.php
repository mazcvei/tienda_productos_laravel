<?php

namespace App\Http\Controllers;

use App\Models\rol;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function changeRol(Request $request){
        if($request->user_id == Auth::id()){
            return response()->json(['message'=>'No puedes cambiarte el rol a ti mismo.'],403);
        }
        if(Auth::user()->rol->name=="administrador"){
            $user = User::find($request->user_id);
            if($user){
                if($user->rol->name=="administrador"){
                    $newRol = Rol::where('name','usuario_registrado')->first()->id;
                    $user->rol_id = $newRol;
                    $user->save();
                }else{
                    $newRol = Rol::where('name','administrador')->first()->id;
                    $user->rol_id = $newRol;
                    $user->save();
                }
                $usuarios = User::all();
                $html = view('profile._partial_usuarios',compact('usuarios'))->render();
                return response()->json(['message'=>'Rol cambiado correctamente','view'=>$html],201);
            }else{
                return response()->json(['status'=>'error'],404);
            }

        }else{
            return response()->json(['status'=>'error'],403);
        }
    }
}
