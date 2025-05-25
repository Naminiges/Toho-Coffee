<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Produk - TOHO Coffee Admin</title>
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

    <div class="product-management-container">
        <!-- Sidebar -->
        <div class="sidebar"> <!-- Menggunakan class yang sudah ada -->
            <div class="sidebar-header"> <!-- Menggunakan class yang sudah ada -->
                <img src="{{ asset('images/logo-toho.jpg') }}" alt="Admin Profile">
                <div class="admin-name">Admin TOHO</div> <!-- Menggunakan class yang sudah ada -->
                <div class="admin-role">Administrator</div> <!-- Menggunakan class yang sudah ada -->
            </div>

            <ul class="sidebar-menu">
                <li>
                    <a href="{{ route('admin-dashboard') }}">
                        <i class="fas fa-chart-line"></i>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin-manajemen-pesanan') }}">
                        <i class="fas fa-shopping-bag"></i>
                        Pesanan
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin-manajemen-produk') }}" class="active">
                        <i class="fas fa-box"></i>
                        Produk
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin-manajemen-pelanggan') }}">
                        <i class="fas fa-users"></i>
                        Pelanggan
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin-manajemen-staff') }}">
                        <i class="fas fa-certificate"></i>
                        Staff
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin-laporan') }}">
                        <i class="fas fa-chart-pie"></i>
                        Laporan
                    </a>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content"> <!-- Menggunakan class yang sudah ada -->
            <div class="admin-page-header"> <!-- Menggunakan class yang sudah ada -->
                <div class="page-title"> <!-- Menggunakan class yang sudah ada -->
                    <h2>Manajemen Produk</h2>
                </div>
                <a href="{{ route('admin-tambah-produk') }}">
                    <button class="btn" id="addProductBtn">
                        <i class="fas fa-plus"></i> Tambah Produk Baru
                    </button>
                </a>
            </div>

            <!-- Product List Section -->
            <div class="product-list-section">
                <table class="product-table">
                    <thead>
                        <tr>
                            <th>Gambar</th>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Contoh Baris Produk (akan diisi data dari backend) -->
                        <tr>
                            <td><img src="{{ asset('images/kopi1.jpg') }}" alt="Produk 1"></td>
                            <td>Arabica Gayo Premium</td>
                            <td>Kopi</td>
                            <td>Rp 85.000</td>
                            <td>
                                <button class="btn status-active">Aktif</button>
                            </td>
                            <td class="product-actions">
                                <a href="{{ route('admin-edit-produk') }}">
                                    <button class="btn btn-secondary edit-btn"><i class="fas fa-edit"></i> Edit</button>
                                </a>
                            </td>
                        </tr>
                         <tr>
                            <td><img src="{{ asset('images/kopi2.jpg') }}" alt="Produk 2"></td>
                            <td>Robusta Toraja Special</td>
                            <td>Kopi</td>
                            <td>Rp 75.000</td>
                            <td>
                                <button class="btn status-inactive">Nonaktif</button>
                            </td>
                            <td class="product-actions">
                                <a href="{{ route('admin-edit-produk') }}">
                                    <button class="btn btn-secondary edit-btn"><i class="fas fa-edit"></i> Edit</button>
                                </a>
                            </td>
                        </tr>
                         <tr>
                            <td><img src="{{ asset('images/kopi3.jpg') }}" alt="Produk 3"></td>
                            <td>TOHO Signature Blend</td>
                            <td>Kopi</td>
                            <td>Rp 120.000</td>
                            <td>
                                <button class="btn status-active">Aktif</button>
                            </td>
                            <td class="product-actions">
                                <a href="{{ route('admin-edit-produk') }}">
                                    <button class="btn btn-secondary edit-btn"><i class="fas fa-edit"></i> Edit</button>
                                </a>
                            </td>
                        </tr>
                          <tr>
                            <td><img src="{{ asset('images/kopi4.jpg') }}" alt="Produk 4"></td>
                            <td>French Press 350ml</td>
                            <td>Merchandise</td>
                            <td>Rp 150.000</td>
                            <td>
                                <button class="btn status-inactive">Nonaktif</button>
                            </td>
                            <td class="product-actions">
                                <a href="{{ route('admin-edit-produk') }}">
                                    <button class="btn btn-secondary edit-btn"><i class="fas fa-edit"></i> Edit</button>
                                </a>
                            </td>
                        </tr>
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
        </div>
    </div>

    @vite('resources/js/script.js')
</body>
</html>