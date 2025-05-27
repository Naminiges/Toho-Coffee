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
                <img src="{{ asset('images/logo-toho.jpg') }}" alt="Toho Coffee Logo">
                <h1>TOHO Coffee</h1>
            </div>
            <ul class="nav-links">
                <li><a href="{{ route('welcome') }}">Beranda</a></li>
                <li><a href="{{ route('user-katalog') }}">Katalog</a></li>
                <li><a href="{{ route('user-riwayat') }}">Riwayat</a></li>
            </ul>
            <div class="nav-actions">
                    <!-- User Menu Dropdown -->
                    <div class="cart-icon">
                        <a href="{{ route('user-keranjang') }}" style="text-decoration : none;">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="cart-count">0</span>
                        </a>
                    </div>
                    <div class="user-menu">
                        <div class="user-trigger" onclick="toggleUserMenu()">
                            <div class="user-avatar">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <div class="user-info">
                                <span class="user-name">{{ Auth::user()->name }}</span>
                                <span class="user-email">{{ Auth::user()->email }}</span>
                            </div>
                            <i class="fas fa-chevron-down dropdown-arrow"></i>
                        </div>
                        <div class="user-dropdown" id="userDropdown">
                            <div class="dropdown-header">
                                <div class="user-avatar-large">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <div class="user-details">
                                    <div class="user-name-large">{{ Auth::user()->name }}</div>
                                    <div class="user-email-small">{{ Auth::user()->email }}</div>
                                </div>
                            </div>
                            <div class="dropdown-divider"></div>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="{{ route('profile') }}" class="dropdown-item">
                                        <i class="fas fa-user"></i>
                                        <span>Profile Saya</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('user-keranjang') }}" class="dropdown-item">
                                        <i class="fas fa-shopping-bag"></i>
                                        <span>Pesanan Saya</span>
                                    </a>
                                </li>
                            </ul>
                            <div class="dropdown-divider"></div>
                            <div class="dropdown-footer">
                                <button onclick="confirmLogout()" class="logout-btn">
                                    <i class="fas fa-sign-out-alt"></i>
                                    <span>Keluar</span>
                                </button>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="hamburger">
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
    </header>

    <!-- Logout Confirmation Modal -->
    <div class="modal-overlay" id="logoutModal" style="display: none;">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Konfirmasi Logout</h3>
                <button class="modal-close" onclick="closeLogoutModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="modal-icon">
                    <i class="fas fa-sign-out-alt"></i>
                </div>
                <p>Apakah Anda yakin ingin keluar dari akun Anda?</p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="closeLogoutModal()">Batal</button>
                <button class="btn btn-danger" onclick="performLogout()" id="confirmLogoutBtn">
                    <span class="btn-text">Ya, Keluar</span>
                    <span class="btn-loader" style="display: none;">
                        <i class="fas fa-spinner fa-spin"></i> Memproses...
                    </span>
                </button>
            </div>
        </div>
    </div>

    <!-- Success/Error Alert -->
    <div class="alert-container" id="alertContainer" style="display: none;">
        <div class="alert" id="alertMessage">
            <i class="alert-icon"></i>
            <span class="alert-text"></span>
        </div>
    </div>

    <!-- Page Header -->
    <div class="page-header">
        <h2>Detail Pesanan</h2>
    </div>

    <div class="container">
        <!-- Breadcrumb -->
        <ul class="breadcrumb">
            <li><a href="{{ route('welcome') }}">Beranda</a></li>
            <li><a href="{{ route('user-riwayat') }}">Riwayat Pesanan</a></li>
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
                                <img src="{{ asset('images/kopi1.jpg') }}" alt="Arabica Gayo">
                            </div>
                            <div class="item-details">
                                <h4>Arabica Gayo Premium</h4>
                                <p class="item-variant">Medium Roast, 200gr</p>
                                <div class="item-price">Rp 85.000</div>
                            </div>
                        </div>
                        <div class="order-item">
                            <div class="item-image">
                                <img src="{{ asset('images/kopi2.jpg') }}" alt="Robusta Toraja">
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
                            <span>PPn 10%</span>
                            <span>Rp 1.600</span>
                        </div>
                        <div class="summary-total">
                            <span>Total</span>
                            <span>Rp 161.600</span>
                        </div>
                    </div>

                    <div class="order-actions">
                        <a href="{{ route('user-riwayat') }}">
                            <button class="btn btn-secondary">Kembali</button>
                        </a>
                        <button class="btn">Ambil Pesanan</button>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="order-detail-sidebar">
                
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
                
                <div class="qr-code">
                    <img src="" alt="Bukti Transfer">
                    <p>Bukti Transfer</p>
                    
                    <a href="{{ route('invoice') }}">
                        <button class="btn btn-secondary">
                            <i class="fas fa-print"></i> Print Invoice
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <a href="#" class="back-to-top">
        <i class="fas fa-arrow-up"></i>
    </a>

    @vite('resources/js/script.js')

    <script>
        // Setup CSRF token for AJAX requests
        window.Laravel = {
            csrfToken: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        };

        // User Menu Functions
        function toggleUserMenu() {
            const dropdown = document.getElementById('userDropdown');
            const trigger = document.querySelector('.user-trigger');
            const arrow = document.querySelector('.dropdown-arrow');
            
            dropdown.classList.toggle('show');
            trigger.classList.toggle('active');
            
            if (dropdown.classList.contains('show')) {
                arrow.style.transform = 'rotate(180deg)';
            } else {
                arrow.style.transform = 'rotate(0deg)';
            }
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const userMenu = document.querySelector('.user-menu');
            const dropdown = document.getElementById('userDropdown');
            
            if (userMenu && !userMenu.contains(event.target)) {
                dropdown.classList.remove('show');
                document.querySelector('.user-trigger').classList.remove('active');
                document.querySelector('.dropdown-arrow').style.transform = 'rotate(0deg)';
            }
        });

        // Logout Functions
        function confirmLogout() {
            document.getElementById('logoutModal').style.display = 'flex';
            // Close user dropdown
            document.getElementById('userDropdown').classList.remove('show');
            document.querySelector('.user-trigger').classList.remove('active');
            document.querySelector('.dropdown-arrow').style.transform = 'rotate(0deg)';
        }

        function closeLogoutModal() {
            document.getElementById('logoutModal').style.display = 'none';
        }

        function performLogout() {
            const confirmBtn = document.getElementById('confirmLogoutBtn');
            const btnText = confirmBtn.querySelector('.btn-text');
            const btnLoader = confirmBtn.querySelector('.btn-loader');
            
            // Show loading state
            btnText.style.display = 'none';
            btnLoader.style.display = 'inline-block';
            confirmBtn.disabled = true;
            
            // Create form for logout
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("logout") }}';
            
            // Add CSRF token
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = window.Laravel.csrfToken;
            form.appendChild(csrfInput);
            
            // Add to DOM and submit
            document.body.appendChild(form);
            form.submit();
        }

        // Alert Functions
        function showAlert(type, message) {
            const alertContainer = document.getElementById('alertContainer');
            const alertMessage = document.getElementById('alertMessage');
            const alertIcon = alertMessage.querySelector('.alert-icon');
            const alertText = alertMessage.querySelector('.alert-text');
            
            // Set alert content
            alertText.textContent = message;
            alertMessage.className = `alert alert-${type}`;
            
            // Set icon based on type
            if (type === 'success') {
                alertIcon.className = 'alert-icon fas fa-check-circle';
            } else if (type === 'error') {
                alertIcon.className = 'alert-icon fas fa-exclamation-circle';
            } else if (type === 'warning') {
                alertIcon.className = 'alert-icon fas fa-exclamation-triangle';
            }
            
            // Show alert
            alertContainer.style.display = 'flex';
            
            // Auto hide after 5 seconds
            setTimeout(() => {
                alertContainer.style.display = 'none';
            }, 5000);
        }

        // Show success message if exists
        @if(session('success'))
            showAlert('success', '{{ session("success") }}');
        @endif

        // Show error message if exists
        @if(session('error'))
            showAlert('error', '{{ session("error") }}');
        @endif

        // Close alert when clicking on it
        document.getElementById('alertContainer').addEventListener('click', function() {
            this.style.display = 'none';
        });

        // Prevent modal from closing when clicking inside modal content
        document.querySelector('.modal-content').addEventListener('click', function(e) {
            e.stopPropagation();
        });

        // Close modal when clicking on overlay
        document.getElementById('logoutModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeLogoutModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeLogoutModal();
            }
        });
    </script>
</body>
</html>