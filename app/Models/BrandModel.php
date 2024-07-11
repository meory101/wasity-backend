<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrandModel extends Model
{
    use HasFactory;
    protected $table = 'brand';


    public function product(){
        return $this->hasMany(ProductModel::class,'id','brand_id');
    }
}
