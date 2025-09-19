<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UStockSum extends Model
{
    use HasFactory;

     // Nama tabel yang terhubung dengan model ini
     protected $table = 'u_stock_sum';

     // View tidak memiliki kolom auto-increment atau primary key
     public $incrementing = false;
 
     // Jika view tidak memiliki kolom timestamps (created_at dan updated_at)
     public $timestamps = false;
 
     // Kolom yang dapat diisi
     protected $fillable = [
         'item_code',
         'stok',
         'size',
         'color_code',
         'color_name'
     ];


     public function item()
    {
        return $this->belongsTo(Item::class, 'item_code', 'item_code');
    }
}
