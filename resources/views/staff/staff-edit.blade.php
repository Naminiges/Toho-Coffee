<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk - TOHO Coffee Admin</title>
    @vite('resources/css/style.css')
</head>
<body>
    <!-- Header -->
    <header>
        <div class="navbar">
            <div class="logo">
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
        <div class="sidebar">
            <div class="sidebar-header">
                <img src="{{ asset('images/logo-toho.jpg') }}" alt="Admin Profile">
                <div class="admin-name">Staff TOHO</div>
                <div class="admin-role">Staff</div>
            </div>

            <ul class="sidebar-menu"> <!-- Menggunakan class yang sudah ada -->
                <li>
                    <a href="{{ route('staff-dashboard') }}">
                        <i class="fas fa-chart-line"></i>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('staff-manajemen-produk') }}" class="active">
                        <i class="fas fa-box"></i>
                        Produk
                    </a>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="admin-page-header">
                <div class="page-title">
                    <h2>Edit Produk</h2>
                </div>
            </div>

            <!-- Product Form Section -->
            <div class="product-form-section active">
                <form id="editProductForm" action="#" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="productName">Nama Produk</label>
                        <input type="text" id="productName" name="name" class="form-control" value="" readonly>
                    </div>
                    <div class="form-group">
                        <label for="productCategory">Kategori</label>
                        <input type="text" id="productCategory" name="category" class="form-control" value="" readonly>
                    </div>
                    <div class="form-group">
                        <label for="productDescription">Deskripsi</label>
                        <textarea id="productDescription" name="description" class="form-control" rows="3" readonly></textarea>
                    </div>
                    <div class="form-group">   
                        <label for="productPrice">Harga (Rp)</label> 
                        <input type="number" id="productPrice" name="price" class="form-control" min="0" value="" readonly>
                    </div>
                    <div class="form-group">
                        <label for="productStatus">Status</label>
                        <select id="productStatus" name="status" class="form-control" required>
                            <option value="active" >Aktif</option>
                            <option value="inactive" >Nonaktif</option>
                        </select>
                    </div>

                    <div class="form-actions">
                        <a href="{{ route('staff-manajemen-produk') }}" class="btn btn-cancel">Batal</a>
                        <button type="submit" class="btn">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @vite('resources/js/script.js')
</body>
</html>

<?php
// <form id="editProductForm" action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
// @csrf
// @method('PUT')
// <a href="{{ route('admin.products.index') }}" class="btn btn-cancel">Batal</a>
// <div class="product-form-section active">
//     <form id="editProductForm" action="#" method="POST" enctype="multipart/form-data">
//         <div class="form-row">
//             <div class="form-group">
//                 <label for="productName">Nama Produk</label>
//                 <input type="text" id="productName" name="name" class="form-control" value="{{ $product->name }}" required>
//             </div>
//             <div class="form-group">
//                 <label for="productCategory">Kategori</label>
//                 <select id="productCategory" name="category" class="form-control" required>
//                     <option value="">-- Pilih Kategori --</option>
//                     <option value="kopi" {{ $product->category == 'kopi' ? 'selected' : '' }}>Kopi</option>
//                     <option value="teh" {{ $product->category == 'teh' ? 'selected' : '' }}>Teh</option>
//                     <option value="snack" {{ $product->category == 'snack' ? 'selected' : '' }}>Snack</option>
//                     <option value="merchandise" {{ $product->category == 'merchandise' ? 'selected' : '' }}>Merchandise</option>
//                 </select>
//             </div>
//         </div>

//         <div class="form-group">
//             <label for="productDescription">Deskripsi</label>
//             <textarea id="productDescription" name="description" class="form-control" rows="3" required>{{ $product->description }}</textarea>
//         </div>

//         <div class="form-row">
//             <div class="form-group">
//                 <label for="productPrice">Harga (Rp)</label>
//                 <input type="number" id="productPrice" name="price" class="form-control" min="0" value="{{ $product->price }}" required>
//             </div>
//             <div class="form-group">
//                 <label for="productStock">Stok</label>
//                 <input type="number" id="productStock" name="stock" class="form-control" min="0" value="{{ $product->stock }}" required>
//             </div>
//         </div>

//         <div class="form-group">
//             <label for="productImage">Gambar Produk</label>
//             <input type="file" id="productImage" name="image" class="form-control" accept="image/*">
//             <p style="font-size: 12px; color: var(--dark-gray); margin-top: 5px;">Format: JPG, PNG. Maks: 2MB</p>
//             <div id="imagePreview" style="margin-top: 10px;">
//                 <img src="{{ asset('storage/' . $product->image) }}" alt="Preview" style="max-width: 200px; border-radius: 8px;">
//             </div>
//         </div>

//         <div class="form-group">
//             <label for="productStatus">Status</label>
//             <select id="productStatus" name="status" class="form-control" required>
//                 <option value="active" {{ $product->status == 'active' ? 'selected' : '' }}>Aktif</option>
//                 <option value="inactive" {{ $product->status == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
//             </select>
//         </div>

//         <div class="form-actions">
//             <a href="#" class="btn btn-cancel">Batal</a>
//             <button type="submit" class="btn">Simpan Perubahan</button>
//         </div>
//     </form>
//     </div>
?>