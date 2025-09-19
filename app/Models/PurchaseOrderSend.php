<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderSend extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_order_no',
        'status',
        'remark',
    ];

    // Relasi dengan PurchaseOrder berdasarkan purchase_order_no
    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class, 'purchase_order_no', 'purchase_order_no');
    }
}
