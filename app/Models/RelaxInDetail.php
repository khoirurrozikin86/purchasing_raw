<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelaxInDetail extends Model
{
    use HasFactory;



    protected $fillable = [
        'relax_in_id',
        'original_no',
        'item_code',
        'size',
        'color_code',
        'color_name',
        'qty',
        'style',
        'mo_number',
        'fabric_pcs',
        'inspec_machine_no',
        'act_width_front',
        'act_width_center',
        'act_width_back',
        'panjang_actual',
        'hasil_fabric_ins',
        'kotor',
        'crease_mark',
        'knot',
        'hole',
        'missing_yarn',
        'foreign_yarn',
        'benang_tebal',
        'kontaminasi',
        'shinning_others',
        'maxim_ok_point',
        'pass_ng',
        'relaxing_rack_no',
        'b_roll_rack_no',
        'reason',
        'selisih',
        'sambungan_di_meter',
    ];

    public function relaxIn()
    {
        return $this->belongsTo(RelaxIn::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_code', 'item_code');
    }

    public function QRCode()
    {
        return $this->belongsTo(QRCode::class, 'original_no', 'original_no');
    }


    
    public function uStockRelax()
    {
        return $this->hasOne(UStockRelax::class, 'original_no', 'original_no');
    }

    
}
