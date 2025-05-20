<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Produk - TOHO Coffee Admin</title>
    @vite('resources/css/style.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Header -->
    <header>
        <div class="navbar"> <!-- Menggunakan class yang sudah ada -->
            <div class="logo"> <!-- Menggunakan class yang sudah ada -->
                <img src="/api/placeholder/40/40" alt="TOHO Coffee Logo">
                <h1>TOHO Coffee</h1>
            </div>
            <div class="nav-actions"> <!-- Menggunakan class yang sudah ada -->
                 <i class="fas fa-bell"></i>
                <i class="fas fa-user"></i>
            </div>
        </div>
    </header>

    <div class="product-management-container">
        <!-- Sidebar -->
        <div class="sidebar"> <!-- Menggunakan class yang sudah ada -->
            <div class="sidebar-header"> <!-- Menggunakan class yang sudah ada -->
                <img src="/api/placeholder/80/80" alt="Admin Profile">
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
                    <a href="#" class="active">
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
                <button class="btn" id="addProductBtn">
                    <i class="fas fa-plus"></i> Tambah Menu Baru
                </button>
            </div>

            <!-- Product Form Section (Hidden by default) -->
            <div class="product-form-section" id="productFormSection">
                <h3 class="section-title" id="formTitle">Tambah Menu Baru</h3>
                <form id="productForm">
                    <div class="form-row">
                        <div class="form-group"> <!-- Menggunakan class yang sudah ada -->
                            <label for="productName">Nama Produk</label> <!-- Menggunakan class yang sudah ada -->
                            <input type="text" id="productName" class="form-control" required> <!-- Menggunakan class yang sudah ada -->
                        </div>
                        <div class="form-group"> <!-- Menggunakan class yang sudah ada -->
                            <label for="productCategory">Kategori</label> <!-- Menggunakan class yang sudah ada -->
                            <select id="productCategory" class="form-control" required> <!-- Menggunakan class yang sudah ada -->
                                <option value="">-- Pilih Kategori --</option>
                                <option value="kopi">Kopi</option>
                                <option value="teh">Teh</option>
                                <option value="snack">Snack</option>
                                <option value="merchandise">Merchandise</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group"> <!-- Menggunakan class yang sudah ada -->
                        <label for="productDescription">Deskripsi</label> <!-- Menggunakan class yang sudah ada -->
                        <textarea id="productDescription" class="form-control" rows="3" required></textarea> <!-- Menggunakan class yang sudah ada -->
                    </div>

                     <div class="form-row">
                        <div class="form-group"> <!-- Menggunakan class yang sudah ada -->
                            <label for="productPrice">Harga (Rp)</label> <!-- Menggunakan class yang sudah ada -->
                            <input type="number" id="productPrice" class="form-control" min="0" required> <!-- Menggunakan class yang sudah ada -->
                        </div>
                        <div class="form-group"> <!-- Menggunakan class yang sudah ada -->
                            <label for="productStock">Stok</label> <!-- Menggunakan class yang sudah ada -->
                            <input type="number" id="productStock" class="form-control" min="0" required> <!-- Menggunakan class yang sudah ada -->
                        </div>
                    </div>

                    <div class="form-group"> <!-- Menggunakan class yang sudah ada -->
                        <label for="productImage">Gambar Produk</label> <!-- Menggunakan class yang sudah ada -->
                        <input type="file" id="productImage" class="form-control"> <!-- Menggunakan class yang sudah ada -->
                         <p style="font-size: 12px; color: var(--dark-gray); margin-top: 5px;">Format: JPG, PNG. Maks: 2MB</p>
                    </div>

                    <div class="form-actions"> <!-- Menggunakan style actions yang serupa -->
                        <button type="button" class="btn btn-cancel" id="cancelFormBtn">Batal</button> <!-- Menggunakan class yang sudah ada -->
                        <button type="submit" class="btn">Simpan Produk</button> <!-- Menggunakan class yang sudah ada -->
                    </div>
                </form>
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
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Contoh Baris Produk (akan diisi data dari backend) -->
                        <tr>
                            <td><img src="/api/placeholder/50/50" alt="Produk 1"></td>
                            <td>Arabica Gayo Premium</td>
                            <td>Kopi</td>
                            <td>Rp 85.000</td>
                            <td>50</td>
                            <td class="product-actions">
                                <button class="btn btn-secondary edit-btn"><i class="fas fa-edit"></i> Edit</button> <!-- Menggunakan class yang sudah ada -->
                                <button class="btn btn-cancel delete-btn"><i class="fas fa-trash-alt"></i> Hapus</button> <!-- Menggunakan class yang sudah ada -->
                            </td>
                        </tr>
                         <tr>
                            <td><img src="/api/placeholder/50/50" alt="Produk 2"></td>
                            <td>Robusta Toraja Special</td>
                            <td>Kopi</td>
                            <td>Rp 75.000</td>
                            <td>30</td>
                            <td class="product-actions">
                                <button class="btn btn-secondary edit-btn"><i class="fas fa-edit"></i> Edit</button> <!-- Menggunakan class yang sudah ada -->
                                <button class="btn btn-cancel delete-btn"><i class="fas fa-trash-alt"></i> Hapus</button> <!-- Menggunakan class yang sudah ada -->
                            </td>
                        </tr>
                         <tr>
                            <td><img src="/api/placeholder/50/50" alt="Produk 3"></td>
                            <td>TOHO Signature Blend</td>
                            <td>Kopi</td>
                            <td>Rp 120.000</td>
                            <td>100</td>
                            <td class="product-actions">
                                <button class="btn btn-secondary edit-btn"><i class="fas fa-edit"></i> Edit</button> <!-- Menggunakan class yang sudah ada -->
                                <button class="btn btn-cancel delete-btn"><i class="fas fa-trash-alt"></i> Hapus</button> <!-- Menggunakan class yang sudah ada -->
                            </td>
                        </tr>
                          <tr>
                            <td><img src="/api/placeholder/50/50" alt="Produk 4"></td>
                            <td>French Press 350ml</td>
                            <td>Merchandise</td>
                            <td>Rp 150.000</td>
                            <td>15</td>
                            <td class="product-actions">
                                <button class="btn btn-secondary edit-btn"><i class="fas fa-edit"></i> Edit</button> <!-- Menggunakan class yang sudah ada -->
                                <button class="btn btn-cancel delete-btn"><i class="fas fa-trash-alt"></i> Hapus</button> <!-- Menggunakan class yang sudah ada -->
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="resources/js/script.js"></script>
</body>
</html>