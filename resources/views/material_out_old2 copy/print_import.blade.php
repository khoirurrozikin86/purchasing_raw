<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: 'Arial, sans-serif';
            margin: 0;
            padding: 0;
        }

        .header,
        .footer {
            width: 100%;
            position: fixed;
            top: 0;
            /* Letakkan header di bagian atas */
            left: 0;
            z-index: 999;
            /* Pastikan header muncul di atas konten */
        }

        .header {
            margin: 0;
         
            box-sizing: border-box;
            border-bottom: 1px solid #000;
        }

        .footer {
            bottom: 0;
            font-size: 12px;
            margin: 0;
        }

        .content {
            margin-top: 130px;
            /* Atur margin top untuk konten */
            margin-bottom: 1px;
            position: relative;
        }

        .content p {
            margin-bottom: 0px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            border: 1px solid black;
            padding: 5px;
            text-align: left;
            font-size: 9px;
        }

        .table th {
            background-color: #f2f2f2;
        }

        .table-no-border td {
            border: none;
            font-size: 9px;
        }

        .footer-table td {
            font-size: 9px;
        }

        .table-request {
            margin-left: 0;
            width: auto;
        }

        .table-request td {
        }

    

        .header-table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
        }

        .header-table td {
            padding: 5px;
        }

        .header-logo {
            text-align: left;
        }

        .header-logo h1 {
            font-style: italic;
            font-weight: bold;
            font-size: 45px;
            /* Ubah ukuran font disini */
            margin: 0;
        }

        .header-logo img {
            width: 80px;
        }

        .header-info {
            text-align: left;
            width: 45%;
        }

        .header-info h1 {
            font-size: 18px;
            margin: 0;
        }

        .header-info p {
            font-size: 8px;
            margin: 1px 0;
        }

        .header-form-no {
            text-align: left;
            font-size: 8px;
       
            /* Atur padding */
        }

        .header-form-no p {
            border: 1px solid #000;
            /* Tambahkan border pada paragraf */
      
            /* Atur padding */
            margin: 0;
            /* Hapus margin */
        }

        .table-detail-request {
            font-size: 7px;
            /* Atur ukuran font yang diinginkan */
        }

        .table-detail-request th,
        .table-detail-request td {
            font-size: 7px;
            /* Atur ukuran font untuk header dan data */
        }

        /* Lebarkan kolom "ITEMS REQUESTED" */
        .table-detail-request th:nth-child(2),
        .table-detail-request td:nth-child(2) {
            max-width: 250px;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .wide-column {
            width: 250px;
            /* Atur lebar kolom */
            max-width: 250px;
            /* Tetapkan lebar maksimal */
            overflow: hidden;
            text-overflow: ellipsis;
            /* Tampilkan elipsis jika teks terlalu panjang */
        }

        .supplier-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1px;
        }

        .supplier-table td {
            border: none;
            font-size: 9px;
            vertical-align: top;
           
        }

        .supplier-table .left-column {
            width: 50%;
        }

        .supplier-table .right-column {
            width: 30%;
            text-align: right;
        }

        .supplier-table .right-column1 {
            width: 20%;
            text-align: left;
        }

        .supplier-table .nowrap {
            white-space: nowrap;
        }

        .header-info p {
            font-size: 9px;
            margin: 2px 0;
        }

        .supplier-tablex {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1px;
            border: 1px solid #000;
            margin-bottom: 4px;
        }

        .supplier-tablex td {
            border: none;
            font-size: 9px;
            vertical-align: top;
        }

        .supplier-tablex .left-column {
            width: 50%;
        }

        .supplier-tablex .right-column {
            width: 50%;
            text-align: right;
        }

        .supplier-tablex .right-column1 {
            width: 20%;
            text-align: left;
        }

        .supplier-tablex .nowrap {
            white-space: nowrap;
        }

        .supplier-tablexx {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1px;
            margin-bottom: 2px;
        }

        .supplier-tablexx td {
            border: none;
            font-size: 9px;
            vertical-align: top;
        
        }

        .supplier-tablexx .left-column {
            width: 40%;
        }

        .supplier-tablexx .right-column1 {
            width: 20%;
            text-align: right;
        }

        .supplier-tablexx .nowrap {
            white-space: nowrap;
        }



        .supplier-tablexxx {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1px;
            margin-bottom: 5px;
        }

        .supplier-tablexxx td {
            border: none;
            font-size: 9px;
            vertical-align: top;
        }

        .supplier-tablexxx .left-column {
            width: 40%;
           
        }

        .supplier-tablexxx .right-column1 {
            width: 20%;
            text-align: right;
        }


          .supplier-tablexxx {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1px;
            margin-bottom: 50px;
        }

        .supplier-tablexxx td {
            border: none;
            font-size: 9px;
            vertical-align: top;
        }

        .supplier-tablexxx .left-column {
            width: 40%;
           
        }

        .supplier-tablexxx .right-column1 {
            width: 20%;
            text-align: right;
        }








        .supplier-tablexq {
            width: 100%;
            border-collapse: collapse;
         
            margin-bottom: 1px;
            border: 1px solid #000;
        }

        .supplier-tablexq td {
            border: none;
            font-size: 9px;
            vertical-align: top;
        }

        .supplier-tablexq .left-column {
            width: 40%;
           
        }

        .supplier-tablexq .right-column1 {
            width: 20%;
            text-align: right;
        }

    
        

 



    </style>
