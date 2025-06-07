<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan - TOHO Coffee</title>
    <style>
        /* Print-specific styles */
        @media print {
            @page {
                size: portrait;
                margin: 2cm;
            }
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 20px;
            }
            .print-header {
                text-align: center;
                margin-bottom: 30px;
                padding-bottom: 20px;
                border-bottom: 2px solid #333;
            }
            .print-header img {
                max-width: 80px;
                height: auto;
                margin-bottom: 10px;
            }
            .print-header h1 {
                margin: 10px 0;
                color: #333;
                font-size: 24px;
            }
            .print-header h2 {
                margin: 5px 0;
                color: #666;
                font-size: 18px;
            }
            .print-date {
                text-align: center;
                margin-bottom: 30px;
                color: #666;
                font-size: 14px;
            }
            .summary-cards {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 15px;
                margin-bottom: 30px;
            }
            .summary-card {
                border: 1px solid #ddd;
                padding: 15px;
                border-radius: 8px;
                text-align: center;
                background-color: #f9f9f9;
            }
            .summary-card h3 {
                margin: 5px 0;
                color: #333;
                font-size: 14px;
            }
            .summary-card h3:last-child {
                font-size: 18px;
                color: #2c3e50;
                font-weight: bold;
            }
            .product-table-container {
                margin-top: 30px;
            }
            .product-table-container h3 {
                color: #333;
                margin-bottom: 15px;
                font-size: 16px;
            }
            .product-table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 10px;
            }
            .product-table th,
            .product-table td {
                border: 1px solid #ddd;
                padding: 10px;
                text-align: left;
                font-size: 12px;
            }
            .product-table th {
                background-color: #f5f5f5;
                font-weight: bold;
            }
            .product-table tr:nth-child(even) {
                background-color: #f9f9f9;
            }
            .print-footer {
                margin-top: 40px;
                text-align: center;
                color: #666;
                font-size: 12px;
                padding-top: 20px;
                border-top: 1px solid #ddd;
            }
        }

        /* Web view styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .print-container {
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 8px;
        }
        .print-header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #333;
        }
        .print-header img {
            max-width: 80px;
            height: auto;
            margin-bottom: 10px;
        }
        .print-header h1 {
            margin: 10px 0;
            color: #333;
            font-size: 24px;
        }
        .print-header h2 {
            margin: 5px 0;
            color: #666;
            font-size: 18px;
        }
        .print-date {
            text-align: center;
            margin-bottom: 30px;
            color: #666;
            font-size: 14px;
        }
        .summary-cards {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 30px;
        }
        .summary-card {
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            background-color: #f9f9f9;
        }
        .summary-card h3 {
            margin: 5px 0;
            color: #333;
            font-size: 14px;
        }
        .summary-card h3:last-child {
            font-size: 18px;
            color: #2c3e50;
            font-weight: bold;
        }
        .product-table-container {
            margin-top: 30px;
        }
        .product-table-container h3 {
            color: #333;
            margin-bottom: 15px;
            font-size: 16px;
        }
        .product-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .product-table th,
        .product-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
            font-size: 12px;
        }
        .product-table th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        .product-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .print-footer {
            margin-top: 40px;
            text-align: center;
            color: #666;
            font-size: 12px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
        }
        .print-actions {
            text-align: center;
            margin-top: 20px;
        }
        .print-actions button {
            padding: 10px 20px;
            background-color: #2c3e50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }
        .print-actions button:hover {
            background-color: #34495e;
        }
    </style>
</head>
<body>
    <div class="print-container">
        <div class="print-header">
            <img src="{{ asset('images/logo-toho.jpg') }}" alt="TOHO Coffee Logo">
            <h1>TOHO Coffee</h1>
            <h2>Laporan Penjualan</h2>
        </div>

        <div class="print-date">
            <p>Periode: {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</p>
        </div>

        <div class="summary-cards">
            <div class="summary-card">
                <h3>Total Penjualan</h3>
                <h3>{{ $totalPenjualan }}</h3>
            </div>
            <div class="summary-card">
                <h3>Produk Terjual</h3>
                <h3>{{ $produkTerjual }}</h3>
            </div>
            <div class="summary-card">
                <h3>Total Pendapatan</h3>
                <h3>Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
            </div>
        </div>

        <div class="product-table-container">
            <h3>Produk Terlaris</h3>
            <table class="product-table">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Terjual</th>
                        <th>Pendapatan</th>
                        <th>Persentase</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($produkTerlars as $produk)
                    <tr>
                        <td>{{ $produk['nama_produk'] }}</td>
                        <td>{{ $produk['qty_terjual'] }}</td>
                        <td>Rp {{ number_format($produk['total_pendapatan'], 0, ',', '.') }}</td>
                        <td>{{ $produk['persentase'] }}%</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="print-footer">
            <p>Dicetak pada: {{ \Carbon\Carbon::now()->format('d M Y H:i:s') }}</p>
        </div>

        <div class="print-actions">
            <button onclick="window.print()">Cetak Laporan</button>
        </div>
    </div>

    <script>
        // Auto print when page loads
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>