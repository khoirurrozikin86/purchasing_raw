<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QRCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'original_no',
        'received_date',
        'supplier_name',
        'item_code',
        'po',
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
    ]; 

}
