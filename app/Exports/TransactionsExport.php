<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping; // Import WithMapping

class TransactionsExport implements FromQuery, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */

    use Exportable;

    public function query()
    {
        // You can add any custom query here, perhaps with eager loading if necessary
        return Transaction::query()->with('employee');
    }


    public function headings(): array
    {
        // Adjust the headings to match the attributes of the Transaction model
        return [
            'ID',
            'Transaction Number',
            'NIK',
            'Employee Name',  
            'Department',  
            'Type1',
            'Date IN',
            'Type2',
            'Date Out',
            'Remark',
         
        ];
    }

    public function map($transaction): array
    {

        $updatedAt = ($transaction->updated_at->equalTo($transaction->created_at)) ? '' : $transaction->updated_at;

        return [
            $transaction->id,
            $transaction->no_trx,
            $transaction->employee->nik,
            $transaction->employee->name,  // Assuming the employee's name field is 'name'
            $transaction->employee->department,
            $transaction->type1,
            $transaction->created_at,
            $transaction->type2,
            $updatedAt,
            $transaction->remark,
           
        ];
    }



    // public function collection()
    // {
    //     return Transaction::all();
    // }
}
