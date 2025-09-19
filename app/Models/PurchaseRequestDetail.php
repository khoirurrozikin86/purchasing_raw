<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseRequestDetail extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];

    protected $fillable = ['purchase_request_id', 'item_id', 'supplier_id','color','size','qty','consumtion','allowance','total','status','remark','stock','deleted_at','created_at','updated_at'];

    
    public function purchaserequest()
    {
        return $this->belongsTo(PurchaseRequest::class, 'purchase_request_id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }   

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }   

}
