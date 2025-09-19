<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaterialReturn extends Model
{
    use HasFactory;

   

    
    protected $fillable = [
        'material_return_no',
        'department',
        'person',
        'remark',
        'status',
        'user_id',
        'deleted_at',
    ];

    public function details()
    {
        return $this->hasMany(MaterialReturnDetail::class);
    }

}
