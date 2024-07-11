<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainCategoryModel extends Model
{
    use HasFactory;
    protected $table = 'main_category';

    public function subCategory()
    {
        return $this->hasMany(SubCategoryModel::class, 'id', 'main_category_id');
    }
}
