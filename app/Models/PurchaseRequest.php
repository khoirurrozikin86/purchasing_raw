<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseRequest extends Model
{
    use HasFactory;

    use SoftDeletes;

    // protected $guarded = [];

    protected $fillable = ['user_id', 'cbd_id','purchase_request_no','tipe','mo','style','destination','department','applicant','time_line','remark1','status' ,'revision_no','deleted_at','created_at','updated_at'];

    public function detailrequest()
    {
        return $this->hasMany(PurchaseRequestDetail::class, 'purchase_request_id');
    }

    public function purchaseOrders()
    {
        return $this->hasMany(PurchaseOrder::class);
    }

    
    public function cbd()
    {
        return $this->belongsTo(Cbd::class, 'cbd_id');
    }
  public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
   
}
