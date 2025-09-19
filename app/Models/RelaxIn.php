<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelaxIn extends Model
{
    use HasFactory;


    protected $fillable = [
        'relax_in_no',
        'material_out_id',
        'person',
        'remark',
        'status',
        'user_id',
    ];

    public function details()
    {
        return $this->hasMany(RelaxInDetail::class);
    }

    public function materialout(){
        return $this->belongsTo(MaterialOut::class, 'material_out_id', 'id');
    }
}
