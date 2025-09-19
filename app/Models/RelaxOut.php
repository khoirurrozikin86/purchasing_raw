<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelaxOut extends Model
{
    use HasFactory;


    protected $fillable = [
        'relax_out_no',
        'allocation',
        'person',
        'remark',
        'status',
        'user_id',
    ];


    public function details()
    {
        return $this->hasMany(RelaxOutDetail::class);
    }
}
