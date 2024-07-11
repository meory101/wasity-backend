<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainBranchModel extends Model
{
    use HasFactory;
    protected $table = 'main_branch';

    public function subBranch()
    {
        return $this->hasMany(SubBranchModel::class, 'id', 'main_branch_id');
    }
}
