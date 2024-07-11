<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class ManagerModel extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'manager';
    public function role()
    {
        return $this->belongsTo(RoleModel::class, 'role_id', 'id');
    }

    public function subBranch()
    {
        return $this->hasOne(SubBranchModel::class, 'id', 'manager_id');
    }
}