</head>

<body>
    <div class="header">
        <table class="header-table">
            <tr>
                <td class="header-logo">
                    <h1><em><strong>'TIMW'</strong></em></h1>
                </td>
                <td class="header-info">
                    <h1>PT. TI Matsuoka Winner Industry</h1>
                    <p>Head Office :</p>
                    <p>
                        Summitmas II 3rd Fl. Jl. Jend. Sudirman kav 61-62 Jakarta 12190
                    </p>
                    <p>
                        Tel. (021) 520 1756 - Fax. (021) 520 1294
                    </p>
                    <p>
                        Factory :
                    </p>
                    <p>
                        Jl. Raya Tegalpanas Jimbaran Ds. Secang Rt. 01 Dsn. Samban
                    </p>
                    <p>
                        Kec. Bawen Kab. Semarang Jawa Tengah
                    </p>
                </td>

            </tr>
        </table>

    </div>

    <div class="content">
        <p style="font-weight: bold; text-align: center;">PURCHASE ORDER
            <br>
            NO:{{ $purchaseorder->purchase_order_no }}
        </p>

        <div class="left-column">
            <table class="supplier-table">
                <tr>
                    <td class="left-column nowrap">MESSRS,</td>
                    <td class="right-column">Date:
                        {{ \Carbon\Carbon::parse($purchaseorder->created_at)->format('d-M-Y') }}</td>
                </tr>
                <tr>
                    <td>{{ $purchaseorder->supplier->supplier_name }}</td>
                </tr>
                <tr>

                    <td>
                        @if (strlen($purchaseorder->supplier->supplier_address) > 25)
                            {{ substr($purchaseorder->supplier->supplier_address, 0, 50) }}<br>
                            {{ substr($purchaseorder->supplier->supplier_address, 50) }}
                        @else
                            {{ $purchaseorder->supplier->supplier_address }}
                        @endif
                    </td>
                </tr>

            </table>

            <table class="supplier-table" style="width: auto; margin-left: 0;">
                <tr>
                    <td>Phone</td>
                    <td>: {{ $purchaseorder->supplier->supplier_phone }}</td>
                </tr>
                <tr>
                    <td>Fax</td>
                    <td>: {{ $purchaseorder->supplier->supplier_fax }}</td>
                </tr>
                <tr>
                    <td>Attn</td>
                    <td>: {{ $purchaseorder->supplier->supplier_person }}</td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>: {{ $purchaseorder->supplier->supplier_email }}</td>
                </tr>

            </table>
        </div>
        <div class="right-column">
            <!-- Leave this column blank -->

        </div>

        <table class="supplier-table">
            <tr>
                <td class="left-column">

                    <table>
                        <tr>
                            <td> Date in House</td>
                            <td>: {{ $purchaseorder->date_in_house }}</td>
                        </tr>
                        <tr>
                            <td>Allocation</td>
                            <td>: {{ $purchaseorder->allocation  }}</td>
                        </tr>
                        <tr>
                            <td>Applicant</td>
                            <td>: {{ $purchaseorder->applicant }}</td>
                        </tr>
                    </table>

                </td>
                <td class="right-column1">

                    <table>
                        <tr>
                            <td>Terms</td>
                            <td>: {{ $purchaseorder->terms }}</td>
                        </tr>
                        <tr>
                            <td>Payment</td>
                            <td>: {{ $purchaseorder->payment }}</td>
                        </tr>
                        <tr>
                            <td>Ship Mode</td>
                            <td>: {{ $purchaseorder->ship_mode }}</td>
                        </tr>
                    </table>
                </td>
            </tr>

        </table>

        <table class="supplier-tablex">
            <tr>
                <td class="left-column">
                    <table>
                        <tr>
                            <td>Your Quotation No</td>
                            <td>: {{ $purchaseorder->quotation_no }}</td>
                        </tr>
                        <tr>
                            <td>Delivery Point at</td>
                            <td>: {{ $purchaseorder->delivery_at }}</td>
                        </tr>

                    </table>
                </td>
                <td class="right-column1">

                    <table>
                        <tr>
                            <td>Date</td>
                            <td>: </td>
                        </tr>

                    </table>
                </td>
            </tr>

        </table>

        <table class="table detail-request table-detail-request">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Color</th>
                    <th>Size</th>
                    <th>Unit</th>
                    <th>QTY</th>
                    <th>Remark</th>
                    <th>Price</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($purchaseorder->detailorder as $index => $detail)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $detail->item->item_code }}</td>
                        <td style="max-width: 150px;">{{ $detail->item->item_name }}</td>
                        <td>{{ $detail->color ?? '-' }}</td>
                        <td>{{ $detail->size ?? '-' }}</td>
                        <td>{{ $detail->item->unit->unit_code }}</td>
                        <td>{{ $detail->qty }}</td>
                        <td>{{ $detail->remark }}</td>
                        <td>USD  {{ $detail->price }}</td>
                        <td>USD  {{ $detail->total_price }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <table class="supplier-tablexq">
            <tr>
                <td class="left-column">

                 
                   <p>Note :    {{ $purchaseorder->note1 }}</p>
                </td>
                <td class="right-column1">

                   
                </td>
            </tr>

        </table>

        <table class="supplier-tablexx">
            <tr>
                <td class="left-column">
                    <table>
                        <tr>
                            <p>
                            </p>
                        </tr>

                        <tr>
                            <p>Note:
                                <br>
                                {!! str_replace('-', '<br>-', e($purchaseorder->note2)) !!}
                            </p>
                        </tr>

                        <tr>
                            <p>- Good to be delivered to following address :
                                <br>

                                <strong>
                                    PT. TI MATSUOKA WINNER INDUSTRY
                                </strong>
                                <br>
                                Jl. Raya Tegalpanas Jimbaran
                                <br>
                                Ds. Secang RT. 01 Dsn. Samban
                                <br>
                                Kec. Bawen Kab. Semarang
                                <br>
                                Jawa Tengah
                            </p>
                        </tr>
                        <tr>

                            <p>Rule:
                                <br>
                                {!! str_replace('- ', '<br>-', e($purchaseorder->rule)) !!}
                            </p>
                        </tr>

                    </table>
                </td>
                <td class="right-column1">

                    <table>
                        <tr>
                            <td>Subtotal</td>
                            <td>: USD </td>
                            <td>{{ $purchaseorder->subtotal }}</td>
                        </tr>
                        <tr>
                            <td>Rounding</td>
                            <td>: USD </td>
                            <td>{{ $purchaseorder->rounding }}</td>
                        </tr>
                        <tr>
                            <td>Discount</td>
                            <td>: USD </td>
                            <td>{{ $purchaseorder->discount }}</td>
                        </tr>
                        <tr>
                            <td>VAT</td>
                            <td>: USD </td>
                            <td>{{ $purchaseorder->vat }}%</td>
                        </tr>
                        <tr>
                            <td>VAT Amount</td>
                            <td>: USD </td>
                            <td>{{ $purchaseorder->vat_amount }}</td>
                        </tr>
                        <tr>
                            <td>Grand Total</td>
                            <td>: USD </td>
                            <td>{{ $purchaseorder->grand_total }}</td>
                        </tr>
                        <tr>
                            <td>Purchase Amount</td>
                            <td>: USD </td>
                            <td>{{ $purchaseorder->purchase_amount }}</td>
                        </tr>
                    </table>
                </td>
            </tr>

        </table>

        <table class="supplier-tablexxx">
            <tr>
                <td class="left-column">
                    <table>
                        <tr>
                            <p>Issued by,
                                <br>
                                PT. TI Matsuoka Winner Industry</p>
                        </tr>
                      

                    </table>
                </td>
                <td class="right-column1">

                    <table>
                        <tr>
                            <p>Confirmed by,
                                <br>
                                {{ $purchaseorder->supplier->supplier_name }}
                            </p>
                        </tr>

                    </table>
                </td>
            </tr>

        </table>


        <table class="supplier-tablexxx">
            <tr>
                <td class="left-column">
                    <table>
                        <tr>
                            <p style="text-decoration: underline; text-align: center;">Mr. {{ $purchaseorder->approval }}
                               
                              </p>
                                <p>President Director</p>
                        </tr>
                      

                    </table>
                </td>
                <td class="right-column1">

                    <table>
                        <tr>
                            <p style="text-decoration: underline; text-align: center;"> {{ $purchaseorder->supplier->supplier_person }}
                                <br>
                               
                            </p>
                        </tr>

                    </table>
                </td>
            </tr>

        </table>

        

    </div>
</body>

</html>
