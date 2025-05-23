<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - TOHO Coffee</title>
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
            <ul class="nav-links">
                <li><a href="#home">Beranda</a></li>
                <li><a href="#products">Produk</a></li>
            </ul>
            <div class="nav-actions">
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
        <h2>Checkout</h2>
    </div>

    <div class="container">
        <!-- Breadcrumb -->
        <ul class="breadcrumb">
            <li><a href="index.html">Beranda</a></li>
            <li><a href="keranjang.html">Keranjang</a></li>
            <li>Checkout</li>
        </ul>

        <div class="cart-container">
            <!-- Checkout Form Section -->
            <div class="cart-items">
                <h3>Informasi Pesanan</h3>
                
                <form id="checkoutForm" class="checkout-form">
                    <div class="form-group">
                        <label for="name">Nama Lengkap</label>
                        <input type="text" id="name" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="phone">Nomor Telepon</label>
                        <input type="tel" id="phone" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Metode Pengambilan</label>
                        <div class="pickup-options">
                            <div class="pickup-option">
                                <input type="radio" id="pickup1" name="pickup" value="pickup1" checked>
                                <label for="pickup1">
                                    <strong>TOHO Coffee - Cabang Utama</strong><br>
                                    Jl. Contoh No. 123, Jakarta<br>
                                    Buka: 08:00 - 22:00
                                </label>
                            </div>
                            <div class="pickup-option">
                                <input type="radio" id="pickup2" name="pickup" value="pickup2">
                                <label for="pickup2">
                                    <strong>TOHO Coffee - Cabang Kemang</strong><br>
                                    Jl. Kemang Raya No. 45, Jakarta<br>
                                    Buka: 08:00 - 22:00
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="pickupTime">Waktu Pengambilan</label>
                        <input type="datetime-local" id="pickupTime" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="notes">Catatan (Opsional)</label>
                        <textarea id="notes" class="form-control" rows="3" placeholder="Tambahkan catatan khusus untuk pesanan Anda"></textarea>
                    </div>

                    <div class="cart-actions">
                        <div class="continue-shopping">
                            <a href="keranjang.html" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali ke Keranjang</a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Order Summary -->
            <div class="cart-summary">
                <h3>Ringkasan Pesanan</h3>
                
                <div class="cart-item">
                    <div class="item-image">
                        <img src="" alt="Arabica Gayo">
                    </div>
                    <div class="item-details">
                        <h4>Arabica Gayo Premium</h4>
                        <p class="item-variant">Medium Roast, 200gr</p>
                        <div class="item-quantity">Qty: 1</div>
                        <div class="item-price">Rp 85.000</div>
                    </div>
                </div>

                <div class="cart-item">
                    <div class="item-image">
                        <img src="" alt="Robusta Toraja">
                    </div>
                    <div class="item-details">
                        <h4>Robusta Toraja Special</h4>
                        <p class="item-variant">Dark Roast, 250gr</p>
                        <div class="item-quantity">Qty: 1</div>
                        <div class="item-price">Rp 75.000</div>
                    </div>
                </div>

                <div class="cart-item">
                    <div class="item-image">
                        <img src="" alt="TOHO Blend">
                    </div>
                    <div class="item-details">
                        <h4>TOHO Signature Blend</h4>
                        <p class="item-variant">Medium-Dark Roast, 500gr</p>
                        <div class="item-quantity">Qty: 1</div>
                        <div class="item-price">Rp 120.000</div>
                    </div>
                </div>
                
                <div class="summary-item">
                    <span>Subtotal</span>
                    <span>Rp 280.000</span>
                </div>
                
                <div class="summary-item">
                    <span>Diskon</span>
                    <span>- Rp 0</span>
                </div>
                
                <div class="coupon-code">
                    <input type="text" placeholder="Kode Kupon" class="form-control">
                    <button class="btn">Terapkan</button>
                </div>
                
                <div class="summary-total">
                    <span>Total</span>
                    <span>Rp 280.000</span>
                </div>
                
                <button type="submit" form="checkoutForm" class="btn btn-block">Buat Pesanan</button>
                
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
                <h4>Menu</h4>
                <ul class="footer-links">
                    <li><a href="#">Kopi</a></li>
                    <li><a href="#">Teh</a></li>
                    <li><a href="#">Snack</a></li>
                    <li><a href="#">Merchandise</a></li>
                </ul>
            </div>
            
            <div class="footer-column">
                <h4>Informasi</h4>
                <ul class="footer-links">
                    <li><a href="#">Tentang Kami</a></li>
                    <li><a href="#">Karier</a></li>
                    <li><a href="#">Blog</a></li>
                    <li><a href="#">Kontak</a></li>
                </ul>
            </div>
            
            <div class="footer-column">
                <h4>Bantuan</h4>
                <ul class="footer-links">
                    <li><a href="#">FAQ</a></li>
                    <li><a href="#">Pengiriman</a></li>
                    <li><a href="#">Pengembalian</a></li>
                    <li><a href="#">Kebijakan Privasi</a></li>
                </ul>
            </div>
        </div>
        
        <div class="copyright">
            <p>&copy; 2024 TOHO Coffee. All rights reserved.</p>
        </div>
    </footer>

    <a href="#" class="back-to-top">
        <i class="fas fa-arrow-up"></i>
    </a>

    @vite('resources/js/script.js')
</body>
</html>