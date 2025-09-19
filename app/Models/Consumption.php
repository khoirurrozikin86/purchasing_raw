<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consumption extends Model
{
    use HasFactory;

    protected $fillable = [
        'cbd_detail_id',
        'width',
        'consumption',
        'remark',
    ];

    // Define the relationship to the CbdDetail model
    public function cbdDetail()
    {
        return $this->belongsTo(CbdDetail::class, 'cbd_detail_id','id');
    }

    public function details()
    {
        return $this->hasMany(ConsumptionDetail::class);
    }
}
