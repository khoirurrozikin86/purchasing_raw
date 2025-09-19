<?php

namespace App\Imports;

use App\Models\SerahTerima;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Validation\Rule;

class SerahTerimaImport implements ToModel, WithValidation,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
            public function model(array $row)
            {

                // Menghitung nomor transaksi berikutnya
                $lastTransactionOut = SerahTerima::whereNotNull('no_trx')
                ->orderBy('created_at', 'desc')
                ->first();

            if ($lastTransactionOut) {
                $lastNoTrxOut = $lastTransactionOut->no_trx;
                $lastNoTrxOutNum = intval(substr($lastNoTrxOut, 8));
                $nextNoTrxOutNum = $lastNoTrxOutNum + 1;
            } else {
                $nextNoTrxOutNum = 1;
            }

            // Format nomor transaksi
            $noTrxOut = 'TRX-ST' . sprintf('%06d', $nextNoTrxOutNum);


        return new SerahTerima([
            'no_trx' => $noTrxOut,
            'nik' => $row['nik'],
            'name' => $row['name'],
            'department' => $row['department'],
            'item_code' => $row['item_code'],
            'item_name' => $row['item_name'],
            'remark' => $row['remark']
        ]);
    }

    public function rules(): array
    {
        return [
            'nik' => ['required'],
            'name' => ['required'],
            'department' => ['required'],
            'item_code' => ['required'],
            'item_name' => ['required'],
            'remark' => ['required'],
           
        ];
    }
}
