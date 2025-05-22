<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan - Toho Coffee</title>
    @vite('resources/css/style.css')
</head>
<body>
    <header>
        <div class="navbar">
            <div class="logo">
                <img src="/api/placeholder/40/40" alt="TOHO Coffee Logo">
                <h1>TOHO Coffee</h1>
            </div>
            <div class="nav-actions">
                <i class="fas fa-user"></i>
            </div>
        </div>
    </header>

    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <img src="/api/placeholder/80/80" alt="Admin Profile">
                <div class="admin-name">Admin TOHO</div>
                <div class="admin-role">Administrator</div>
            </div>

            <ul class="sidebar-menu">
                <li>
                    <a href="#">
                        <i class="fas fa-chart-line"></i>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fas fa-shopping-bag"></i>
                        Pesanan
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fas fa-box"></i>
                        Produk
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fas fa-users"></i>
                        Pelanggan
                    </a>
                </li>
                <li>
                    <a href="#" class="active">
                        <i class="fas fa-chart-pie"></i>
                        Laporan
                    </a>
                </li>
                <li>
                    <a href="#" class="logout">
                        <i class="fas fa-sign-out-alt"></i>
                        Logout
                    </a>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <main class="main-content">
            <div class="admin-page-header">
                <div class="page-title">
                    <h2>Laporan Penjualan</h2>
                </div>
                <div class="header-actions">
                    <button class="btn btn-primary" onclick="printReport()">
                        <i class="fas fa-print"></i> Cetak Laporan
                    </button>
                </div>
            </div>

            <!-- Date Range Filter -->
            <div class="filter-container report-filter"> {{-- Added report-filter class for specific styling --}}
                <div class="date-input-group"> {{-- Grouping date inputs and text --}}
                    <input type="date" id="startDate" class="form-control">
                    <span>sampai</span>
                    <input type="date" id="endDate" class="form-control">
                </div>
                <button class="btn btn-primary filter-button" onclick="filterReport()"> {{-- Added filter-button class and onclick --}}
                    <i class="fas fa-filter"></i> Filter
                </button>
            </div>

            <!-- Summary Cards -->
            <div class="summary-cards">
                <div class="card summary-card"> {{-- Added summary-card class --}}
                    <div class="card-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="card-info">
                        <h3>Total Penjualan</h3>
                        <p class="card-value">150</p>
                        <p class="card-change positive">+12% dari bulan lalu</p>
                    </div>
                </div>
                <div class="card summary-card"> {{-- Added summary-card class --}}
                    <div class="card-icon">
                        <i class="fas fa-box"></i>
                    </div>
                    <div class="card-info">
                        <h3>Produk Terjual</h3>
                        <p class="card-value">450</p>
                        <p class="card-change positive">+8% dari bulan lalu</p>
                    </div>
                </div>
                <div class="card summary-card"> {{-- Added summary-card class --}}
                    <div class="card-icon">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <div class="card-info">
                        <h3>Total Pendapatan</h3>
                        <p class="card-value">Rp 15.000.000</p>
                        <p class="card-change positive">+15% dari bulan lalu</p>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="charts-container">
                <!-- Sales Trend Chart -->
                <div class="chart-card">
                    <h3>Tren Penjualan</h3>
                    <canvas id="salesTrendChart"></canvas>
                </div>
                
                <!-- Product Performance Chart -->
                <div class="chart-card">
                    <h3>Performa Produk</h3>
                    <canvas id="productPerformanceChart"></canvas>
                </div>
            </div>

            <!-- Top Selling Products Table -->
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
                        <tr>
                            <td>Espresso</td>
                            <td>120</td>
                            <td>Rp 2.400.000</td>
                            <td>25%</td>
                        </tr>
                        <tr>
                            <td>Latte</td>
                            <td>95</td>
                            <td>Rp 2.850.000</td>
                            <td>20%</td>
                        </tr>
                        <tr>
                            <td>Cappuccino</td>
                            <td>85</td>
                            <td>Rp 2.550.000</td>
                            <td>18%</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    @vite('resources/js/script.js')
</body>
</html>