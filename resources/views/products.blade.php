<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Menu - TOHO</title>
    @vite('resources/css/style.css')
</head>
<body>
    <!-- Header -->
    <header>
        <div class="navbar">
            <div class="logo">
                <img src="" alt="Toho Coffee Logo">
                <h1>Toho Coffee</h1>
            </div>
            <ul class="nav-links">
                <li><a href="#home">Beranda</a></li>
                <li><a href="#products">Produk</a></li>
            </ul>
            <div class="nav-actions">
                @auth
                    <div class="user-icon">
                        <i class="fas fa-user"></i>
                    </div>
                @else
                    <div class="auth-links">
                        <a href="{{ route('login') }}" class="login-btn">Masuk</a>
                        <a href="{{ route('register') }}" class="register-btn">Daftar</a>
                    </div>
                @endauth
            </div>
            <div class="hamburger">
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
    </header>

    <!-- Page Header -->
    <div class="page-header">
        <h2>Daftar Menu Kami</h2>
    </div>

    <!-- Menu Content -->
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="index.html">Beranda</a></li>
            <li>Menu</li>
        </ul>

        <div class="menu-filters">
            <button class="filter-btn active" data-category="all">Semua</button>
            <button class="filter-btn" data-category="coffee">Kopi</button>
            <button class="filter-btn" data-category="non-coffee">Non-Kopi</button>
            <button class="filter-btn" data-category="food">Makanan</button>
            <button class="filter-btn" data-category="pastry">Kue & Pastry</button>
        </div>

        <div class="search-bar">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Cari menu favorit Anda...">
        </div>

        <div class="menu-grid products-grid">
            <!-- Product 1 -->
            <div class="product-card" data-category="coffee">
                <div class="product-image">
                    <img src="" alt="Espresso">
                </div>
                <div class="product-info">
                    <h4>Espresso</h4>
                    <div class="price">Rp 15.000</div>
                    <div class="description">Shot kopi murni dengan intensitas tinggi dan aroma yang kuat.</div>
                    <button class="add-to-cart">Tambah ke Keranjang</button>
                </div>
            </div>

            <!-- Product 2 -->
            <div class="product-card" data-category="coffee">
                <div class="product-image">
                    <img src="" alt="Cappuccino">
                </div>
                <div class="product-info">
                    <h4>Cappuccino</h4>
                    <div class="price">Rp 25.000</div>
                    <div class="description">Espresso dengan steamed milk dan foam yang lembut di bagian atas.</div>
                    <button class="add-to-cart">Tambah ke Keranjang</button>
                </div>
            </div>

            <!-- Product 3 -->
            <div class="product-card" data-category="coffee">
                <div class="product-image">
                    <img src="" alt="Latte">
                </div>
                <div class="product-info">
                    <h4>Cafe Latte</h4>
                    <div class="price">Rp 28.000</div>
                    <div class="description">Espresso dengan susu yang lebih banyak dan foam tipis di atasnya.</div>
                    <button class="add-to-cart">Tambah ke Keranjang</button>
                </div>
            </div>

            <!-- Product 4 -->
            <div class="product-card" data-category="non-coffee">
                <div class="product-image">
                    <img src="" alt="Matcha Latte">
                </div>
                <div class="product-info">
                    <h4>Matcha Latte</h4>
                    <div class="price">Rp 30.000</div>
                    <div class="description">Minuman dengan bubuk teh hijau premium dan susu hangat.</div>
                    <button class="add-to-cart">Tambah ke Keranjang</button>
                </div>
            </div>

            <!-- Product 5 -->
            <div class="product-card" data-category="food">
                <div class="product-image">
                    <img src="" alt="Chicken Sandwich">
                </div>
                <div class="product-info">
                    <h4>Chicken Sandwich</h4>
                    <div class="price">Rp 35.000</div>
                    <div class="description">Sandwich ayam dengan sayuran segar dan saus spesial.</div>
                    <button class="add-to-cart">Tambah ke Keranjang</button>
                </div>
            </div>

            <!-- Product 6 -->
            <div class="product-card" data-category="pastry">
                <div class="product-image">
                    <img src="" alt="Croissant">
                </div>
                <div class="product-info">
                    <h4>Butter Croissant</h4>
                    <div class="price">Rp 20.000</div>
                    <div class="description">Croissant dengan lapisan butter yang gurih dan tekstur renyah.</div>
                    <button class="add-to-cart">Tambah ke Keranjang</button>
                </div>
            </div>

            <!-- Product 7 -->
            <div class="product-card" data-category="coffee">
                <div class="product-image">
                    <img src="" alt="Americano">
                </div>
                <div class="product-info">
                    <h4>Americano</h4>
                    <div class="price">Rp 18.000</div>
                    <div class="description">Espresso dengan tambahan air panas untuk rasa yang lebih ringan.</div>
                    <button class="add-to-cart">Tambah ke Keranjang</button>
                </div>
            </div>

            <!-- Product 8 -->
            <div class="product-card" data-category="non-coffee">
                <div class="product-image">
                    <img src="" alt="Hot Chocolate">
                </div>
                <div class="product-info">
                    <h4>Hot Chocolate</h4>
                    <div class="price">Rp 25.000</div>
                    <div class="description">Cokelat hangat dengan whipped cream yang lembut di atasnya.</div>
                    <button class="add-to-cart">Tambah ke Keranjang</button>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <ul class="pagination">
            <li><a href="#" class="active">1</a></li>
            <li><a href="#">2</a></li>
            <li><a href="#">3</a></li>
            <li><a href="#"><i class="fas fa-angle-right"></i></a></li>
        </ul>
    </div>

    <!-- Footer -->
    <footer id="contact">
        <div class="footer-content">
            <div class="footer-column">
                <div class="logo">
                    <img src="" alt="Toho Coffee Logo">
                    <h1>Toho Coffee</h1>
                </div>
                <p>Kopi premium untuk pengalaman menikmati kopi terbaik di rumah ataupun di kafe Anda.</p>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            <div class="footer-column">
                <h4>Informasi</h4>
                <ul class="footer-links">
                    <li><a href="#">Tentang Kami</a></li>
                    <li><a href="#">Produk</a></li>
                    <li><a href="#">Blog</a></li>
                    <li><a href="#">Cara Pemesanan</a></li>
                    <li><a href="#">FAQ</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h4>Layanan Pelanggan</h4>
                <ul class="footer-links">
                    <li><a href="#">Hubungi Kami</a></li>
                    <li><a href="#">Kebijakan Pengembalian</a></li>
                    <li><a href="#">Syarat dan Ketentuan</a></li>
                    <li><a href="#">Kebijakan Privasi</a></li>
                    <li><a href="#">Metode Pembayaran</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h4>Kontak Kami</h4>
                <ul class="contact-info">
                    <li><span><i class="fas fa-map-marker-alt"></i></span> Jl. Kopi No. 123, Jakarta Selatan</li>
                    <li><span><i class="fas fa-phone"></i></span> +62 21 1234 5678</li>
                    <li><span><i class="fas fa-envelope"></i></span> info@tohocoffee.com</li>
                    <li><span><i class="fas fa-clock"></i></span> Senin - Jumat: 08.00 - 17.00</li>
                </ul>
            </div>
            <div class="footer-column">
                <h4>Newsletter</h4>
                <p>Berlangganan newsletter kami untuk mendapatkan info dan penawaran terbaru.</p>
                <div class="newsletter">
                    <input type="email" placeholder="Email Anda...">
                    <button>Berlangganan</button>
                </div>
            </div>
        </div>
        <div class="copyright">
            <p>&copy; 2025 Toho Coffee. All Rights Reserved.</p>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <a href="#" class="back-to-top">
        <i class="fas fa-arrow-up"></i>
    </a>

    @vite('resources/js/app.js')
</body>
</html>