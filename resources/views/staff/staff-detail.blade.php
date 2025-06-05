<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Detail Pesanan - TOHO Coffee</title>
    @vite('resources/css/style.css')
</head>
<body>
    <header>
        <div class="navbar">
            <div class="logo">
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
                <img src="{{ asset('images/logo-toho.jpg') }}" alt="Staff Profile">
                <div class="admin-name">Staff TOHO</div> <!-- Menggunakan class yang sudah ada -->
                <div class="admin-role">Barista</div> <!-- Menggunakan class yang sudah ada -->
            </div>

            <ul class="sidebar-menu"> <!-- Menggunakan class yang sudah ada -->
                <li>
                    <a href="{{ route('staff-dashboard') }}" class="active">
                        <i class="fas fa-chart-line"></i>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('staff-manajemen-produk') }}">
                        <i class="fas fa-box"></i>
                        Produk
                    </a>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <main class="main-content">
            <div class="admin-page-header">
                <div class="page-title">
                    <h2>Detail Pesanan {{ $order->orders_code }}</h2>
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
                                <span> {{ $order->orders_code }} </span>
                            </div>
                            <div class="info-item">
                                <label>Tanggal Pesanan:</label>
                                <span>{{ $order->order_date->format('Y-m-d H:i') }}</span>
                            </div>
                            <div class="info-item">
                                <label>Pelanggan:</label>
                                <span>{{ $order->customer_name }}</span>
                            </div>
                            <div class="info-item">
                                <label>Email:</label>
                                <span>{{ $order->customer_email }}</span>
                            </div>
                            <div class="info-item">
                                <label>Telepon:</label>
                                <span>{{ $order->customer_phone }}</span>
                            </div>
                            <div class="info-item">
                                <label>Metode Pembayaran:</label>
                                <span>{{ $order->orderDetails->first()->payment_method ?? 'Transfer Bank' }}</span>
                            </div>
                            <div class="info-item full-width">
                                <label>Lokasi Pengambilan:</label>
                                <span>{{ $order->orderDetails->first()->pickup_place ?? 'TOHO Coffee - Cabang Utama' }}</span>
                            </div>
                        </div>

                        {{-- Order Status Display --}}
                        <div class="order-status-badge {{ $order->status_badge_class }}">
                            <i class="fas fa-check-circle"></i>
                            {{ $order->status_text }}
                        </div>

                        {{-- Status Update Form --}}
                        <div class="status-update-form" style="margin-top: 20px;">
                            <div class="form-group">
                            <form action="{{ route('staff-update-order-status', $order->id_orders) }}" method="POST" style="display: inline;">
                                @csrf
                                <label for="orderStatus">Ubah Status Pesanan:</label>
                                <select name="status" id="orderStatus" class="form-control">
                                    <option value="{{ $order->order_status }}" selected>{{ ucfirst($order->order_status) }} (Saat ini)</option>
                                    @foreach($order->getAvailableStatusTransitions() as $status)
                                        <option value="{{ $status }}">
                                            {{ ucfirst($status) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                                <button type="submit" class="btn btn-primary" onclick="return confirm('Apakah Anda yakin ingin mengubah status pesanan ini?')">
                                    <i class="fas fa-sync-alt"></i> Update Status
                                </button>
                            </form>
                            <a href="{{ route('invoice', $order->id_orders) }}" target="_blank">
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
                            @foreach($order->orderDetails as $detail)
                            <div class="order-item">
                                <div class="item-image">
                                    <img src="{{ asset('images/products/' . ($detail->product_name . '.jpg' ?? 'default-product.jpg')) }}" alt="Product Image">
                                </div>
                                <div class="item-details">
                                    <h4>{{ $detail->product_name }}</h4>
                                    <div class="item-variant">
                                        @if($detail->category_name !== 'N/A')
                                            {{ $detail->category_name }}
                                        @endif
                                        @if($detail->temperature_name !== 'N/A')
                                            , {{ $detail->temperature_name }}
                                        @endif
                                    </div>
                                    <div class="item-price">Rp {{ number_format($detail->product_price, 0, ',', '.') }} x {{ $detail->product_quantity }}</div>
                                </div>
                                <div class="item-subtotal">Rp {{ number_format($detail->product_price * $detail->product_quantity, 0, ',', '.') }}</div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                     <!-- Order Summary -->
                    <div class="order-info-card">
                         <h3>Ringkasan Pesanan</h3>
                        @php
                            $subtotal = $order->orderDetails->sum(function($d) { 
                                return $d->product_price * $d->product_quantity; 
                            });
                            $ppn = $subtotal * 0.1;
                            $total = $subtotal + $ppn;
                        @endphp
                        <div class="order-summary">
                            <div class="summary-item">
                                <span>Subtotal</span>
                                <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="summary-item">
                                <span>PPn 10%</span>
                                <span>Rp {{ number_format($ppn, 0, ',', '.') }}</span>
                            </div>
                            <div class="summary-item summary-total">
                                <span>Total</span>
                                <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="order-details-right">
                    <!-- Order Timeline -->
                    <div class="order-info-card">
                        <h3>Riwayat Status</h3>
                        <div class="order-timeline">
                        @foreach($timeline as $item)
                        <div class="timeline-item">
                            <div class="timeline-icon"></div>
                            <div class="timeline-content">
                                <div class="timeline-date">{{ $item['date'] }}</div>
                                <div class="timeline-text">{{ $item['text'] }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    </div>

                    <div class="order-info-card qr-code-container">
                         <h3>Bukti Transfer</h3>
                        <div class="qr-code">
                            <img src="{{ asset($order->proof_payment) }}" alt="Bukti Transfer">
                            <p>Validasi Bukti Transfer</p>
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