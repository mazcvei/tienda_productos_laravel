<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class CartHelper
{

    public static function getItemsCart(){
       if(Auth::check()){
           $ItemsCart = Auth::user()->cartItems->pluck('quantity');
           $numItems = 0;
           foreach($ItemsCart as $item){
               $numItems+=$item;
           }
           return $numItems;
       }else{
           return 0;
       }

    }
}
