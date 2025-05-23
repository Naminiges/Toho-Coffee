<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk - TOHO Coffee Admin</title>
    @vite('resources/css/style.css')
</head>
<body>
    <!-- Header -->
    <header>
        <div class="navbar">
            <div class="logo">
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
        <div class="sidebar">
            <div class="sidebar-header">
                <img src="" alt="Admin Profile">
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
                    <h2>Tambah Produk Baru</h2>
                </div>
            </div>

            <!-- Product Form Section -->
            <div class="product-form-section active">
                <form id="productForm" action="#" method="POST" enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="productName">Nama Produk</label>
                            <input type="text" id="productName" name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="productCategory">Kategori</label>
                            <select id="productCategory" name="category" class="form-control" required>
                                <option value="">-- Pilih Kategori --</option>
                                <option value="kopi">Kopi</option>
                                <option value="teh">Teh</option>
                                <option value="snack">Snack</option>
                                <option value="merchandise">Merchandise</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="productDescription">Deskripsi</label>
                        <textarea id="productDescription" name="description" class="form-control" rows="3" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="productPrice">Harga (Rp)</label>
                        <input type="number" id="productPrice" name="price" class="form-control" min="0" required>
                    </div>

                    <div class="form-group">
                        <label for="productImage">Gambar Produk</label>
                        <input type="file" id="productImage" name="image" class="form-control" accept="image/*" required>
                        <p style="font-size: 12px; color: var(--dark-gray); margin-top: 5px;">Format: JPG, PNG. Maks: 2MB</p>
                        <div id="imagePreview" style="margin-top: 10px; display: none;">
                            <img src="" alt="Preview" style="max-width: 200px; border-radius: 8px;">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="productStatus">Status</label>
                        <select id="productStatus" name="status" class="form-control" required>
                            <option value="active">Aktif</option>
                            <option value="inactive">Nonaktif</option>
                        </select>
                    </div>

                    <div class="form-actions">
                        <a href="#" class="btn btn-cancel">Batal</a>
                        <button type="submit" class="btn">Simpan Produk</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @vite('resources/js/script.js')
</body>
</html>

<?php 
// <form id="productForm" action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
// @csrf
// <a href="{{ route('admin.products.index') }}" class="btn btn-cancel">Batal</a>
?>
                        