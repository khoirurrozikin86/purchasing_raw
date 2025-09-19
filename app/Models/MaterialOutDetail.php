<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaterialOutDetail extends Model
{
    use HasFactory;

   

    protected $fillable = [
        'material_out_id',
        'original_no',
        'item_code',
        'color_code',
        'color_name',
        'size',
        'qty',
        'mo',
        'rak', 
        'style',
        'note',
        'deleted_at'
    ];

    public function materialOut()
    {
        return $this->belongsTo(MaterialOut::class, 'material_out_id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_code', 'item_code');
    }

    public function materialInDetail()
    {
        return $this->belongsTo(MaterialOut::class, 'material_out_id');
    }

}
