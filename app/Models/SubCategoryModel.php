<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategoryModel extends Model
{
    use HasFactory;
    protected $table = 'sub_category';


    public function mainBranch()
    {
        return $this->belongsTo(MainBranchModel::class, 'main_branch_id', 'id');
    }
}
