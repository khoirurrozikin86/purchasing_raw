<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>item Barcode</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .item-card {
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

        .item-details {
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
        {{-- <h1>item Report</h1> --}}
        @foreach ($items as $key => $item)
            <div class="item-card">
                <div class="qr-code">
                    {!! $item->qr_code !!}
                </div>
                <div class="item-details">

                    {{ $item->code }}<br>
                    {{ strlen($item->name) > 15 ? substr($item->name, 0, 15) . '...' : $item->name }}<br>
                </div>
            </div>
        @endforeach

    </div>








</body>

</html>
