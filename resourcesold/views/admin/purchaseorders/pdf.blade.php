<!DOCTYPE html>
<html>
<head>
    <title>Purchase Orders</title>
    <style>
.table {
    width: 100%;
    border-collapse: collapse;
    font-size: 12px;
}

.table th,
.table td {
    border: 1px solid #000;
    padding: 5px;
    text-align: center;
}

.table th {
    background: #f0f0f0;
}
        .blue_line {
            height: 20px;
            background: blue;
        }

        .blue_color {
            color: blue;
        }

        .font-bold {
            font-weight: bold;
        }

        .text-right {
            text-align: right;
        }

        .text-left {
            text-align: left;
        }

        .text-center {
            text-align: center;
        }

        .order-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

@php
   $total = 0;
   foreach ($purchaseorders as $order) {
       $total += $order->orderqty * $order->price;
   }
@endphp

<div class="blue_line"></div>
<h1 style="text-align: right; line-height:6px" class="blue_color">PURCHASE ORDER</h1>
<table class="order-table">
        <tr>
            <td class="font-bold text-left">{{$orderDetails->created_by}}</td>
            <td class="blue_color text-right font-bold">PO #</td>
        </tr>
        <tr>
            <td class="font-bold text-left"></td>
            <td class="text-right">{{ $orderDetails->order_number }}</td>
        </tr>
        <tr>
            <td class="text-left" rowspan="2">{!! wordwrap($address->billing_address, 20, '<br>') !!}</td>
            <td class="text-right"> <span class="blue_color font-bold">DATE</span> <br> {{ $orderDetails->order_date }}</td>
        </tr>
        <tr>
            <td class="text-right"> <span class="blue_color font-bold">TOTAL PO VALUE ($)
            </span> 
            <br> {{ $order->currency ?? '' }} {{ number_format($total, 2) }}</td>
        </tr>
    </table>


    <table class="order-table">
        <tr>
            <td class="font-bold blue_color text-left">VENDOR</td>
            <td class="blue_color text-right font-bold">SHIP TO</td>
        </tr>
        <tr>
            <td class=" text-left">
                {{$vendorAddress->v_name ?? ''}}<br>
                {{$vendorAddress->address ?? ''}}
            </td>
            <td class="text-right">
            {{$address->shipping_address ?? ''}}
            </td>
        </tr>
    </table>

    <table class="table">
        <thead>
            <tr>
                <th>NO</th>
                <th>DESCRIPTION</th>
                <th>SKU NO</th>
                <th>QTY (EA)</th>
                <th>UNIT PRICE</th>
                <th>TOTAL AMOUNT</th>
            </tr>
        </thead>
        <tbody>
            @foreach($purchaseorders as $order)
            @php $lineTotal = $order->orderqty * $order->price; @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $order->part_description }}</td>
                    <td>{{ $order->partcode }}</td>
                    <td>{{ $order->orderqty }}</td>
                    <td>{{ $order->price }}</td>
                    <td>{{ $order->currency}} {{ number_format($lineTotal, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table class="order-table" style="margin-top: 15px;">
        <tr>
            <td class="font-bold  text-left">TERMS & CONDITIONS
                <ol>
                    <li>Payment Terms: 45 days upon delivery of Goods
                </ol>
            </td>
            <td class=" text-right font-bold">GRAND TOTAL: {{ $order->currency ?? '' }} {{ number_format($total, 2) }}

            <br>
            <div>JAMES LOW JIN YOUNG</div>
            <div style="width: 100px; height: 100px; baclkground: #000;"></div>
            </div>
            <div>CHIEF EXECUTIVE OFFICER</div>
            <div>{{$orderDetails->created_by}}</div>

            </td>
        </tr>
    </table>

</body>
</html>
