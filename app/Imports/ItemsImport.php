<?php

namespace App\Imports;

use App\Models\Item;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Validation\Rule;
class ItemsImport implements ToModel, WithValidation,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Item([
            'item_code' => $row['item_code'],
            'item_name' => $row['item_name'],
            'description' => $row['description'],
            'category_id' => $row['category_id'],
            'unit_id' => $row['unit_id'],
            'remark' => $row['remark'],
        ]);
    }

    public function rules(): array
    {
        return [
            'item_code' => 'required|unique:items',
            'item_name' => 'required',
            'description' => 'required',
            'category_id' => 'required|exists:categories,id',
            'unit_id' => 'required|exists:units,id',
        ];
    }
}
