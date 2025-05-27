<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan - TOHO Coffee</title>
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
        <h2>Riwayat Pesanan</h2>
    </div>

    <div class="container">
        <!-- Breadcrumb -->
        <ul class="breadcrumb">
            <li><a href="{{ route('welcome') }}">Beranda</a></li>
            <li>Riwayat Pesanan</li>
        </ul>

        <!-- Filter Section -->
        <div class="filter-section" style="justify-content: flex-start;">
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
                                <img src="{{ asset('images/kopi1.jpg') }}" alt="Arabica Gayo">
                            </div>
                            <div class="order-item-details">
                                <h4>Arabica Gayo Premium</h4>
                                <p class="order-item-variant">Medium Roast, 200gr</p>
                                <div class="order-item-price">Rp 85.000</div>
                            </div>
                        </div>
                        <div class="order-item">
                            <div class="order-item-image">
                                <img src="{{ asset('images/kopi2.jpg') }}" alt="Robusta Toraja">
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
                    <a href=" {{ route('user-detail-pesanan') }}" style="text-decoration : none;">
                        <button class="btn btn-secondary">Detail Pesanan</button>
                    </a>
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
                                <img src="{{ asset('images/kopi3.jpg') }}" alt="TOHO Blend">
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
                    <a href=" {{ route('user-detail-pesanan') }}" style="text-decoration : none;">
                        <button class="btn btn-secondary">Detail Pesanan</button>
                    </a>
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
                                <img src="{{ asset('images/kopi4.jpg') }}" alt="Pour Over Set">
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
                    <a href=" {{ route('user-detail-pesanan') }}" style="text-decoration : none;">
                        <button class="btn btn-secondary">Detail Pesanan</button>
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