<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $table = "users";
    protected $fillable = ['name','email','credits','rol_id','password'];
    public function addressUser(){
        return $this->hasOne(UserAddress::class,'user_id');
    }
    public function productos(){
        return $this->hasMany(Product::class,'user_id','id');
    }
    public function rol(){
        return $this->belongsTo(Rol::class,'rol_id','id');
    }
    public function cartItems(){
        return $this->hasMany(Cart::class,'user_id','id');
    }
    public function orders(){
        return $this->hasMany(Order::class,'user_id','id');
    }


}
