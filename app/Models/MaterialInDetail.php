<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaterialInDetail extends Model
{
    use HasFactory;

  

    protected $fillable = [
        'material_in_id', 
        'purchase_order_id', 
        'original_no',
        'receive_date',
        'supplier_name',
        'item_code',
        'po',
        'size',
        'color_code',
        'color_name',
        'batch',
        'roll',
        'gross_weight',
        'net_weight',
        'qty',
        'basic_width',
        'basic_grm',
        'mo',
        'actual_weight',
        'rak',
        'note',
        'deleted_at'
    ];

    public function materialIn()
    {
        return $this->belongsTo(MaterialIn::class, 'material_in_id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_code','item_code');
    }

    public function purchaseorder(){
        return $this->belongsTo(PurchaseOrder::class, 'purchase_order_id');
    }

}
