<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class DeliveryManModel extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'delivery_man';
    public function otp()
    {
        return $this->hasMany(OTPModel::class, 'id', 'client_id');
    }
    public function deliveryMan()
    {
        return $this->hasMany(DeliveryManModel::class, 'id', 'delivery_man_id');
    }
}
