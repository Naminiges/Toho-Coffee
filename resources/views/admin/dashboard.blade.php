<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - TOHO Coffee</title>
    @vite('resources/css/style.css')
</head>
<body>
    <!-- Header -->
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
                    <a href="#" class="active">
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
                    <a href="#">
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
        <div class="main-content">
            <div class="admin-page-header">
                <div class="page-title">
                    <h2>Dashboard</h2>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="icon blue">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="value">Rp 15.5M</div>
                    <div class="label">Total Pendapatan</div>
                    <div class="trend up">
                        <i class="fas fa-arrow-up"></i>
                        12% dari bulan lalu
                    </div>
                </div>

                <div class="stat-card">
                    <div class="icon green">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <div class="value">1,234</div>
                    <div class="label">Total Pesanan</div>
                    <div class="trend up">
                        <i class="fas fa-arrow-up"></i>
                        8% dari bulan lalu
                    </div>
                </div>

                <div class="stat-card">
                    <div class="icon orange">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="value">856</div>
                    <div class="label">Pelanggan Baru</div>
                    <div class="trend up">
                        <i class="fas fa-arrow-up"></i>
                        5% dari bulan lalu
                    </div>
                </div>

                <div class="stat-card">
                    <div class="icon red">
                        <i class="fas fa-box"></i>
                    </div>
                    <div class="value">45</div>
                    <div class="label">Stok Menipis</div>
                    <div class="trend down">
                        <i class="fas fa-arrow-down"></i>
                        3% dari bulan lalu
                    </div>
                </div>
            </div>

            <!-- Charts Grid -->
            <div class="charts-grid">
                <div class="chart-card">
                    <h3>Grafik Penjualan</h3>
                    <div class="chart-placeholder">
                        Grafik penjualan akan ditampilkan di sini
                    </div>
                </div>

                <div class="chart-card">
                    <h3>Produk Terlaris</h3>
                    <div class="chart-placeholder">
                        Grafik produk terlaris akan ditampilkan di sini
                    </div>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="recent-orders">
                <h3>Pesanan Terbaru</h3>
                <table class="orders-table">
                    <thead>
                        <tr>
                            <th>ID Pesanan</th>
                            <th>Pelanggan</th>
                            <th>Tanggal</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#TOHO-2024-001</td>
                            <td>John Doe</td>
                            <td>20 Mar 2024</td>
                            <td>Rp 85.000</td>
                            <td><span class="status-badge status-ready">Siap Diambil</span></td>
                            <td>
                                <button class="btn btn-secondary">Detail</button>
                            </td>
                        </tr>
                        <tr>
                            <td>#TOHO-2024-002</td>
                            <td>Jane Smith</td>
                            <td>20 Mar 2024</td>
                            <td>Rp 120.000</td>
                            <td><span class="status-badge status-processing">Diproses</span></td>
                            <td>
                                <button class="btn btn-secondary">Detail</button>
                            </td>
                        </tr>
                        <tr>
                            <td>#TOHO-2024-003</td>
                            <td>Mike Johnson</td>
                            <td>20 Mar 2024</td>
                            <td>Rp 75.000</td>
                            <td><span class="status-badge status-pending">Menunggu</span></td>
                            <td>
                                <button class="btn btn-secondary">Detail</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @vite('resources/js/script.js')
</body>
</html>