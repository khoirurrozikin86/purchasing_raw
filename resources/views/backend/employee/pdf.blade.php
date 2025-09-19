<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Employee Barcode</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .employee-card {
            border: 1px solid #dddddd;
            padding: 1px;
            margin-bottom: 20px;
            width: 200px;
            /* Lebar kartu */
            float: left;
            /* Menampilkan kartu secara berdampingan */
            margin-right: 20px;
            /* Jarak antara kartu */
        }

        .qr-code {
            display: block;
            margin: 0 auto;
            /* Membuat QR code menjadi rata tengah */
            width: 100px;
            /* Sesuaikan ukuran QR code di sini */
            height: auto;
        }

        .employee-details {
            margin-bottom: 10px;
            text-align: center;
            /* Membuat detail karyawan menjadi rata tengah */
        }

        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }

        h1 {
            text-align: center;
            /* Membuat judul menjadi rata tengah */
        }

        .qr-container {
            text-align: center;
            margin-top: 20px;
        }

        @media print {
            .page-break {
                page-break-before: always;
            }
        }
    </style>
</head>

<body>

    <div>
        {{-- <h1>Employee Report</h1> --}}
        @foreach ($employees as $key => $employee)
            <div class="employee-card">
                <div class="qr-code">
                    {!! $employee->qr_code !!}
                </div>
                <div class="employee-details">

                    {{ $employee->nik }}<br>
                    {{ strlen($employee->name) > 15 ? substr($employee->name, 0, 15) . '...' : $employee->name }}<br>
                </div>
            </div>
        @endforeach

    </div>

</body>

</html>
