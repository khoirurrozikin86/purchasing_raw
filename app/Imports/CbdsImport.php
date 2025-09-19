<?php

namespace App\Imports;

use App\Models\Cbd;
use App\Models\CbdDetail;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;

class CbdsImport implements ToCollection, WithStartRow, WithMapping, WithValidation, SkipsOnFailure
{
    use SkipsFailures;

    /**
     * @return int
     */
    public function startRow(): int
    {
        return 3; // Mulai dari baris ke-3
    }

    /**
     * @param array $row
     *
     * @return array
     */
    public function map($row): array
    {
        return [
            'order_no' => $row[0], // Column 1
            'revision_no' => $row[1] ?? null, // Column 2 (optional)
            'year' => $row[2] ?? null, // Column 3 (optional)
            'planning_ssn' => $row[3] ?? null, // Column 4 (optional)
            'global_business_unit' => $row[4] ?? null, // Column 5 (optional)
            'business_unit' => $row[5] ?? null, // Column 6 (optional)
            'item_brand' => $row[6] ?? null, // Column 7 (optional)
            'department' => $row[7] ?? null, // Column 8 (optional)
            'revised_date' => $row[8] ?? null, // Column 9 (optional)
            'document_status' => $row[9] ?? null, // Column 10 (optional)
            'answered_status' => $row[10] ?? null, // Column 11 (optional)
            'vendor_person_in_change' => $row[11] ?? null, // Column 12 (optional)
            'decision_date' => $row[12] ?? null, // Column 13 (optional)
            'payment_terms' => $row[13] ?? null, // Column 14 (optional)
            'contracted_etd' => $row[14] ?? null, // Column 15 (optional)
            'eta_wh' => $row[15] ?? null, // Column 16 (optional)
            'approver' => $row[16] ?? null, // Column 17 (optional)
            'approval_date' => $row[17] ?? null, // Column 18 (optional)
            'order_condition' => $row[18] ?? null, // Column 19 (optional)
            'remark' => $row[19] ?? null, // Column 20 (optional)
            'raw_material_code' => $row[20] ?? null, // Column 21 (optional)
            'supplier_raw_material_code' => $row[21], // Column 22
            'supplier_raw_material' => $row[22], // Column 22
            'vendor_code' => $row[23] ?? null, // Column 23 (optional)
            'vendor' => $row[24] ?? null, // Column 24 (optional)
            'management_factory_code' => $row[25] ?? null, // Column 25 (optional)
            'management_factory' => $row[26] ?? null, // Column 26 (optional)
            'branch_factory_code' => $row[27] ?? null, // Column 27 (optional)
            'branch_factory' => $row[28] ?? null, // Column 28 (optional)
            'order_plan_number' => $row[29] ?? null, // Column 29 (optional)
            'item_code' => $row[30] ?? null, // Column 30 (optional)
            'item' => $row[31], // Column 31
            'representative_sample_code' => $row[32], // Column 33
            'sample_code' => $row[33], // Column 34
            'contracted_etd2' => $row[34] ?? null, // Column 35 (optional)
            'eta_wh2' => $row[35] ?? null, // Column 36 (optional)
            'color_code' => $row[36], // Column 37
            'color' => $row[37], // Column 38
            'pattern_dimension_code' => $row[38] ?? null, // Column 39 (optional)
            'size_code' => $row[39], // Column 40
            'size' => $row[40], // Column 41
            'qty' => $row[41], // Column 42
            'arrangment_by' => $row[42], // Column 42
            'trim_description' => $row[43], // Column 42
            'trim_item_no' => $row[44], // Column 42
            'trim_supplier' => $row[45], // Column 42
        ];
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $cbd = Cbd::updateOrCreate(
                ['order_no' => $row['order_no']],
                [
                    'revision_no' => $row['revision_no'],
                    'year' => $row['year'],
                    'planning_ssn' => $row['planning_ssn'],
                    'global_business_unit' => $row['global_business_unit'],
                    'business_unit' => $row['business_unit'],
                    'item_brand' => $row['item_brand'],
                    'department' => $row['department'],
                    'revised_date' => $row['revised_date'],
                    'document_status' => $row['document_status'],
                    'answered_status' => $row['answered_status'],
                    'vendor_person_in_change' => $row['vendor_person_in_change'],
                    'decision_date' => $row['decision_date'],
                    'payment_terms' => $row['payment_terms'],
                    'contracted_etd' => $row['contracted_etd'],
                    'eta_wh' => $row['eta_wh'],
                    'approver' => $row['approver'],
                    'approval_date' => $row['approval_date'],
                    'order_condition' => $row['order_condition'],
                    'remark' => $row['remark'],
                    'raw_material_code' => $row['raw_material_code'],
                    'supplier_raw_material_code' => $row['supplier_raw_material_code'],
                    'supplier_raw_material' => $row['supplier_raw_material'],
                    'vendor_code' => $row['vendor_code'],
                    'vendor' => $row['vendor'],
                    'management_factory_code' => $row['management_factory_code'],
                    'management_factory' => $row['management_factory'],
                    'branch_factory_code' => $row['branch_factory_code'],
                    'branch_factory' => $row['branch_factory'],
                    'order_plan_number' => $row['order_plan_number'],
                    'item_code' => $row['item_code'],
                    'item' => $row['item'],
                    'representative_sample_code' => $row['representative_sample_code'],
                    'sample_code' => $row['sample_code'],
                    'contracted_etd2' => $row['contracted_etd2'],
                    'eta_wh2' => $row['eta_wh2'],
                ]
            );

            CbdDetail::updateOrCreate(
                [
                    'order_no' => $row['order_no'],
                    'color_code' => $row['color_code'],
                    'color' => $row['color'],
                    'pattern_dimension_code' => $row['pattern_dimension_code'],
                    'size_code' => $row['size_code'],
                    'size' => $row['size'],
                    'qty' => $row['qty'],
                    'arrangment_by' => $row['arrangment_by'],
                    'trim_description' => $row['trim_description'],
                    'trim_item_no' => $row['trim_item_no'],
                    'trim_supplier' => $row['trim_supplier']
                ]
            );
        }
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            '*.order_no' => 'required|string|unique:cbds,order_no',
            '*.supplier_raw_material_code' => 'required|string',
            '*.item' => 'required|string',
            '*.sample_code' => 'required|string',
            '*.color_code' => 'required|string',
            '*.color' => 'required|string',
            '*.size_code' => 'required|string',
            '*.size' => 'required|string',
            '*.qty' => 'required|integer',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'order_no.required' => 'Order number is required.',
            'order_no.unique' => 'Order number must be unique.',
            'supplier_raw_material_code.required' => 'Supplier raw material code is required.',
            'item.required' => 'Item is required.',
            'sample_code.required' => 'Sample code is required.',
            'color_code.required' => 'Color code is required.',
            'color.required' => 'Color is required.',
            'size_code.required' => 'Size code is required.',
            'size.required' => 'Size is required.',
            'qty.required' => 'Quantity is required.',
            'qty.integer' => 'Quantity must be an integer.',
        ];
    }

    public function onFailure(Failure ...$failures)
    {
        foreach ($failures as $failure) {
            \Log::error('Validation failure', [
                'row' => $failure->row(),
                'attribute' => $failure->attribute(),
                'errors' => $failure->errors(),
                'values' => $failure->values(),
            ]);
            $this->failures[] = $failure;
        }
    }

    public function getFailures()
    {
        return $this->failures;
    }

}
