<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = ['unit_code', 'unit_name'];

    public function items()
    {
        return $this->hasMany(Item::class, 'category_id');
    }
}
