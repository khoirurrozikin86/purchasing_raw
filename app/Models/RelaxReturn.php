<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelaxReturn extends Model
{
    use HasFactory;


    protected $fillable = [
          'relax_return_no',
          'fromx',
          'person',
          'remark',
          'status',
          'user_id',
      ];


      public function details()
      {
          return $this->hasMany(RelaxReturnDetail::class);
      }
}
