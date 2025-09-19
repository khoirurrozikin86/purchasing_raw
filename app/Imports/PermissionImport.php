<?php

namespace App\Imports;

use Spatie\Permission\Models\Permission;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PermissionImport implements ToModel, WithValidation,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Permission([
            'name'     => $row['name'],
            'group_name'    => $row['group_name'], 
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => ['required','unique:permissions' ],
            'group_name' => [ 'required'],
           
        ];
    }

    
}

