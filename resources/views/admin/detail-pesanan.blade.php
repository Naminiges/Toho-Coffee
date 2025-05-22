<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan - Toho Coffee</title>
    @vite('resources/css/style.css')
</head>
<body>
    <header>
        <div class="navbar"> <!-- Menggunakan class yang sudah ada -->
            <div class="logo"> <!-- Menggunakan class yang sudah ada -->
                <img src="/api/placeholder/40/40" alt="TOHO Coffee Logo">
                <h1>TOHO Coffee</h1>
            </div>
            <div class="nav-actions">
                <i class="fas fa-user"></i>
            </div>
        </div>
    </header>

    <div class="dashboard-container">
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
                    <a href="#" class="active">
                        <i class="fas fa-shopping-bag"></i>
                        Pesanan
                    </a>
                </li>
                <li>
                    <a href="#">
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
        <main class="main-content">
            <div class="admin-page-header">
                <div class="page-title">
                    <h2>Detail Pesanan #ORD001</h2>
                </div>
            </div>

            <div class="order-detail-container">
                <div class="order-details-left">
                    <!-- Order Info Card -->
                    <div class="order-info-card">
                        <h3>Informasi Pesanan</h3>
                        <div class="info-grid">
                            <div class="info-item">
                                <label>ID Pesanan:</label>
                                <span>#ORD001</span>
                            </div>
                            <div class="info-item">
                                <label>Tanggal Pesanan:</label>
                                <span>2024-03-20 14:30</span>
                            </div>
                            <div class="info-item">
                                <label>Pelanggan:</label>
                                <span>John Doe</span>
                            </div>
                            <div class="info-item">
                                <label>Email:</label>
                                <span>john.doe@example.com</span>
                            </div>
                            <div class="info-item">
                                <label>Telepon:</label>
                                <span>+62 812 3456 7890</span>
                            </div>
                            <div class="info-item">
                                <label>Metode Pembayaran:</label>
                                <span>Transfer Bank</span>
                            </div>
                            <div class="info-item full-width">
                                <label>Alamat Pengiriman:</label>
                                <span>Jalan Contoh No. 123, Kota Fiktif, Provinsi Antah Berantah, 12345</span>
                            </div>
                        </div>

                        {{-- Order Status Display --}}
                        <div class="order-status-badge status-completed">
                            <i class="fas fa-check-circle"></i> Selesai
                        </div>

                        {{-- Status Update Form --}}
                        <div class="status-update-form" style="margin-top: 20px;"> {{-- Added margin-top for spacing --}}
                            <div class="form-group">
                                <label for="orderStatus">Ubah Status Pesanan:</label>
                                <select id="orderStatus" class="form-control">
                                    <option value="pending">Menunggu</option>
                                    <option value="processing">Diproses</option>
                                    <option value="ready">Siap</option>
                                    <option value="completed" selected>Selesai</option> {{-- Set the current status as selected --}}
                                    <option value="cancelled">Dibatalkan</option>
                                </select>
                            </div>
                            <button class="btn btn-primary" onclick="updateOrderStatusDetail('ORD001')">
                                <i class="fas fa-sync-alt"></i> Update Status
                            </button>
                            <button class="btn btn-secondary">
                                <i class="fas fa-print"></i> Print Invoice
                            </button>
                        </div>
                    </div>

                     <!-- Order Items List -->
                    <div class="order-info-card">
                        <h3>Item Pesanan</h3>
                        <div class="order-items-list">
                            <div class="order-item">
                                <div class="item-image">
                                    <img src="/api/placeholder/80/80" alt="Product Image">
                                </div>
                                <div class="item-details">
                                    <h4>Kopi Arabika Single Origin</h4>
                                    <div class="item-variant">Variant: 250g, Roast: Medium</div>
                                    <div class="item-price">Rp 50.000 x 2</div>
                                </div>
                                <div class="item-subtotal">Rp 100.000</div>
                            </div>
                             <div class="order-item">
                                <div class="item-image">
                                    <img src="/api/placeholder/80/80" alt="Product Image">
                                </div>
                                <div class="item-details">
                                    <h4>Pastry Cokelat</h4>
                                    <div class="item-variant">Qty: 3</div>
                                    <div class="item-price">Rp 15.000 x 3</div>
                                </div>
                                <div class="item-subtotal">Rp 45.000</div>
                            </div>
                            <!-- More items can be added here -->
                        </div>
                    </div>

                     <!-- Order Summary -->
                    <div class="order-info-card">
                         <h3>Ringkasan Pesanan</h3>
                        <div class="order-summary">
                            <div class="summary-item">
                                <span>Subtotal</span>
                                <span>Rp 145.000</span>
                            </div>
                            <div class="summary-item">
                                <span>Ongkos Kirim</span>
                                <span>Rp 5.000</span>
                            </div>
                            <div class="summary-item summary-total">
                                <span>Total</span>
                                <span>Rp 150.000</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="order-details-right">
                    <!-- Order Timeline -->
                    <div class="order-info-card">
                        <h3>Riwayat Status</h3>
                        <div class="order-timeline">
                            <div class="timeline-item">
                                <div class="timeline-icon"></div>
                                <div class="timeline-content">
                                    <div class="timeline-date">2024-03-20 14:30</div>
                                    <div class="timeline-text">Pesanan Dibuat</div>
                                </div>
                            </div>
                            <div class="timeline-item">
                                 <div class="timeline-icon"></div>
                                <div class="timeline-content">
                                    <div class="timeline-date">2024-03-20 14:35</div>
                                    <div class="timeline-text">Pembayaran Dikonfirmasi</div>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-icon"></div>
                                <div class="timeline-content">
                                    <div class="timeline-date">2024-03-20 15:00</div>
                                    <div class="timeline-text">Pesanan Diproses</div>
                                </div>
                            </div>
                             <div class="timeline-item">
                                <div class="timeline-icon"></div>
                                <div class="timeline-content">
                                    <div class="timeline-date">2024-03-20 16:00</div>
                                    <div class="timeline-text">Pesanan Siap Diambil/Dikirim</div>
                                </div>
                            </div>
                             <div class="timeline-item">
                                <div class="timeline-icon"></div>
                                <div class="timeline-content">
                                    <div class="timeline-date">2024-03-20 17:30</div>
                                    <div class="timeline-text">Pesanan Selesai</div>
                                </div>
                            </div>
                            <!-- More timeline items can be added here -->
                        </div>
                    </div>

                     <!-- QR Code -->
                    <div class="order-info-card qr-code-container">
                         <h3>Kode QR Pesanan</h3>
                        <div class="qr-code">
                            <img src="/api/placeholder/150/150" alt="QR Code">
                            <p>Scan QR code untuk verifikasi pesanan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    @vite('resources/js/script.js')
</body>
</html>