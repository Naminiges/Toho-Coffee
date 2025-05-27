<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice</title>
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
    </style>
</head>
<body>
    <div class="invoice-box">
        <div style="display: flex; justify-content: space-between;">
            <div class="company-logo" style="display: flex; align-items: center;">
                <div style="
                    background: #f4f4f4;
                    padding: 10px;
                    border-radius: 12px;
                    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
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
                <p>Invoice #: 57999<br>
                Date: 22/May/2025<br>
                Total Due: <strong>Rp.112.000</strong></p>
            </div>
        </div>

        <div class="section">
            <strong>Bill To:</strong><br>
            Raswan Haqqi<br>
            0822-1234-4422
        </div>

        <div class="section">
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Hazelnut</td>
                        <td>Rp.45.000</td>
                        <td>2</td>
                        <td>Rp.45.000</td>
                    </tr>
                    <tr>
                        <td>Sanger</td>
                        <td>Rp.15.000</td>
                        <td>1</td>
                        <td>Rp.15.000</td>
                    </tr>
                    <tr>
                        <td>Caramel</td>
                        <td>Rp.35.000</td>
                        <td>4</td>
                        <td>Rp.35.000</td>
                    </tr>
                    <tr>
                        <td>Americano</td>
                        <td>Rp.30.000</td>
                        <td>1</td>
                        <td>Rp.30.000</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="section text-right">
            <p>Sub Total: Rp.125.000</p>
            <p>Tax (10%): Rp.12.000</p>
            <h3>Grand Total: Rp.137.000</h3>
        </div>

        <div class="section">
            <strong>Payment Method</strong><br>
            Payment via Credit/Debit Card<br>
            Account No: 1234 5678 9012 3456
        </div>

        <div class="signature">
            <p>TOHO Coffee</p>
        </div>

        <div class="footer">
            <strong>@2025 TOHO Coffee</strong><br>
        </div>
    </div>
</body>
</html>
