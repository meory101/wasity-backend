<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubBranchModel extends Model
{
    use HasFactory;
    protected $table = 'sub_branch';
    public function mainCategory()
    {
        return $this->belongsTo(MainCategoryModel::class, 'main_category_id', 'id');
    }

    public function manager()
    {
        return $this->belongsTo(ManagerModel::class, 'manager_id', 'id');
    }

}
