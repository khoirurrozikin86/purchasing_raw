<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelaxOutDetail extends Model
{
    use HasFactory;

    Protected $fillable = [
        'relax_out_id',
        'original_no',
        'item_code',
        'color_code',
        'color_name',
        'size',
        'qty',
        'mo',
        'style',
        'note',
    ];

    public function relaxOut()
    {
        return $this->belongsTo(RelaxOut::class);
    }


    public function item()
    {
        return $this->belongsTo(Item::class, 'item_code', 'item_code');
    }

    public function materialInDetail()
    {
        return $this->belongsTo(QRCode::class, 'original_no', 'original_no');
    }

    public function materialInDetailx()
    {
        return $this->belongsTo(materialInDetail::class, 'original_no', 'original_no');
    }

    public function QRCode()
    {
        return $this->belongsTo(QRCode::class, 'original_no', 'original_no');
    }

}
