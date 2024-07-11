<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductModel extends Model
{
    use HasFactory;
    protected $table = 'product';

    public function brand()
    {
        return $this->belongsTo(BrandModel::class, 'brand_id', 'id');
    }
    public function subCategory()
    {
        return $this->belongsTo(SubCategoryModel::class, 'sub_categoy_id', 'id');
    }
    public function order()
    {
        return $this->hasMany(OrderModel::class, 'product_id', 'id');
    }
}
