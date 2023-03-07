<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function add($productId){
        $producto = Product::find($productId);
        if($producto){
            $cart = Cart::where('user_id',Auth::id())->where('product_id',$productId)->first();
            if($cart){
                $cart->quantity +=1;
                $cart->save();
            }else{
                Cart::create([
                    'user_id'=>Auth::id(),
                    'product_id'=>$productId,
                    'quantity'=>1,
                ]);
            }
            $ItemsCart = Auth::user()->cartItems->pluck('quantity');
            $numItems = 0;
            foreach($ItemsCart as $item){
                $numItems+=$item;
            }
            return response()->json(['status'=>'','message'=>'Producto añadido al carrito.','numItems'=>$numItems],201);
        }else{
            return response()->json(['status'=>'','message'=>'Ha ocurrido un error'],404);
        }


    }
    public function index(){
        $cartItems = Auth::user()->cartItems;
        return view('cart.buy',compact('cartItems'));
    }
}
