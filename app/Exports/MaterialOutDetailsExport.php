<?php

namespace App\Exports;

use App\Models\MaterialOutDetail;
use App\Models\MaterialOut;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class MaterialOutDetailsExport implements FromCollection, WithHeadings, WithMapping, WithStrictNullComparison
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        return MaterialOut::query()
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->with(['details.item','details.materialInDetail']) // Load related details and item
            ->get()
            ->flatMap(function($materialOut) {
                return $materialOut->details->map(function($detail) use ($materialOut) {
                    return [
                        'material_out_id' => $materialOut->id,
                        'material_out_no' => $materialOut->material_out_no,
                        'allocation' => $materialOut->allocation,
                        'person' => $materialOut->person,
                        'remark' => $materialOut->remark,
                        'detail_id' => $detail->id,
                        'original_no' => $detail->original_no,
      
                        'item_code' => $detail->item_code,
                        'po' => $detail->materialInDetail->po,
                        'color_code' => $detail->color_code,
                        'color_name' => $detail->color_name,
                        'size' => $detail->size,
                    
                        'qty' => $detail->qty,
              
                        'mo' => $detail->mo,
             
                        'created_at' => $materialOut->created_at,
                        'updated_at' => $materialOut->updated_at,
                    ];
                });
            });
    }

    public function headings(): array
    {
        return [
            'Material OUT ID',
            'Material out No',
            'Allocation',
            'Person',
            'Remark',
            'Detail ID',
            'Original No',
            'Item Code',
            'PO',
            'Color Code',
            'Color Name',
            'Size',
    
        
          
            'Qty',
        
            'MO',
    
            'Created At',
            'Updated At',
        ];
    }

    public function map($row): array
    {
        return [
            $row['material_out_id'],
            $row['material_out_no'],
            $row['allocation'],
            $row['person'],
            $row['remark'],
            $row['detail_id'],
            $row['original_no'],
            $row['item_code'],
            $row['po'],
            $row['color_code'],
            $row['color_name'],
            $row['size'],
 
  
            $row['qty'],
  
            $row['mo'],
  
 
            $row['created_at'],
            $row['updated_at'],
        ];
    }
}
