<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cbd extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_no',
        'revision_no',
        'year',
        'planning_ssn',
        'global_business_unit',
        'business_unit',
        'item_brand',
        'department',
        'revised_date',
        'document_status',
        'answered_status',
        'vendor_person_in_change',
        'decision_date',
        'payment_terms',
        'contracted_etd',
        'eta_wh',
        'approver',
        'approval_date',
        'order_condition',
        'remark',
        'raw_material_code',
        'supplier_raw_material_code',
        'supplier_raw_material',
        'vendor_code',
        'vendor',
        'management_factory_code',
        'management_factory',
        'branch_factory_code',
        'branch_factory',
        'order_plan_number',
        'item_code',
        'item',
        'representative_sample_code',
        'sample_code',
        'contracted_etd2',
        'eta_wh2',
        'remark2',
     'po_uq',
        'po_uq_date',
    ];

    // Define the one-to-many relationship with CbdDetail
    public function details()
    {
        return $this->hasMany(CbdDetail::class, 'order_no', 'order_no');
    }
}
