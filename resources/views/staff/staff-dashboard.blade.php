<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Pesanan - Toho Coffee</title>
    @vite('resources/css/style.css')
</head>
<body>
    <!-- Header -->
    <header>
        <div class="navbar"> <!-- Menggunakan class yang sudah ada -->
            <div class="logo"> <!-- Menggunakan class yang sudah ada -->
                <img src="{{ asset('images/logo-toho.jpg') }}" alt="TOHO Coffee Logo">
                <h1>TOHO Coffee</h1>
            </div>
            <div class="nav-actions">
                <i class="fas fa-user"></i>
            </div>
        </div>
    </header>

    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar"> <!-- Menggunakan class yang sudah ada -->
            <div class="sidebar-header"> <!-- Menggunakan class yang sudah ada -->
                <img src="{{ asset('images/logo-toho.jpg') }}" alt="Staff Profile">
                <div class="admin-name">Staff TOHO</div> <!-- Menggunakan class yang sudah ada -->
                <div class="admin-role">Barista</div> <!-- Menggunakan class yang sudah ada -->
            </div>

            <ul class="sidebar-menu"> <!-- Menggunakan class yang sudah ada -->
                <li>
                    <a href="{{ route('staff-dashboard') }}" class="active">
                        <i class="fas fa-chart-line"></i>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('staff-manajemen-produk') }}">
                        <i class="fas fa-box"></i>
                        Produk
                    </a>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <main class="main-content">
            <div class="admin-page-header">
                <div class="page-title">
                    <h2>Staff Dashboard</h2>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="filter-section">
                <div class="search-bar">
                    <input type="text" placeholder="Cari pesanan...">
                    <i class="fas fa-search"></i>
                </div>
                <div class="filter-buttons">
                    <button class="filter-btn active" data-status="all">Semua</button>
                    <button class="filter-btn" data-status="pending">Menunggu</button>
                    <button class="filter-btn" data-status="processing">Diproses</button>
                    <button class="filter-btn" data-status="ready">Siap</button>
                    <button class="filter-btn" data-status="completed">Selesai</button>
                    <button class="filter-btn" data-status="cancelled">Dibatalkan</button>
                </div>
                <div class="date-filter">
                    <input type="date" id="orderDate" class="form-control">
                </div>
            </div>

            <!-- Orders Table -->
            <div class="product-table-container">
                <table class="product-table">
                    <thead>
                        <tr>
                            <th>ID Pesanan</th>
                            <th>Tanggal</th>
                            <th>Pelanggan</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#ORD001</td>
                            <td>2024-03-20 14:30</td>
                            <td>John Doe</td>
                            <td>Rp 150.000</td>
                            <td><span class="status-badge status-pending">Menunggu</span></td>
                            <td class="product-actions">
                                <a href=" {{ route('staff-detail-pesanan') }}" style="text-decoration : none;"><button class="btn btn-secondary">Detail</button></a>
                            </td>
                        </tr>
                        <tr>
                            <td>#ORD002</td>
                            <td>2024-03-20 13:15</td>
                            <td>Jane Smith</td>
                            <td>Rp 85.000</td>
                            <td><span class="status-badge status-processing">Diproses</span></td>
                            <td class="product-actions">
                                <a href=" {{ route('staff-detail-pesanan') }}" style="text-decoration : none;"><button class="btn btn-secondary">Detail</button></a>
                            </td>
                        </tr>
                        <tr>
                            <td>#ORD003</td>
                            <td>2024-03-20 12:45</td>
                            <td>Mike Johnson</td>
                            <td>Rp 200.000</td>
                            <td><span class="status-badge status-ready">Siap</span></td>
                            <td class="product-actions">
                                <a href=" {{ route('staff-detail-pesanan') }}" style="text-decoration : none;"><button class="btn btn-secondary">Detail</button></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="pagination">
                <ul>
                    <li><a href="#" class="active">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#" class="next"><i class="fas fa-chevron-right"></i></a></li>
                </ul>
            </div>
        </main>
    </div>

    @vite('resources/js/script.js')
</body>
</html>