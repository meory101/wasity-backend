<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OTPModel extends Model
{
    use HasFactory;
    protected $table = 'otp';


    public function client(){
        return $this->belongsTo(ClientModel::class,'client_id','id');
    }
    public function deliveryMan()
    {
        return $this->belongsTo(DeliveryManModel::class, 'delivery_man_id', 'id');
    }
}
