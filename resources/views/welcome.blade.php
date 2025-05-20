<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toho Coffee - Nikmati Kopi Premium</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    @vite('resources/css/style.css')
</head>
<body>
    <!-- Header -->
    <header>
        <div class="navbar">
            <div class="logo">
                <img src="/api/placeholder/40/40" alt="Toho Coffee Logo">
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

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="hero-content">
            <h2>Nikmati Kopi Premium Berkualitas Terbaik</h2>
            <p>Temukan kenikmatan kopi yang diproses dengan teliti dari biji pilihan dan dipanggang dengan sempurna untuk menghasilkan cita rasa terbaik.</p>
            <a href="#products" class="cta-button">Belanja Sekarang</a>
            <a href="#about" class="secondary-button">Pelajari Lebih Lanjut</a>
        </div>
    </section>

    <!-- Featured Products -->
    <section class="featured" id="products">
        <div class="section-title">
            <h3>Produk Unggulan</h3>
            <p>Koleksi kopi premium kami yang dipilih dengan teliti untuk memberikan pengalaman kopi terbaik bagi Anda.</p>
        </div>
        <div class="products-grid">
            <!-- Produk 1 -->
            <div class="product-card">
                <div class="product-image">
                    <img src="/api/placeholder/300/250" alt="Arabica Premium">
                </div>
                <div class="product-info">
                    <h4>Arabica Premium</h4>
                    <div class="price">Rp 95.000</div>
                    <div class="description">Kopi Arabica premium dengan cita rasa fruity dan aroma yang khas.</div>
                    <button class="add-to-cart">Tambah ke Keranjang</button>
                </div>
            </div>
            <!-- Produk 2 -->
            <div class="product-card">
                <div class="product-image">
                    <img src="/api/placeholder/300/250" alt="Robusta Gold">
                </div>
                <div class="product-info">
                    <h4>Robusta Gold</h4>
                    <div class="price">Rp 85.000</div>
                    <div class="description">Kopi Robusta dengan body yang kuat dan rasa cokelat yang kaya.</div>
                    <button class="add-to-cart">Tambah ke Keranjang</button>
                </div>
            </div>
            <!-- Produk 3 -->
            <div class="product-card">
                <div class="product-image">
                    <img src="/api/placeholder/300/250" alt="Toho Signature Blend">
                </div>
                <div class="product-info">
                    <h4>Toho Signature Blend</h4>
                    <div class="price">Rp 105.000</div>
                    <div class="description">Campuran kopi spesial dengan rasa caramel dan sentuhan rempah.</div>
                    <button class="add-to-cart">Tambah ke Keranjang</button>
                </div>
            </div>
            <!-- Produk 4 -->
            <div class="product-card">
                <div class="product-image">
                    <img src="/api/placeholder/300/250" alt="Single Origin Aceh Gayo">
                </div>
                <div class="product-info">
                    <h4>Single Origin Aceh Gayo</h4>
                    <div class="price">Rp 120.000</div>
                    <div class="description">Kopi single origin dari Aceh Gayo dengan karakter rasa unik.</div>
                    <button class="add-to-cart">Tambah ke Keranjang</button>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about" id="about">
        <div class="about-image">
            <img src="/api/placeholder/600/400" alt="About Toho Coffee">
        </div>
        <div class="about-content">
            <h3>Tentang Toho Coffee</h3>
            <p>Toho Coffee adalah merek kopi premium yang berdedikasi untuk menghadirkan pengalaman kopi terbaik bagi para pecinta kopi di Indonesia. Kami memilih biji kopi terbaik dari petani lokal terpilih dan memproses dengan standar kualitas tinggi.</p>
            <p>Setiap biji kopi yang kami gunakan dipanen secara berkelanjutan dengan memperhatikan kelestarian lingkungan dan kesejahteraan petani kopi lokal.</p>
            <div class="features">
                <div class="feature">
                    <h5><span><i class="fas fa-check"></i></span> Kualitas Premium</h5>
                    <p>Hanya biji kopi terbaik yang lolos seleksi ketat kami.</p>
                </div>
                <div class="feature">
                    <h5><span><i class="fas fa-check"></i></span> Proses Terbaik</h5>
                    <p>Metode pengolahan modern dengan kontrol kualitas ketat.</p>
                </div>
                <div class="feature">
                    <h5><span><i class="fas fa-check"></i></span> Pemanggangan Sempurna</h5>
                    <p>Teknik pemanggangan presisi untuk rasa optimal.</p>
                </div>
                <div class="feature">
                    <h5><span><i class="fas fa-check"></i></span> Ramah Lingkungan</h5>
                    <p>Praktek bisnis yang berkelanjutan dan bertanggung jawab.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="testimonials" id="testimonials">
        <div class="section-title">
            <h3>Apa Kata Mereka</h3>
            <p>Pengalaman para pelanggan setia Toho Coffee yang telah menikmati produk kami.</p>
        </div>
        <div class="testimonial-slider">
            <div class="testimonial-slides">
                <!-- Testimonial 1 -->
                <div class="testimonial">
                    <div class="testimonial-content">
                        <p>"Kopi dari Toho Coffee selalu menjadi favorit saya. Aromanya sangat harum dan rasanya konsisten dari waktu ke waktu. Sangat direkomendasikan untuk para pecinta kopi!"</p>
                    </div>
                    <div class="testimonial-author">
                        <div class="author-image">
                            <img src="/api/placeholder/60/60" alt="Budi Santoso">
                        </div>
                        <div class="author-info">
                            <h5>Budi Santoso</h5>
                            <span>Pelanggan Setia</span>
                        </div>
                    </div>
                </div>
                <!-- Testimonial 2 -->
                <div class="testimonial">
                    <div class="testimonial-content">
                        <p>"Saya telah mencoba berbagai merek kopi, tetapi Toho Coffee benar-benar berbeda. Kualitasnya luar biasa dan layanan pengirimannya cepat. Definitely worth every penny!"</p>
                    </div>
                    <div class="testimonial-author">
                        <div class="author-image">
                            <img src="/api/placeholder/60/60" alt="Ani Wijaya">
                        </div>
                        <div class="author-info">
                            <h5>Ani Wijaya</h5>
                            <span>Barista</span>
                        </div>
                    </div>
                </div>
                <!-- Testimonial 3 -->
                <div class="testimonial">
                    <div class="testimonial-content">
                        <p>"Sebagai pemilik kafe, saya sangat memperhatikan kualitas kopi yang saya sajikan. Toho Coffee selalu menjadi pilihan utama kami karena kualitasnya yang konsisten dan respons positif dari pelanggan."</p>
                    </div>
                    <div class="testimonial-author">
                        <div class="author-image">
                            <img src="/api/placeholder/60/60" alt="Dimas Purnomo">
                        </div>
                        <div class="author-info">
                            <h5>Dimas Purnomo</h5>
                            <span>Pemilik Kafe</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="testimonial-controls">
                <div class="control-dot active"></div>
                <div class="control-dot"></div>
                <div class="control-dot"></div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="cta-content">
            <h3>Dapatkan Diskon 10% untuk Pembelian Pertama Anda</h3>
            <p>Bergabunglah dengan newsletter kami dan dapatkan diskon eksklusif serta informasi terbaru tentang produk dan promo spesial dari Toho Coffee.</p>
            <a href="#" class="cta-button">Daftar Sekarang</a>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contact">
        <div class="footer-content">
            <div class="footer-column">
                <div class="logo">
                    <img src="/api/placeholder/40/40" alt="Toho Coffee Logo">
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

    <!-- JavaScript -->
    @vite('resources/js/app.js')
</body>
</html>