<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bom extends Model
{
    use HasFactory;

    protected $fillable = ['bom_no', 'cbd_id', 'style', 'remark1', 'remark2', 'remark3'];

    public function details()
    {
        return $this->hasMany(BomDetail::class);
    }

    public function cbd()
    {
        return $this->belongsTo(Cbd::class, 'cbd_id');
    }
}
