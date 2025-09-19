<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>rak Barcode</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 50px;
        }

        .rak-card {
            text-align: center;
            border: 1px solid #dddddd;
   
            width: 300px;
            /* Lebar kartu */
            float: left;
            /* text-align: center; */
           
        }

        .qr-code {
            display: block;
            margin:  auto;
            /* Membuat QR code menjadi rata tengah */
            width: 100px;
            /* Sesuaikan ukuran QR code di sini */
            height: auto;
            
        }

        .rak-details {
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
        {{-- <h1>rak Report</h1> --}}
        @foreach ($raks as $key => $rak)
            <div class="rak-card">
               
                <div class="rak-details">

                  
                    {!! $rak->qr_code !!}
                  

                    {{ $rak->rak_code }}<br>
                    {{-- {{ strlen($rak->rak_name) > 15 ? substr($rak->rak_name, 0, 15) . '...' : $rak->rak_name }}<br> --}}
                </div>
            </div>
        @endforeach

    </div>








</body>

</html>
