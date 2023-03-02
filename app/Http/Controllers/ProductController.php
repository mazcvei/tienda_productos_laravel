<?php

namespace App\Http\Controllers;


use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{

    public function index(){
        $productos = Product::all();
        return view('products',compact('productos'));
    }
    public function store(Request $request){

        $path = null;
        if($request->file('foto')){
            $path=Str::random(15).time().$request->file('foto')->getClientOriginalExtension();
            Storage::putFileAs('public/productsImages', $request->file('foto'),$path);

        }

        Product::create([
            'user_id'=>Auth::id(),
            'foto'=>$path,
            'title'=>$request->title,
            'description'=>$request->descripcion,
            'price'=>$request->price,
            'stock'=>$request->stock,
            'state'=>$request->state,
        ]);
        $userProducts = User::find(Auth::id())->productos;
        $html = view('profile._partial_mis_productos',compact('userProducts'))->render();

        return response()->json(['message'=>'Producto creado correctamente.','view'=>$html]);
    }

    public function update(Request $request){
        $product = Product::find($request->product_id);
        if($product->user_id==Auth::id()){

            if($request->file('foto')){
                $path=Str::random(15).time().$request->file('foto')->getClientOriginalExtension();
                Storage::putFileAs('public/productsImages', $request->file('foto'),$path);
                $product->foto = $path;

            }
            $product->title = $request->title;
            $product->description = $request->descripcion;
            $product->price = $request->price;
            $product->stock = $request->stock;
            $product->state = $request->state;
            $product->save();
            $userProducts = User::find(Auth::id())->productos;
            $html = view('profile._partial_mis_productos',compact('userProducts'))->render();

            return response()->json(['message'=>'Producto creado correctamente.','view'=>$html]);
        }else{
            return response()->json(['message'=>'No tienes permisos.'],403);
        }

    }

    public function destroy(Request $request){
        $product = Product::find($request->product_id);
        if($product->user_id==Auth::id()){
            $product->delete();
            $userProducts = User::find(Auth::id())->productos;
            $html = view('profile._partial_mis_productos',compact('userProducts'))->render();

            return response()->json(['message'=>'Producto eliminado correctamente.','view'=>$html]);
        }

    }
}
