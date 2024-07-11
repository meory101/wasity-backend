<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentSummaryModel extends Model
{
    use HasFactory;
    protected $table = 'payment_summary';

    public function order()
    {
        return $this->belongsTo(OrderModel::class, 'order_id', 'id');
    }
}
