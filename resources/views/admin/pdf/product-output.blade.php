<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Nota de entrega</title>
        <style type="text/css">
            
            @page {
                margin-top: 1cm;
                margin-bottom: 3cm;
                margin-left: 2cm;
                margin-right: 2cm;
            }
            body {
                background: #fff;
                color: #000;
                margin: 0cm;
                font-family: 'Open Sans', sans-serif;
                font-size: 9pt;
                line-height: 100%;
            }
            h1, h2, h3, h4 {
                font-weight: bold;
                margin: 0;
            }
            h1 {
                font-size: 16pt;
                margin: 5mm 0;
            }
            h2 {
                font-size: 14pt;
            }
            h3, h4 {
                font-size: 9pt;
            }
            ol,
            ul {
                list-style: none;
                margin: 0;
                padding: 0;
            }
            li,
            ul {
                margin-bottom: 0.75em;
            }
            p {
                margin: 0;
                padding: 0;
            }
            p + p {
                margin-top: 1.25em;
            }
            a {
                border-bottom: 1px solid;
                text-decoration: none;
            }
            /* Basic Table Styling */
            table {
                border-collapse: collapse;
                border-spacing: 0;
                page-break-inside: always;
                border: 0;
                margin: 0;
                padding: 0;
            }
            th, td {
                vertical-align: top;
                text-align: left;
            }
            table.container {
                width:100%;
                border: 0;
            }
            tr.no-borders,
            td.no-borders {
                border: 0 !important;
                border-top: 0 !important;
                border-bottom: 0 !important;
                padding: 0 !important;
                width: auto;
            }
            /* Header */
            table.head {
                margin-bottom: 12mm;
            }
            td.header img {
                max-height: 3cm;
                width: auto;
            }
            td.header {
                font-size: 16pt;
                font-weight: 700;
            }
            td.shop-info {
                width: 40%;
            }
            .document-type-label {
                text-transform: uppercase;
            }
            table.order-data-addresses {
                width: 100%;
                margin-bottom: 10mm;
            }
            td.order-data {
                width: 40%;
            }
            .invoice .shipping-address {
                width: 30%;
            }
            .packing-slip .billing-address {
                width: 30%;
            }
            td.order-data table th {
                font-weight: normal;
                padding-right: 2mm;
            }
            table.order-details {
                width:100%;
                margin-bottom: 8mm;
            }
            .quantity,
            .price {
                width: 20%;
            }
            .order-details tr {
                page-break-inside: always;
                page-break-after: auto;
            }
            .order-details td,
            .order-details th {
                border-bottom: 1px #ccc solid;
                border-top: 1px #ccc solid;
                padding: 0.375em;
            }
            .order-details th {
                font-weight: bold;
                text-align: left;
            }
            .order-details thead th {
                color: #333131;
                background-color: #efeded;
                border-color: black;
            }
            .order-details tr.bundled-item td.product {
                padding-left: 5mm;
            }
            .order-details tr.product-bundle td,
            .order-details tr.bundled-item td {
                border: 0;
            }
            dl {
                margin: 4px 0;
            }
            dt, dd, dd p {
                display: inline;
                font-size: 7pt;
                line-height: 7pt;
            }
            dd {
                margin-left: 5px;
            }
            dd:after {
                content: "\A";
                white-space: pre;
            }
            .customer-notes {
                margin-top: 5mm;
            }
            table.totals {
                width: 100%;
                margin-top: 5mm;
            }
            table.totals th,
            table.totals td {
                border: 0;
                border-top: 1px solid #ccc;
                border-bottom: 1px solid #ccc;
            }
            table.totals th.description,
            table.totals td.price {
                width: 50%;
            }
            table.totals tr:last-child td,
            table.totals tr:last-child th {
                border-top: 2px solid #000;
                border-bottom: 2px solid #000;
                font-weight: bold;
            }
            table.totals tr.payment_method {
                display: none;
            }
            #footer {
                position: absolute;
                bottom: -2cm;
                left: 0;
                right: 0;
                height: 2cm;
                text-align: center;
                border-top: 0.1mm solid gray;
                margin-bottom: 0;
                padding-top: 2mm;
            }
            .pagenum:before {
                content: counter(page);
            }
            .pagenum,.pagecount {
                font-family: sans-serif;
            }
        </style>
    </head>
    <body class="invoice">
        <table class="head container">
            <tr>
                <!--
                <td class="header">
                -->
                </td>
                <td class="company" style="font-size: 13px; float: left;">
                    {{-- <img src="http://localhost:8000/logo/logole.jpg" alt="Logo" width="150">  --}}
                    <div style="margin-left: 0;">
                        <img src="{{ "data:image/jpg;base64, ".base64_encode(base_path().'/logo/logo.jpg') }}" alt="Logo" width="150">
                    </div>
                    <div style="margin-left: 0;"><strong>Inversiones la 14 C.A.</strong></div>
                    <div style="margin-left: 0;">Teléfono: 02514462772</div>
                    <div style="margin-left: 0;">Dirección: Carrera 14 entre 45 y 46 casa 45-67</div>
                    <div style="margin-left: 0;">Barquisimeto Edo. Lara</div>
                </td>
                <td class="shop-info">
                    <div style="font-size: 20px; margin-bottom: 10px">
                        Nota de entrega: {{ $entity->code }}
                    </div>
                    <div class="shop-name">
                        Cliente: {{ $entity->partner->name }}
                    </div>
                    <div class="shop-name">
                        Documento: {{ $entity->partner->document }}
                    </div>
                    <div class="shop-address">
                        Dirección:
                        {{ $entity->partner->address->address_1 }}<br>
                        {{ $entity->partner->address->address_2 }}
                    </div>
                </td>
            </tr>
        </table>
        <h1 class="document-type-label"></h1>
        <table class="order-data-addresses">
            <tr>
                <td class="address billing-address">
                    {{-- 
                    <h3>Billing Address:</h3>
                    N/A
                     --}}
                </td>
                <td class="address shipping-address">
                    {{-- 
                    <h3>Shipping Address:</h3>
                    N/A
                     --}}
                </td>
                <td class="order-data">
                    <table>
                        <tr class="order-number">
                            <th>Número de orden:</th>
                            <td>{{ $entity->orders()->first()->code }}</td>
                        </tr>
                        <tr class="order-date">
                            <th>Fecha:</th>
                            <td>{{ date("d/m/Y h:i a", strtotime($entity->date)) }}</td>
                        </tr>
                        @if ($entity->payment_method)
                        <tr class="payment-method">
                            <th>Método de pago:</th>
                            <td> {{ $entity->payment_method->name }}</td>
                        </tr>
                        @endif
                    </table>
                </td>
            </tr>
        </table>
        <table class="order-details">
            <thead>
                <tr>
                    <th class="product">Producto</th>
                    <th class="quantity">Cantidad</th>
                    <th class="price" style="text-align: right;">Precio</th>
                    <th class="sub-tota" style="text-align: right;">Sub total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($entity->detail as $detail)
                <tr>
                    <td> {{ $detail->product->name }} </td>
                    <td> {{ $detail->qty }} </td>
                    <td style="text-align: right;"> {{ number_format((float)round($detail->full_price, 2, PHP_ROUND_HALF_DOWN),2,',','.')}} </td>
                    <td style="text-align: right;"> {{ number_format((float)round($detail->total, 2, PHP_ROUND_HALF_DOWN),2,',','.')}} </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="no-borders">
                    <td class="no-borders">
                    </td>
                    <td class="no-borders">
                        <div class="customer-notes">
                        </div>
                    </td>
                    <td class="no-borders" colspan="2">
                        <table class="totals">
                            <tfoot>
                            <tr class="cart_subtotal">
                                <td class="no-borders"></td>
                                <th class="description">Subtotal</th>
                                <td class="price" style="text-align: right;"><span class="totals-price"><span class="amount">{{ number_format((float)round($entity->total_price, 2, PHP_ROUND_HALF_DOWN),2,',','.') }}</span></span></td>
                            </tr>
                            <tr class="cart_subtotal">
                                <td class="no-borders"></td>
                                <th class="description">Impuestos</th>
                                <td class="price" style="text-align: right;"><span class="totals-price"><span class="amount"> {{ number_format((float)round($entity->total_tax, 2, PHP_ROUND_HALF_DOWN),2,',','.') }} </span></span></td>
                            </tr>
                            <tr class="order_total">
                                <td class="no-borders"></td>
                                <th class="description">Total</th>
                                <td class="price" style="text-align: right;"><span class="totals-price"><span class="amount"> {{ number_format((float)round($entity->total, 2, PHP_ROUND_HALF_DOWN),2,',','.') }} </span></span></td>
                            </tr>
                            </tfoot>
                        </table>
                    </td>
                </tr>
            </tfoot>
        </table>
    </body>
</html>