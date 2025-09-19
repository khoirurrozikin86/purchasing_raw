<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaterialOut extends Model
{
    use HasFactory;
 

    protected $fillable = [
        'material_out_no',
        'allocation',
        'person',
        'remark',
        'status',
        'user_id',
        'deleted_at',
    ];

    public function details()
    {
        return $this->hasMany(MaterialOutDetail::class, 'material_out_id');
    }
}
