<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UStockMutationOri extends Model
{
    use HasFactory;


      // Nama tabel yang terhubung dengan model ini
      protected $table = 'u_stock_ori_mutation';

      // View tidak memiliki kolom auto-increment atau primary key
      public $incrementing = false;
  
      // Jika view tidak memiliki kolom timestamps (created_at dan updated_at)
      public $timestamps = false;
  
      // Kolom yang dapat diisi
      protected $fillable = [
          'original_no',
          'item_code',
          'size',
          'color_code',
          'color_name',
          'tanggal',
          'in_qty',
          'out_qty',
          'balance',
      ];
 
 
      public function item()
     {
         return $this->belongsTo(Item::class, 'item_code', 'item_code');
     }

     public function qrs()
     {
      return $this->belongsTo(QRCode::class, 'original_no', 'original_no');
     }
  
     public function materialInDetail()
      {
          return $this->belongsTo(MaterialInDetail::class, 'original_no', 'original_no');
      }
}
