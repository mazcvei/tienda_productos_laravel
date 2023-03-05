<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialPivot extends Model
{
    use HasFactory;
    protected $table = "pivot_materials_products";
    protected $fillable = ['product_id','material_id'];
    public function material(){
        return $this->belongsTo(Material::class,'material_id','id');
    }
    public function producto(){
        return $this->belongsTo(Product::class,'product','id');
    }
}
