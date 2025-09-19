<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseOrder extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'purchase_order_no',
        'purchase_request_id',
        'supplier_id',
        'date_in_house',
        'quotation_no',
        'quotation_file',
        'delivery_at',
        'terms',
        'payment',
        'ship_mode',
        'applicant',
        'allocation',
        'approval',
        'subtotal',
        'rounding',
        'discount',
        'vat',
        'vat_amount',
        'grand_total',
        'purchase_amount',
        'note1',
        'note2',
        'rule',
        'status',
        'remarksx',
        'revision_no',
        'user_id',
        'deleted_at',
    	'dpp',
        'created_at'];

 


       // Relationship methods

    public function purchaseRequest()
    {
        return $this->belongsTo(PurchaseRequest::class, 'purchase_request_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function detailorder()
    {
        return $this->hasMany(PurchaseOrderDetail::class, 'purchase_order_id');
    }
}
