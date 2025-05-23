<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Produk Kopi - TOHO</title>
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
                <div class="cart-icon">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="cart-count">0</span>
                </div>
                <div class="user-icon">
                    <i class="fas fa-user"></i>
                </div>
            </div>
            <div class="hamburger">
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
    </header>

    <!-- Page Header -->
    <section class="page-header">
        <h2>Katalog Produk Kopi</h2>
    </section>

    <!-- Main Content -->
    <div class="container">
        <!-- Breadcrumb -->
        <ul class="breadcrumb">
            <li><a href="index.html">Beranda</a></li>
            <li>Katalog Produk Kopi</li>
        </ul>

        <!-- Menu Filters -->
        <div class="menu-filters">
            <button class="filter-btn active" data-category="all">Semua</button>
            <button class="filter-btn" data-category="arabica">Arabica</button>
            <button class="filter-btn" data-category="robusta">Robusta</button>
            <button class="filter-btn" data-category="blend">Blend</button>
            <button class="filter-btn" data-category="single-origin">Single Origin</button>
        </div>

        <!-- Search Bar -->
        <div class="search-bar">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Cari produk kopi...">
        </div>

        <!-- Products Grid -->
        <div class="menu-grid">
            <!-- Product 1 -->
            <div class="product-card" data-category="arabica">
                <div class="product-image">
                    <img src="" alt="Arabica Aceh Gayo">
                </div>
                <div class="product-info">
                    <h4>Arabica Aceh Gayo</h4>
                    <div class="price">Rp 75.000</div>
                    <div class="description">Kopi dengan aroma floral dan citrus, rasa fruity dengan keasaman sedang.</div>
                    <button class="add-to-cart">Tambah ke Keranjang</button>
                </div>
            </div>

            <!-- Product 2 -->
            <div class="product-card" data-category="robusta">
                <div class="product-image">
                    <img src="" alt="Robusta Lampung">
                </div>
                <div class="product-info">
                    <h4>Robusta Lampung</h4>
                    <div class="price">Rp 65.000</div>
                    <div class="description">Kopi dengan karakter rasa kuat, earthy, dan sedikit sentuhan coklat.</div>
                    <button class="add-to-cart">Tambah ke Keranjang</button>
                </div>
            </div>

            <!-- Product 3 -->
            <div class="product-card" data-category="blend">
                <div class="product-image">
                    <img src="" alt="House Blend">
                </div>
                <div class="product-info">
                    <h4>House Blend</h4>
                    <div class="price">Rp 70.000</div>
                    <div class="description">Perpaduan sempurna arabica dan robusta dengan rasa seimbang dan body sedang.</div>
                    <button class="add-to-cart">Tambah ke Keranjang</button>
                </div>
            </div>

            <!-- Product 4 -->
            <div class="product-card" data-category="single-origin">
                <div class="product-image">
                    <img src="" alt="Toraja Kalosi">
                </div>
                <div class="product-info">
                    <h4>Toraja Kalosi</h4>
                    <div class="price">Rp 85.000</div>
                    <div class="description">Single origin dengan karakter rasa herbal, spicy, dan sentuhan dark chocolate.</div>
                    <button class="add-to-cart">Tambah ke Keranjang</button>
                </div>
            </div>

            <!-- Product 5 -->
            <div class="product-card" data-category="arabica">
                <div class="product-image">
                    <img src="" alt="Arabica Java Preanger">
                </div>
                <div class="product-info">
                    <h4>Arabica Java Preanger</h4>
                    <div class="price">Rp 78.000</div>
                    <div class="description">Kopi dengan karakter jasmine aroma, rasa caramel dan keasaman rendah.</div>
                    <button class="add-to-cart">Tambah ke Keranjang</button>
                </div>
            </div>

            <!-- Product 6 -->
            <div class="product-card" data-category="robusta">
                <div class="product-image">
                    <img src="" alt="Robusta Temanggung">
                </div>
                <div class="product-info">
                    <h4>Robusta Temanggung</h4>
                    <div class="price">Rp 68.000</div>
                    <div class="description">Kopi dengan body tebal, aftertaste panjang, dan sentuhan nutty.</div>
                    <button class="add-to-cart">Tambah ke Keranjang</button>
                </div>
            </div>

            <!-- Product 7 -->
            <div class="product-card" data-category="blend">
                <div class="product-image">
                    <img src="" alt="Morning Blend">
                </div>
                <div class="product-info">
                    <h4>Morning Blend</h4>
                    <div class="price">Rp 72.000</div>
                    <div class="description">Blend khusus untuk pagi hari dengan karakter rasa bright dan menyegarkan.</div>
                    <button class="add-to-cart">Tambah ke Keranjang</button>
                </div>
            </div>

            <!-- Product 8 -->
            <div class="product-card" data-category="single-origin">
                <div class="product-image">
                    <img src="" alt="Flores Bajawa">
                </div>
                <div class="product-info">
                    <h4>Flores Bajawa</h4>
                    <div class="price">Rp 82.000</div>
                    <div class="description">Single origin dengan karakter floral, hint of vanilla, dan keasaman medium.</div>
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

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="cta-content">
            <h3>Belum Tahu Mau Pilih Kopi Apa?</h3>
            <p>Daftar sekarang dan dapatkan rekomendasi kopi sesuai dengan selera dan preferensi Anda.</p>
            <a href="register.html" class="cta-button">Daftar Sekarang</a>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <div class="footer-column">
                <h4>TOHO</h4>
                <p>Menyajikan kopi lokal terbaik Indonesia dengan kualitas premium untuk para pecinta kopi sejati.</p>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>

            <div class="footer-column">
                <h4>Menu Utama</h4>
                <ul class="footer-links">
                    <li><a href="index.html">Beranda</a></li>
                    <li><a href="menu.html">Menu</a></li>
                    <li><a href="about.html">Tentang Kami</a></li>
                    <li><a href="blog.html">Blog</a></li>
                    <li><a href="contact.html">Kontak</a></li>
                </ul>
            </div>

            <div class="footer-column">
                <h4>Bantuan</h4>
                <ul class="footer-links">
                    <li><a href="#">FAQ</a></li>
                    <li><a href="#">Cara Pemesanan</a></li>
                    <li><a href="#">Ketentuan Layanan</a></li>
                    <li><a href="#">Kebijakan Privasi</a></li>
                    <li><a href="#">Pengembalian & Refund</a></li>
                </ul>
            </div>

            <div class="footer-column">
                <h4>Kontak Kami</h4>
                <ul class="contact-info">
                    <li><span><i class="fas fa-map-marker-alt"></i></span> Jl. Kopi Nikmat No. 123, Jakarta Selatan</li>
                    <li><span><i class="fas fa-phone"></i></span> +62 21 1234 5678</li>
                    <li><span><i class="fas fa-envelope"></i></span> info@TOHO.id</li>
                </ul>
            </div>

            <div class="footer-column">
                <h4>Newsletter</h4>
                <p>Berlangganan untuk mendapatkan update dan promo terbaru</p>
                <div class="newsletter">
                    <input type="email" placeholder="Email Anda">
                    <button type="submit">Berlangganan</button>
                </div>
            </div>
        </div>

        <div class="copyright">
            <p>&copy; 2025 TOHO. All Rights Reserved.</p>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <a href="#" class="back-to-top">
        <i class="fas fa-arrow-up"></i>
    </a>

    @vite('resources/js/app.js')
</body>
</html>