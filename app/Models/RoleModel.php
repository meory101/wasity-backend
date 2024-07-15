<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleModel extends Model
{
    use HasFactory;
    protected $table = 'role';

    public function manager()
    {
        return $this->hasMany(ManagerModel::class, 'id', 'role_id');
    }
}
