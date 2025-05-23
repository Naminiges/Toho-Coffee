<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan - TOHO Coffee</title>
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
        <h2>Detail Pesanan</h2>
    </div>

    <div class="container">
        <!-- Breadcrumb -->
        <ul class="breadcrumb">
            <li><a href="index.html">Beranda</a></li>
            <li><a href="riwayat-pesanan.html">Riwayat Pesanan</a></li>
            <li>Detail Pesanan</li>
        </ul>

        <div class="order-detail-container">
            <!-- Left Column -->
            <div class="order-detail-main">
                <!-- Order Status -->
                <div class="order-info-card">
                    <div class="order-status-badge status-ready">
                        <i class="fas fa-check-circle"></i>
                        Siap Diambil
                    </div>
                    <div class="info-grid">
                        <div class="info-item">
                            <label>Nomor Pesanan</label>
                            <span>#TOHO-2024-001</span>
                        </div>
                        <div class="info-item">
                            <label>Tanggal Pesanan</label>
                            <span>20 Maret 2024, 14:30</span>
                        </div>
                        <div class="info-item">
                            <label>Metode Pengambilan</label>
                            <span>Pickup di Toko</span>
                        </div>
                        <div class="info-item">
                            <label>Lokasi Pengambilan</label>
                            <span>TOHO Coffee - Cabang Utama</span>
                        </div>
                        <div class="info-item">
                            <label>Waktu Pengambilan</label>
                            <span>20 Maret 2024, 15:00</span>
                        </div>
                        <div class="info-item">
                            <label>Status Pembayaran</label>
                            <span>Lunas</span>
                        </div>
                    </div>
                </div>

                <!-- Order Timeline -->
                <div class="order-info-card">
                    <h3>Status Pesanan</h3>
                    <div class="order-timeline">
                        <div class="timeline-item">
                            <div class="timeline-icon"></div>
                            <div class="timeline-content">
                                <div class="timeline-date">20 Maret 2024, 14:30</div>
                                <div class="timeline-text">Pesanan diterima</div>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-icon"></div>
                            <div class="timeline-content">
                                <div class="timeline-date">20 Maret 2024, 14:35</div>
                                <div class="timeline-text">Pesanan dikonfirmasi</div>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-icon"></div>
                            <div class="timeline-content">
                                <div class="timeline-date">20 Maret 2024, 15:00</div>
                                <div class="timeline-text">Pesanan siap diambil</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="order-info-card">
                    <h3>Detail Pesanan</h3>
                    <div class="order-items-list">
                        <div class="order-item">
                            <div class="item-image">
                                <img src="" alt="Arabica Gayo">
                            </div>
                            <div class="item-details">
                                <h4>Arabica Gayo Premium</h4>
                                <p class="item-variant">Medium Roast, 200gr</p>
                                <div class="item-price">Rp 85.000</div>
                            </div>
                        </div>
                        <div class="order-item">
                            <div class="item-image">
                                <img src="" alt="Robusta Toraja">
                            </div>
                            <div class="item-details">
                                <h4>Robusta Toraja Special</h4>
                                <p class="item-variant">Dark Roast, 250gr</p>
                                <div class="item-price">Rp 75.000</div>
                            </div>
                        </div>
                    </div>

                    <div class="order-summary">
                        <div class="summary-item">
                            <span>Subtotal</span>
                            <span>Rp 160.000</span>
                        </div>
                        <div class="summary-item">
                            <span>Diskon</span>
                            <span>- Rp 0</span>
                        </div>
                        <div class="summary-total">
                            <span>Total</span>
                            <span>Rp 160.000</span>
                        </div>
                    </div>

                    <div class="order-actions">
                        <button class="btn btn-secondary">Kembali</button>
                        <button class="btn">Ambil Pesanan</button>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="order-detail-sidebar">
                <!-- QR Code -->
                <div class="qr-code">
                    <img src="" alt="QR Code">
                    <p>Tunjukkan QR Code ini saat mengambil pesanan</p>
                </div>

                <!-- Customer Info -->
                <div class="order-info-card">
                    <h3>Informasi Pelanggan</h3>
                    <div class="info-item">
                        <label>Nama</label>
                        <span>John Doe</span>
                    </div>
                    <div class="info-item">
                        <label>Email</label>
                        <span>john.doe@example.com</span>
                    </div>
                    <div class="info-item">
                        <label>Nomor Telepon</label>
                        <span>+62 812 3456 7890</span>
                    </div>
                </div>

                <!-- Payment Info -->
                <div class="order-info-card">
                    <h3>Informasi Pembayaran</h3>
                    <div class="info-item">
                        <label>Metode Pembayaran</label>
                        <span>Transfer Bank BCA</span>
                    </div>
                    <div class="info-item">
                        <label>Nomor Rekening</label>
                        <span>1234567890</span>
                    </div>
                    <div class="info-item">
                        <label>Status Pembayaran</label>
                        <span>Lunas</span>
                    </div>
                    <div class="info-item">
                        <label>Tanggal Pembayaran</label>
                        <span>20 Maret 2024, 14:31</span>
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