<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Pelanggan - Toho Coffee</title>
    @vite('resources/css/style.css')
</head>
<body>
    <header>
        <div class="navbar"> <!-- Menggunakan class yang sudah ada -->
            <div class="logo"> <!-- Menggunakan class yang sudah ada -->
                <img src="" alt="TOHO Coffee Logo">
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
                <img src="" alt="Admin Profile">
                <div class="admin-name">Admin TOHO</div> <!-- Menggunakan class yang sudah ada -->
                <div class="admin-role">Administrator</div> <!-- Menggunakan class yang sudah ada -->
            </div>

            <ul class="sidebar-menu"> <!-- Menggunakan class yang sudah ada -->
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
                    <a href="#" class="active">
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
                    <a href="#" class="logout"> <!-- Menggunakan class yang sudah ada + logout style -->
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
                    <h2>Manajemen Pelanggan</h2>
                </div>
            </div>

            <!-- Customer Table -->
            <div class="product-table-container"> {{-- Reusing product-table-container for consistent styling --}}
                <table class="product-table"> {{-- Reusing product-table for consistent styling --}}
                    <thead>
                        <tr>
                            <th>ID Pelanggan</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Status Akun</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Example Customer Row (Active) --}}
                        <tr>
                            <td>#CUST001</td>
                            <td>Alice Smith</td>
                            <td>alice.s@example.com</td>
                            <td><span class="status-badge status-active">Aktif</span></td> {{-- Using status-active class --}}
                            <td class="product-actions"> {{-- Reusing product-actions for button styling --}}
                                {{-- Conditional Button: Show Nonaktifkan if Active --}}
                                <button class="btn btn-secondary" onclick="updateCustomerStatus('CUST001', 'inactive')">
                                    <i class="fas fa-user-slash"></i> Nonaktifkan
                                </button>
                            </td>
                        </tr>
                        {{-- Example Customer Row (Inactive) --}}
                         <tr>
                            <td>#CUST002</td>
                            <td>Bob Johnson</td>
                            <td>bob.j@example.com</td>
                            <td><span class="status-badge status-inactive">Tidak Aktif</span></td> {{-- Using status-inactive class --}}
                            <td class="product-actions"> {{-- Reusing product-actions for button styling --}}
                                {{-- Conditional Button: Show Aktifkan if Inactive --}}
                                <button class="btn btn-primary" onclick="updateCustomerStatus('CUST002', 'active')">
                                    <i class="fas fa-user-check"></i> Aktifkan
                                </button>
                            </td>
                        </tr>
                        <!-- More customer rows can be added here -->
                    </tbody>
                </table>
            </div>

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