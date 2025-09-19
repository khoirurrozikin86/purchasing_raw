<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaterialReturnDetail extends Model
{
    use HasFactory;

  

    protected $fillable = [
        'material_return_id',
        'original_no',
        'item_code',
        'color_code',
        'color_name',
        'size',
        'qty',
        'note',
        'deleted_at',
    ];


    public function materialReturn()
    {
        return $this->belongsTo(MaterialReturn::class);
    }


    public function item()
    {
        return $this->belongsTo(Item::class, 'item_code', 'item_code');
    }

    public function QRCode()
    {
        return $this->belongsTo(QRCode::class, 'original_no', 'original_no');
    }

    public function materialInDetail()
    {
        return $this->belongsTo(materialInDetail::class, 'original_no', 'original_no');
    }
}
