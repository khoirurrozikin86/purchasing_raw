<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CbdDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_no',
        'color_code',
        'color',
        'pattern_dimension_code',
        'size_code',
        'size',
        'qty',
        'arrangment_by',
        'trim_description',
        'trim_item_no',
        'trim_supplier',
    ];


     // Define the inverse of the relationship with Cbd
     public function cbd()
     {
         return $this->belongsTo(Cbd::class, 'order_no', 'order_no');
     }

     public function consumptions()
     {
         return $this->hasMany(Consumption::class, 'cbd_detail_id');
     }
}
