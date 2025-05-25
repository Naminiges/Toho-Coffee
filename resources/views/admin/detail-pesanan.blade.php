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
                <img src="{{ asset('images/logo-toho.jpg') }}" alt="TOHO Coffee Logo">
                <h1>TOHO Coffee</h1>
            </div>
            <div class="nav-actions">
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

    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar"> <!-- Menggunakan class yang sudah ada -->
            <div class="sidebar-header"> <!-- Menggunakan class yang sudah ada -->
                <img src="{{ asset('images/logo-toho.jpg') }}" alt="Admin Profile">
                <div class="admin-name">Admin TOHO</div> <!-- Menggunakan class yang sudah ada -->
                <div class="admin-role">Administrator</div> <!-- Menggunakan class yang sudah ada -->
            </div>

            <ul class="sidebar-menu">
                <li>
                    <a href="{{ route('admin-dashboard') }}">
                        <i class="fas fa-chart-line"></i>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin-manajemen-pesanan') }}" class="active">
                        <i class="fas fa-shopping-bag"></i>
                        Pesanan
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin-manajemen-produk') }}">
                        <i class="fas fa-box"></i>
                        Produk
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin-manajemen-pelanggan') }}">
                        <i class="fas fa-users"></i>
                        Pelanggan
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin-manajemen-staff') }}">
                        <i class="fas fa-certificate"></i>
                        Staff
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin-laporan') }}">
                        <i class="fas fa-chart-pie"></i>
                        Laporan
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
                                <input type="hidden" value=""> 
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
                            <a href="{{ route('invoice') }}">
                                <button class="btn btn-secondary">
                                    <i class="fas fa-print"></i> Print Invoice
                                </button>
                            </a>
                        </div>
                    </div>

                     <!-- Order Items List -->
                    <div class="order-info-card">
                        <h3>Item Pesanan</h3>
                        <div class="order-items-list">
                            <div class="order-item">
                                <div class="item-image">
                                    <img src="{{ asset('images/kopi1.jpg') }}" alt="Product Image">
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
                                    <img src="{{ asset('images/kopi2.jpg') }}" alt="Product Image">
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
                            <img src="" alt="QR Code">
                            <p>Scan QR code untuk verifikasi pesanan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

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