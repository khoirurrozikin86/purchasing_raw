<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Fabric Barcode</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .qr-card {
            border: 1px solid #dddddd;
            padding: 10px;
            margin-bottom: 20px;
            width: 350px;
            display: flex;
            align-items: center;
        }

        .qr-code {
            width: 100px;
            height: auto;
        }

        .qr-details {
            margin-left: 20px;
        }

        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }

        h1 {
            text-align: center;
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
        @foreach ($qrCodes as $key => $qrcode)
            <div class="qr-card">
                <div class="qr-code">
                    {!! $qrcode->qr_code !!}
                </div>
                <div class="qr-details">

                    PO: {{ $qrcode->po }} &emsp; &emsp; &emsp; MO: {{ $qrcode->mo }}<br>

                    FABRIC CODE
                    :{{ strlen($qrcode->item_code) > 15 ? substr($qrcode->item_code, 0, 15) . '...' : $qrcode->item_code }}<br>
                    Batch NO: {{ $qrcode->batch }}<br>
                    Original NO: {{ $qrcode->original_no }}<br>
                    Color NO: {{ $qrcode->color_code }} &emsp; &emsp; &emsp; Roll No: {{ $qrcode->roll }}<br>
                </div>
            </div>
        @endforeach

    </div>

</body>

</html>
