<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UStockSumOri extends Model
{
    use HasFactory;


    protected $table = 'u_stock_original_sum';

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
        'stok',
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
