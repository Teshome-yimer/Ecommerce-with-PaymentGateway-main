<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $order->id }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
        }

        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            border-bottom: 2px solid #3b82f6;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .header-content {
            display: table;
            width: 100%;
        }

        .company-info {
            display: table-cell;
            vertical-align: top;
            width: 50%;
        }

        .invoice-info {
            display: table-cell;
            vertical-align: top;
            width: 50%;
            text-align: right;
        }

        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #3b82f6;
            margin-bottom: 5px;
        }

        .invoice-title {
            font-size: 20px;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 10px;
        }

        .invoice-details {
            background: #f8fafc;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }

        .details-row {
            display: table;
            width: 100%;
            margin-bottom: 10px;
        }

        .details-row:last-child {
            margin-bottom: 0;
        }

        .details-label {
            display: table-cell;
            width: 30%;
            font-weight: bold;
        }

        .details-value {
            display: table-cell;
            width: 70%;
        }

        .billing-shipping {
            display: table;
            width: 100%;
            margin: 30px 0;
        }

        .billing-info, .shipping-info {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            padding-right: 20px;
        }

        .info-title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #1f2937;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 30px 0;
        }

        .items-table th {
            background: #3b82f6;
            color: white;
            padding: 12px 8px;
            text-align: left;
            font-weight: bold;
        }

        .items-table td {
            padding: 10px 8px;
            border-bottom: 1px solid #e5e7eb;
        }

        .items-table tr:nth-child(even) {
            background: #f9fafb;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .totals {
            margin-top: 20px;
            float: right;
            width: 300px;
        }

        .totals table {
            width: 100%;
            border-collapse: collapse;
        }

        .totals td {
            padding: 8px 12px;
            border-bottom: 1px solid #e5e7eb;
        }

        .totals .total-row {
            background: #3b82f6;
            color: white;
            font-weight: bold;
            font-size: 14px;
        }

        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            color: #6b7280;
            font-size: 11px;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-new { background: #dbeafe; color: #1e40af; }
        .status-processing { background: #fef3c7; color: #92400e; }
        .status-shipped { background: #d1fae5; color: #065f46; }
        .status-delivered { background: #dcfce7; color: #166534; }
        .status-canceled { background: #fee2e2; color: #991b1b; }

        .payment-paid { background: #dcfce7; color: #166534; }
        .payment-pending { background: #fef3c7; color: #92400e; }
        .payment-failed { background: #fee2e2; color: #991b1b; }
    </style>
</head>
<body>
    <div class="invoice-container">
        <!-- Header -->
        <div class="header">
            <div class="header-content">
                <div class="company-info">
                    <div class="company-name">የኛ ገበያ</div>
                    <div>Wollo, Ethiopia</div>
                    <div>Phone: +251 962868748</div>
                    <div>Email: tesheyimer86@universityshop.com</div>
                </div>
                <div class="invoice-info">
                    <div class="invoice-title">INVOICE</div>
                    <div><strong>Invoice #:</strong> {{ $order->id }}</div>
                    <div><strong>Date:</strong> {{ $order->created_at->format('d M Y') }}</div>
                    <div><strong>Due Date:</strong> {{ $order->created_at->addDays(30)->format('d M Y') }}</div>
                </div>
            </div>
        </div>

        <!-- Invoice Details -->
        <div class="invoice-details">
            <div class="details-row">
                <div class="details-label">Order Status:</div>
                <div class="details-value">
                    <span class="status-badge status-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
                </div>
            </div>
            <div class="details-row">
                <div class="details-label">Payment Status:</div>
                <div class="details-value">
                    <span class="status-badge payment-{{ $order->payment_status }}">{{ ucfirst($order->payment_status) }}</span>
                </div>
            </div>
            <div class="details-row">
                <div class="details-label">Payment Method:</div>
                <div class="details-value">{{ $order->payment_method ?? 'Not specified' }}</div>
            </div>
        </div>

        <!-- Billing & Shipping -->
        <div class="billing-shipping">
            <div class="billing-info">
                <div class="info-title">Bill To:</div>
                <div><strong>{{ $order->user->name }}</strong></div>
                <div>{{ $order->user->email }}</div>
            </div>
            <div class="shipping-info">
                <div class="info-title">Ship To:</div>
                @if($order->address)
                    <div><strong>{{ $order->address->first_name }} {{ $order->address->last_name }}</strong></div>
                    <div>{{ $order->address->street_address }}</div>
                    <div>{{ $order->address->city }}, {{ $order->address->state }} {{ $order->address->zip_code }}</div>
                    <div>{{ $order->address->country }}</div>
                    <div>Phone: {{ $order->address->phone }}</div>
                @else
                    <div>No shipping address provided</div>
                @endif
            </div>
        </div>

        <!-- Items Table -->
        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 50%">Product</th>
                    <th style="width: 15%" class="text-center">Qty</th>
                    <th style="width: 20%" class="text-right">Unit Price</th>
                    <th style="width: 15%" class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>
                        <strong>{{ $item->product->name }}</strong>
                        @if($item->product->category)
                            <br><small>Category: {{ $item->product->category->name }}</small>
                        @endif
                        @if($item->product->brand)
                            <br><small>Brand: {{ $item->product->brand->name }}</small>
                        @endif
                    </td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-right">Birr {{ number_format($item->unit_amount, 2, '.', ',') }}</td>
                    <td class="text-right">Birr {{ number_format($item->total_amount, 2, '.', ',') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Totals -->
        <div class="totals">
            <table>
                <tr>
                    <td>Subtotal:</td>
                    <td class="text-right">Birr {{ number_format($order->items->sum('total_amount'), 2, '.', ',') }}</td>
                </tr>
                @if($order->shipping_amount)
                <tr>
                    <td>Shipping:</td>
                    <td class="text-right">Birr {{ number_format($order->shipping_amount, 2, '.', ',') }}</td>
                </tr>
                @endif
                <tr class="total-row">
                    <td><strong>Total:</strong></td>
                    <td class="text-right"><strong>Birr {{ number_format($order->grand_total, 2, '.', ',') }}</strong></td>
                </tr>
            </table>
        </div>

        <div style="clear: both;"></div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>Thank you for your business!</strong></p>
            <p>This is a computer-generated invoice. No signature required.</p>
            <p>For any questions regarding this invoice, please contact us at tesheyimer86@universityshop.com</p>
            <p>UniversityShop - Your trusted online shopping destination</p>
        </div>
    </div>
</body>
</html>
