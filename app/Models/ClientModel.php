<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class ClientModel extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'client';

    public function otp()
    {
        return $this->hasMany(OTPModel::class, 'id', 'client_id');
    }

    public function order()
    {
        return $this->hasMany(OrderModel::class, 'id', 'client_id');
    }
}
