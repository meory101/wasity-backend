<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderModel extends Model
{
    use HasFactory;
    protected $table = 'order';
    public function client()
    {
        return $this->belongsTo(ClientModel::class, 'client_id', 'id');
    }
    public function deliveryMan()
    {
        return $this->belongsTo(DeliveryManModel::class, 'delivery_man_id', 'id');
    }
    public function product()
    {
        return $this->belongsTo(ProductModel::class, 'product_id', 'id');
    }
    public function paymentSummary()
    {
        return $this->hasOne(PaymentSummaryModel::class, 'id', 'order_id');
    }
}
