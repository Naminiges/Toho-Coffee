<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - TOHO Coffee</title>
    @vite('resources/css/style.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Header -->
    <header>
        <div class="navbar">
            <div class="logo">
                <img src="/api/placeholder/40/40" alt="TOHO Coffee Logo">
                <h1>TOHO Coffee</h1>
            </div>
            <ul class="nav-links">
                <li><a href="index.html">Beranda</a></li>
                <li><a href="menu.html">Menu</a></li>
                <li><a href="about.html">Tentang Kami</a></li>
                <li><a href="contact.html">Kontak</a></li>
            </ul>
            <div class="nav-actions">
                <i class="fas fa-search search-icon"></i>
                <i class="fas fa-shopping-cart cart-icon">
                    <span class="cart-count">3</span>
                </i>
                <i class="fas fa-user user-icon"></i>
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
        <h2>Keranjang Belanja</h2>
    </div>

    <div class="container">
        <!-- Breadcrumb -->
        <ul class="breadcrumb">
            <li><a href="index.html">Beranda</a></li>
            <li>Keranjang Belanja</li>
        </ul>

        <div class="cart-container">
            <!-- Cart Items Section -->
            <div class="cart-items">
                <h3>Produk dalam Keranjang (3)</h3>
                
                <div class="cart-item">
                    <div class="item-image">
                        <img src="/api/placeholder/100/100" alt="Arabica Gayo">
                    </div>
                    <div class="item-details">
                        <h4>Arabica Gayo Premium</h4>
                        <p class="item-variant">Medium Roast, 200gr</p>
                        <div class="item-price">Rp 85.000</div>
                    </div>
                    <div class="item-quantity">
                        <div class="quantity-selector">
                            <button class="quantity-btn decrease">-</button>
                            <input type="number" value="1" min="1" class="quantity-input">
                            <button class="quantity-btn increase">+</button>
                        </div>
                    </div>
                    <div class="item-subtotal">
                        <div class="subtotal-price">Rp 85.000</div>
                        <button class="remove-item"><i class="fas fa-trash"></i></button>
                    </div>
                </div>

                <div class="cart-item">
                    <div class="item-image">
                        <img src="/api/placeholder/100/100" alt="Robusta Toraja">
                    </div>
                    <div class="item-details">
                        <h4>Robusta Toraja Special</h4>
                        <p class="item-variant">Dark Roast, 250gr</p>
                        <div class="item-price">Rp 75.000</div>
                    </div>
                    <div class="item-quantity">
                        <div class="quantity-selector">
                            <button class="quantity-btn decrease">-</button>
                            <input type="number" value="1" min="1" class="quantity-input">
                            <button class="quantity-btn increase">+</button>
                        </div>
                    </div>
                    <div class="item-subtotal">
                        <div class="subtotal-price">Rp 75.000</div>
                        <button class="remove-item"><i class="fas fa-trash"></i></button>
                    </div>
                </div>

                <div class="cart-item">
                    <div class="item-image">
                        <img src="/api/placeholder/100/100" alt="TOHO Blend">
                    </div>
                    <div class="item-details">
                        <h4>TOHO Signature Blend</h4>
                        <p class="item-variant">Medium-Dark Roast, 500gr</p>
                        <div class="item-price">Rp 120.000</div>
                    </div>
                    <div class="item-quantity">
                        <div class="quantity-selector">
                            <button class="quantity-btn decrease">-</button>
                            <input type="number" value="1" min="1" class="quantity-input">
                            <button class="quantity-btn increase">+</button>
                        </div>
                    </div>
                    <div class="item-subtotal">
                        <div class="subtotal-price">Rp 120.000</div>
                        <button class="remove-item"><i class="fas fa-trash"></i></button>
                    </div>
                </div>

                <div class="cart-actions">
                    <div class="continue-shopping">
                        <a href="menu.html" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Lanjut Belanja</a>
                    </div>
                    <div class="cart-buttons">
                        <button class="btn btn-secondary clear-cart">Kosongkan Keranjang</button>
                        <button class="btn update-cart">Perbarui Keranjang</button>
                    </div>
                </div>
            </div>

            <!-- Cart Summary -->
            <div class="cart-summary">
                <h3>Ringkasan Belanja</h3>
                
                <div class="summary-item">
                    <span>Subtotal</span>
                    <span>Rp 280.000</span>
                </div>
                
                <div class="summary-item">
                    <span>Diskon</span>
                    <span>- Rp 0</span>
                </div>
                
                <div class="summary-item">
                    <span>Estimasi Pengiriman</span>
                    <span>Rp 15.000</span>
                </div>
                
                <div class="coupon-code">
                    <input type="text" placeholder="Kode Kupon" class="form-control">
                    <button class="btn">Terapkan</button>
                </div>
                
                <div class="summary-total">
                    <span>Total</span>
                    <span>Rp 295.000</span>
                </div>
                
                <a href="checkout.html" class="btn btn-block">Lanjut ke Pembayaran</a>
                
                <div class="secure-checkout">
                    <i class="fas fa-lock"></i> Pembayaran Aman & Terenkripsi
                </div>
                
                <div class="payment-methods">
                    <span>Metode Pembayaran:</span>
                    <div class="payment-icons">
                        <i class="fab fa-cc-visa"></i>
                        <i class="fab fa-cc-mastercard"></i>
                        <i class="fab fa-paypal"></i>
                        <i class="fas fa-wallet"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        <div class="related-products">
            <h3>Mungkin Anda Juga Suka</h3>
            <div class="products-grid">
                <div class="product-card">
                    <div class="product-image">
                        <img src="/api/placeholder/280/250" alt="TOHO Coffee">
                    </div>
                    <div class="product-info">
                        <h4>TOHO Coffee Drip Bag</h4>
                        <div class="price">Rp 45.000</div>
                        <div class="description">Kemasan praktis 5 sachet kopi drip premium.</div>
                        <button class="add-to-cart">Tambah ke Keranjang</button>
                    </div>
                </div>
                
                <div class="product-card">
                    <div class="product-image">
                        <img src="/api/placeholder/280/250" alt="TOHO Coffee">
                    </div>
                    <div class="product-info">
                        <h4>Pour Over Set</h4>
                        <div class="price">Rp 275.000</div>
                        <div class="description">Set lengkap untuk metode seduh pour over.</div>
                        <button class="add-to-cart">Tambah ke Keranjang</button>
                    </div>
                </div>
                
                <div class="product-card">
                    <div class="product-image">
                        <img src="/api/placeholder/280/250" alt="TOHO Coffee">
                    </div>
                    <div class="product-info">
                        <h4>TOHO Tumbler</h4>
                        <div class="price">Rp 130.000</div>
                        <div class="description">Tumbler termos 500ml untuk kopi selalu panas.</div>
                        <button class="add-to-cart">Tambah ke Keranjang</button>
                    </div>
                </div>
                
                <div class="product-card">
                    <div class="product-image">
                        <img src="/api/placeholder/280/250" alt="TOHO Coffee">
                    </div>
                    <div class="product-info">
                        <h4>Manual Grinder</h4>
                        <div class="price">Rp 225.000</div>
                        <div class="description">Penggiling kopi manual keramik presisi tinggi.</div>
                        <button class="add-to-cart">Tambah ke Keranjang</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <div class="footer-column">
                <h4>TOHO Coffee</h4>
                <p>Kopi berkualitas dari petani lokal terbaik Indonesia langsung ke cangkir Anda.</p>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            
            <div class="footer-column">
                <h4>Links</h4>
                <ul class="footer-links">
                    <li><a href="index.html">Beranda</a></li>
                    <li><a href="menu.html">Menu</a></li>
                    <li><a href="about.html">Tentang Kami</a></li>
                    <li><a href="blog.html">Blog</a></li>
                    <li><a href="contact.html">Kontak</a></li>
                </ul>
            </div>
            
            <div class="footer-column">
                <h4>Kontak</h4>
                <ul class="contact-info">
                    <li><span><i class="fas fa-map-marker-alt"></i></span> Jl. Kopi No. 123, Jakarta</li>
                    <li><span><i class="fas fa-phone"></i></span> +62 21 123 4567</li>
                    <li><span><i class="fas fa-envelope"></i></span> info@tohocoffee.com</li>
                    <li><span><i class="fas fa-clock"></i></span> Senin-Jumat: 08.00-20.00</li>
                </ul>
            </div>
            
            <div class="footer-column">
                <h4>Newsletter</h4>
                <p>Dapatkan informasi terbaru dan promo spesial.</p>
                <div class="newsletter">
                    <input type="email" placeholder="Email Anda" required>
                    <button>Berlangganan</button>
                </div>
            </div>
        </div>
        
        <div class="copyright">
            <p>&copy; 2025 TOHO Coffee. Semua Hak Dilindungi.</p>
        </div>
    </footer>

    <!-- Back to Top -->
    <a href="#" class="back-to-top">
        <i class="fas fa-arrow-up"></i>
    </a>

    <!-- Custom JS -->
    @vite('resources/js/script.css')
</body>
</html>