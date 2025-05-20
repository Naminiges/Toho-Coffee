<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan - TOHO Coffee</title>
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
                <li><a href="#home">Beranda</a></li>
                <li><a href="#products">Produk</a></li>
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
        <h2>Riwayat Pesanan</h2>
    </div>

    <div class="container">
        <!-- Breadcrumb -->
        <ul class="breadcrumb">
            <li><a href="index.html">Beranda</a></li>
            <li>Riwayat Pesanan</li>
        </ul>

        <!-- Filter Section -->
        <div class="filter-section">
            <button class="filter-btn active">Semua</button>
            <button class="filter-btn">Menunggu Konfirmasi</button>
            <button class="filter-btn">Diproses</button>
            <button class="filter-btn">Siap Diambil</button>
            <button class="filter-btn">Selesai</button>
            <button class="filter-btn">Dibatalkan</button>
        </div>

        <!-- Orders List -->
        <div class="orders-list">
            <!-- Order Card 1 -->
            <div class="order-card">
                <div class="order-header">
                    <div>
                        <h3>Order #TOHO-2024-001</h3>
                        <p style="color: var(--dark-gray); font-size: 14px;">20 Maret 2024, 14:30</p>
                    </div>
                    <div class="order-status status-ready">
                        <i class="fas fa-check-circle"></i>
                        Siap Diambil
                    </div>
                </div>
                <div class="order-content">
                    <div class="order-items">
                        <div class="order-item">
                            <div class="order-item-image">
                                <img src="/api/placeholder/60/60" alt="Arabica Gayo">
                            </div>
                            <div class="order-item-details">
                                <h4>Arabica Gayo Premium</h4>
                                <p class="order-item-variant">Medium Roast, 200gr</p>
                                <div class="order-item-price">Rp 85.000</div>
                            </div>
                        </div>
                        <div class="order-item">
                            <div class="order-item-image">
                                <img src="/api/placeholder/60/60" alt="Robusta Toraja">
                            </div>
                            <div class="order-item-details">
                                <h4>Robusta Toraja Special</h4>
                                <p class="order-item-variant">Dark Roast, 250gr</p>
                                <div class="order-item-price">Rp 75.000</div>
                            </div>
                        </div>
                    </div>

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

                    <div class="order-summary">
                        <div class="order-summary-item">
                            <span>Subtotal</span>
                            <span>Rp 160.000</span>
                        </div>
                        <div class="order-summary-item">
                            <span>Total</span>
                            <span>Rp 160.000</span>
                        </div>
                    </div>
                </div>
                <div class="order-actions">
                    <button class="btn btn-secondary">Detail Pesanan</button>
                    <button class="btn">Ambil Pesanan</button>
                </div>
            </div>

            <!-- Order Card 2 -->
            <div class="order-card">
                <div class="order-header">
                    <div>
                        <h3>Order #TOHO-2024-002</h3>
                        <p style="color: var(--dark-gray); font-size: 14px;">19 Maret 2024, 10:15</p>
                    </div>
                    <div class="order-status status-completed">
                        <i class="fas fa-check-circle"></i>
                        Selesai
                    </div>
                </div>
                <div class="order-content">
                    <div class="order-items">
                        <div class="order-item">
                            <div class="order-item-image">
                                <img src="/api/placeholder/60/60" alt="TOHO Blend">
                            </div>
                            <div class="order-item-details">
                                <h4>TOHO Signature Blend</h4>
                                <p class="order-item-variant">Medium-Dark Roast, 500gr</p>
                                <div class="order-item-price">Rp 120.000</div>
                            </div>
                        </div>
                    </div>

                    <div class="order-timeline">
                        <div class="timeline-item">
                            <div class="timeline-icon"></div>
                            <div class="timeline-content">
                                <div class="timeline-date">19 Maret 2024, 10:15</div>
                                <div class="timeline-text">Pesanan diterima</div>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-icon"></div>
                            <div class="timeline-content">
                                <div class="timeline-date">19 Maret 2024, 10:20</div>
                                <div class="timeline-text">Pesanan dikonfirmasi</div>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-icon"></div>
                            <div class="timeline-content">
                                <div class="timeline-date">19 Maret 2024, 10:45</div>
                                <div class="timeline-text">Pesanan siap diambil</div>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-icon"></div>
                            <div class="timeline-content">
                                <div class="timeline-date">19 Maret 2024, 11:30</div>
                                <div class="timeline-text">Pesanan diambil</div>
                            </div>
                        </div>
                    </div>

                    <div class="order-summary">
                        <div class="order-summary-item">
                            <span>Subtotal</span>
                            <span>Rp 120.000</span>
                        </div>
                        <div class="order-summary-item">
                            <span>Total</span>
                            <span>Rp 120.000</span>
                        </div>
                    </div>
                </div>
                <div class="order-actions">
                    <button class="btn btn-secondary">Detail Pesanan</button>
                    <button class="btn">Buat Pesanan Serupa</button>
                </div>
            </div>

            <!-- Order Card 3 -->
            <div class="order-card">
                <div class="order-header">
                    <div>
                        <h3>Order #TOHO-2024-003</h3>
                        <p style="color: var(--dark-gray); font-size: 14px;">18 Maret 2024, 16:45</p>
                    </div>
                    <div class="order-status status-cancelled">
                        <i class="fas fa-times-circle"></i>
                        Dibatalkan
                    </div>
                </div>
                <div class="order-content">
                    <div class="order-items">
                        <div class="order-item">
                            <div class="order-item-image">
                                <img src="/api/placeholder/60/60" alt="Pour Over Set">
                            </div>
                            <div class="order-item-details">
                                <h4>Pour Over Set</h4>
                                <p class="order-item-variant">Set Lengkap</p>
                                <div class="order-item-price">Rp 275.000</div>
                            </div>
                        </div>
                    </div>

                    <div class="order-timeline">
                        <div class="timeline-item">
                            <div class="timeline-icon"></div>
                            <div class="timeline-content">
                                <div class="timeline-date">18 Maret 2024, 16:45</div>
                                <div class="timeline-text">Pesanan diterima</div>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-icon"></div>
                            <div class="timeline-content">
                                <div class="timeline-date">18 Maret 2024, 17:00</div>
                                <div class="timeline-text">Pesanan dibatalkan</div>
                            </div>
                        </div>
                    </div>

                    <div class="order-summary">
                        <div class="order-summary-item">
                            <span>Subtotal</span>
                            <span>Rp 275.000</span>
                        </div>
                        <div class="order-summary-item">
                            <span>Total</span>
                            <span>Rp 275.000</span>
                        </div>
                    </div>
                </div>
                <div class="order-actions">
                    <button class="btn btn-secondary">Detail Pesanan</button>
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