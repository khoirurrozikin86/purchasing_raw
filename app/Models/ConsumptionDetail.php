<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsumptionDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'consumption_id', 'type', 'amount'
    ];

    public function consumption()
    {
        return $this->belongsTo(Consumption::class);
    }
}
