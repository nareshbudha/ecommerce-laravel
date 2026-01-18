<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Order #{{ $order->id }} Confirmation</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
        }

        h2,
        h3 {
            text-align: center;
            color: #111;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        th {
            background: #f4f4f4;
        }

        .totals th {
            text-align: right;
        }

        .text-right {
            text-align: right;
        }

        .summary {
            margin-top: 20px;
        }
    </style>
</head>

<body>

    <h2>Order Confirmation</h2>


    <p><strong>Date:</strong> {{ $order->created_at->format('d M, Y') }}</p>
    <p><strong>Customer Name:</strong>{{ $order->name }}</p>
    <p><strong>Number:</strong>{{ $order->mobile_num}}</p>
    <p><strong>Payment Method:</strong>
        @if($order->transaction->mode === 'wallet')
        {{ ucfirst($order->transaction->wallet_mode) }}
        @else
        {{ ucfirst($order->transaction->mode) }}
        @endif
    </p>
    <h3>Shipping Details</h3>
    <table>
        <thead>
            <tr>
                <th>State</th>
                <th>District</th>
                <th>Town/City</th>
                <th>House Number</th>
                <th>Land Mark</th>
            </tr>
        </thead>
        <tbody>

            <tr>
                <td>{{ $order->state }}</td>
                <td>{{ $order->district}}</td>
                <td>{{ $order->town_city}}</td>
                <td>{{ $order->house_no_building}}</td>
                <td>{{ $order->landmark}}</td>

            </tr>

        </tbody>
    </table>


    <h3>Order Details</h3>
    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Qty</th>
                <th>Unit Price (Rs)</th>
                <th>Subtotal (Rs)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->orderItems as $item)
            <tr>
                <td>{{ $item->product->name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->price, 2) }}</td>
                <td>{{ number_format($item->price * $item->quantity, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <table class="summary">
        <tr>
            <th style="width:80%">Subtotal:</th>
            <td class="text-right">Rs {{ number_format($order->subtotal, 2) }}</td>
        </tr>
        <tr>
            <th>Discount:</th>
            <td class="text-right">Rs {{ number_format($order->discount, 2) }}</td>
        </tr>
        <tr>
            <th>VAT:</th>
            <td class="text-right">Rs {{ number_format($order->tax, 2) }}</td>
        </tr>
        <tr>
            <th>Total:</th>
            <td class="text-right"><strong>Rs {{ number_format($order->total, 2) }}</strong></td>
        </tr>
    </table>

    <p style="text-align:center; margin-top:30px;">Thank you for your purchase!</p>

</body>

</html>
