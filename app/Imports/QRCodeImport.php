<?php

namespace App\Imports;

use App\Models\QRCode;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Item;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class QRCodeImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Validate item_code exists in items table
        $validator = Validator::make($row, [
            'item_code' => [
                'required',
                Rule::exists('items', 'item_code')
            ],
             'original_no' => [
                'required',
                Rule::unique('q_r_codes', 'original_no')
            ]
        ]);

        if ($validator->fails()) {
            // Log or handle the validation error
            $this->errors[] = [
                'row' => $row,
                'errors' => $validator->errors()->all(),
            ];
            return null;
        }

        return new QRCode([
            'original_no'    => $row['original_no'], 
            'received_date'  => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['received_date']),
            'supplier_name'  => $row['supplier_name'],
            'item_code'      => $row['item_code'],
            'po'             => $row['po'],
            'color_code'     => $row['color_code'],
            'color_name'     => $row['color_name'],
            'batch'          => $row['batch'],
            'roll'           => $row['roll'],
            'gross_weight'   => $row['g_w_kg'],
            'net_weight'     => $row['n_w_kg'],
            'qty'            => $row['packing_list_m'],
            'basic_width'    => $row['basic_width'],
            'basic_grm'      => $row['basic_g_m2'],
            'mo'             => $row['mo'],
        ]);
    }
}
