<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice - TOHO Coffee</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 40px;
            color: #333;
            background-color: #f9f9f9;
        }

        .invoice-box {
            max-width: 800px;
            margin: auto;
            border: 1px solid #ddd;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }
        
        .toho-font {
            font-family: 'Barbra', sans-serif;
            font-size: 28px;
            letter-spacing: 1px;
            color: #4a4a4a;
        }

        .company-logo {
            font-size: 20px;
            font-weight: bold;
        }

        .invoice-header {
            text-align: right;
        }

        .section {
            margin-top: 30px;
        }

        table {
            width: 100%;
            line-height: 1.6;
            text-align: left;
            border-collapse: collapse;
        }

        table th {
            background: #f4f4f4;
            font-weight: bold;
        }

        table, th, td {
            padding: 10px;
            border: 1px solid #ccc;
        }

        .text-right {
            text-align: right;
        }

        .signature {
            margin-top: 60px;
            text-align: right;
        }

        .footer {
            margin-top: 40px;
            font-size: 12px;
            color: #666;
        }

        .print-button {
            margin-bottom: 20px;
            text-align: center;
        }

        .print-button a {
            background: #333;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }

        @media print {
            .print-button {
                display: none;
            }
            body {
                margin: 0;
                background-color: white;
            }
            .invoice-box {
                box-shadow: none;
                border: none;
                margin: 0;
            }
        }
    </style>
</head>
<body>
    <div class="print-button">
        <a onclick="window.print()">Print Invoice</a>
    </div>

    <div class="invoice-box">
        <div style="display: flex; justify-content: space-between;">
            <div class="company-logo" style="display: flex; align-items: center;">
                <div style="
                    background: #f4f4f4;
                    padding: 10px;
                    border-radius: 12px;
                    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
                    margin-right: 15px;
                ">
                    <img src="{{ asset('images/logo-toho.jpg') }}" alt="Logo" style="height: 60px; display: block;">
                </div>
                <div>
                    <h2 style="margin: 0;">
                        <span class="toho-font">TOHO</span> Coffee
                    </h2>
                    <small style="color: #777;">Authentic Taste</small>
                </div>
            </div>
            <div class="invoice-header">
                <h2>Invoice</h2>
                <p>Invoice Order: {{ $order->orders_code }}<br>
                Date: {{ $invoice_date }}<br>
                Due Date: {{ $due_date }}<br>
                Total Due: <strong>Rp {{ number_format($grand_total, 0, ',', '.') }}</strong></p>
            </div>
        </div>

        <div class="section">
            <strong>Bill To:</strong><br>
            {{ $customer['name'] }}<br>
            {{ $customer['email'] }}<br>
            {{ $customer['phone'] }}<br>
            {{ $customer['address'] }}
        </div>

        <div class="section">
            <strong>Order Information:</strong><br>
            Order Date: {{ $order->order_date->format('d F Y, H:i') }}<br>
            Order Status: {{ ucfirst($order->order_status) }}
        </div>

        <div class="section">
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Category</th>
                        <th>Temperature</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->orderDetails as $detail)
                    <tr>
                        <td>{{ $detail->product_name ?? 'Produk Tidak Tersedia' }}</td>
                        <td>{{ $detail->category_name ?? 'N/A' }}</td>
                        <td>{{ $detail->temperature_name ?? 'N/A' }}</td>
                        <td>Rp {{ number_format($detail->product_price, 0, ',', '.') }}</td>
                        <td>{{ $detail->product_quantity }}</td>
                        <td>Rp {{ number_format($detail->product_price * $detail->product_quantity, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="section text-right">
            <p>Sub Total: Rp {{ number_format($subtotal, 0, ',', '.') }}</p>
            <p>Tax ({{ $tax_rate * 100 }}%): Rp {{ number_format($tax_amount, 0, ',', '.') }}</p>
            <h3>Grand Total: Rp {{ number_format($grand_total, 0, ',', '.') }}</h3>
        </div>

        <div class="section">
            <strong>Payment Information:</strong><br>
            Payment Method: {{ $payment['method'] }}<br>
            @if($payment['bank_number'] && $payment['bank_number'] !== 'Tidak tersedia')
            Account No: {{ $payment['bank_number'] }}<br>
            @endif
            @if($payment['bank_name'] && $payment['bank_name'] !== 'Transfer Bank')
            Bank: {{ $payment['bank_name'] }}<br>
            @endif
            Payment Status: {{ ucfirst($payment['payment_status']) }}
        </div>

        @if($order->member_notes)
        <div class="section">
            <strong>Order Notes:</strong><br>
            {{ $order->member_notes }}
        </div>
        @endif

        <div class="signature">
            <p>TOHO Coffee</p>
            <div style="margin-top: 50px; border-top: 1px solid #333; width: 200px; margin-left: auto;">
                <p style="margin-top: 10px; font-size: 12px;">Authorized Signature</p>
            </div>
        </div>

        <div class="footer">
            <strong>© {{ date('Y') }} TOHO Coffee</strong><br>
            Terima kasih atas kunjungan Anda. Semoga Anda menikmati kopi pilihan kami!
        </div>
    </div>

    <script>
        // Auto print jika ada parameter print di URL
        if (window.location.search.includes('print=true')) {
            window.onload = function() {
                window.print();
            }
        }
    </script>
</body>
</html>