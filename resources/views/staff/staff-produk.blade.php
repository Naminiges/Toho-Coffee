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
                <img src="" alt="TOHO Coffee Logo">
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
                <img src="" alt="Staff Profile">
                <div class="admin-name">Staff TOHO</div> <!-- Menggunakan class yang sudah ada -->
                <div class="admin-role">Staff</div> <!-- Menggunakan class yang sudah ada -->
            </div>

            <ul class="sidebar-menu"> <!-- Menggunakan class yang sudah ada -->
                <li>
                    <a href="#">
                        <i class="fas fa-chart-line"></i>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="#" class="active">
                        <i class="fas fa-box"></i>
                        Produk
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
        <div class="main-content"> <!-- Menggunakan class yang sudah ada -->
            <div class="admin-page-header"> <!-- Menggunakan class yang sudah ada -->
                <div class="page-title"> <!-- Menggunakan class yang sudah ada -->
                    <h2>Manajemen Produk</h2>
                </div>
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
                            <th>Stok</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Contoh Baris Produk (akan diisi data dari backend) -->
                        <tr>
                            <td><img src="" alt="Produk 1"></td>
                            <td>Arabica Gayo Premium</td>
                            <td>Kopi</td>
                            <td>Rp 85.000</td>
                            <td>50</td>
                            <td>
                                <button class="btn status-active">Aktif</button>
                            </td>
                            <td class="product-actions">
                                <button class="btn btn-secondary edit-btn"><i class="fas fa-edit"></i> Edit</button> <!-- Menggunakan class yang sudah ada -->
                            </td>
                        </tr>
                         <tr>
                            <td><img src="" alt="Produk 2"></td>
                            <td>Robusta Toraja Special</td>
                            <td>Kopi</td>
                            <td>Rp 75.000</td>
                            <td>30</td>
                            <td>
                                <button class="btn status-inactive">Nonaktif</button>
                            </td>
                            <td class="product-actions">
                                <button class="btn btn-secondary edit-btn"><i class="fas fa-edit"></i> Edit</button> <!-- Menggunakan class yang sudah ada -->
                            </td>
                        </tr>
                         <tr>
                            <td><img src="" alt="Produk 3"></td>
                            <td>TOHO Signature Blend</td>
                            <td>Kopi</td>
                            <td>Rp 120.000</td>
                            <td>100</td>
                            <td>
                                <button class="btn status-active">Aktif</button>
                            </td>
                            <td class="product-actions">
                                <button class="btn btn-secondary edit-btn"><i class="fas fa-edit"></i> Edit</button> <!-- Menggunakan class yang sudah ada -->
                            </td>
                        </tr>
                          <tr>
                            <td><img src="" alt="Produk 4"></td>
                            <td>French Press 350ml</td>
                            <td>Merchandise</td>
                            <td>Rp 150.000</td>
                            <td>15</td>
                            <td>
                                <button class="btn status-inactive">Nonaktif</button>
                            </td>
                            <td class="product-actions">
                                <button class="btn btn-secondary edit-btn"><i class="fas fa-edit"></i> Edit</button> <!-- Menggunakan class yang sudah ada -->
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