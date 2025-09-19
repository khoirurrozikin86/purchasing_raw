<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BomDetail extends Model
{
    use HasFactory;



    protected $fillable = ['bom_id', 'item_id', 'size', 'consumption', 'remark1', 'remark2', 'remark3'];

    public function bom()
    {
        return $this->belongsTo(Bom::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
}
