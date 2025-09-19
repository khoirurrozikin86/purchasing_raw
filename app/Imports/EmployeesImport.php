<?php
namespace App\Imports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Validation\Rule;

class EmployeesImport implements ToModel, WithValidation,WithHeadingRow
{
    public function model(array $row)
    {
        return new Employee([
            'nik' => $row['nik'],
            'name' => $row['name'],
            'department' => $row['department'],
            'posisi' => $row['posisi']
        ]);
    }

    
    public function rules(): array
    {
        return [
            'nik' => ['required','unique:employees' ],
            'name' => [ 'required'],
            'department' => [ 'required'],
            'posisi' => [ 'required'],
           
        ];
    }
}
