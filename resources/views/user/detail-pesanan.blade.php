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
                    <div class="order-status-badge 
                        @switch($order->order_status)
                            @case('menunggu') status-pending @break
                            @case('diproses') status-processing @break
                            @case('siap') status-ready @break
                            @case('selesai') status-completed @break
                            @case('dibatalkan') status-cancelled @break
                            @default status-pending
                        @endswitch
                    ">
                        @switch($order->order_status)
                            @case('menunggu')
                                <i class="fas fa-clock"></i>
                                Menunggu Konfirmasi
                                @break
                            @case('diproses')
                                <i class="fas fa-cog fa-spin"></i>
                                Diproses
                                @break
                            @case('siap')
                                <i class="fas fa-check-circle"></i>
                                Siap Diambil
                                @break
                            @case('selesai')
                                <i class="fas fa-check-circle"></i>
                                Selesai
                                @break
                            @case('dibatalkan')
                                <i class="fas fa-times-circle"></i>
                                Dibatalkan
                                @break
                        @endswitch
                    </div>
                    <div class="info-grid">
                        <div class="info-item">
                            <label>Nomor Pesanan</label>
                            <span>#{{ $order->orders_code }}</span>
                        </div>
                        <div class="info-item">
                            <label>Tanggal Pesanan</label>
                            <span>{{ $order->order_date->format('d F Y, H:i') }}</span>
                        </div>
                        @if($order->orderDetails->first())
                        <div class="info-item">
                            <label>Metode Pengambilan</label>
                            <span>{{ ucfirst($order->orderDetails->first()->pickup_method ?? 'Pickup di Toko') }}</span>
                        </div>
                        <div class="info-item">
                            <label>Lokasi Pengambilan</label>
                            <span>{{ $order->orderDetails->first()->pickup_place ?? 'TOHO Coffee - Cabang Utama' }}</span>
                        </div>
                        <div class="info-item">
                            <label>Waktu Pengambilan</label>
                            <span>{{ $order->orderDetails->first()->pickup_time ? \Carbon\Carbon::parse($order->orderDetails->first()->pickup_time)->format('d F Y, H:i') : 'Belum ditentukan' }}</span>
                        </div>
                        <div class="info-item">
                            <label>Status Pembayaran</label>
                            <span>{{ ucfirst($order->orderDetails->first()->payment_status ?? 'Belum Lunas') }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Order Timeline -->
                <div class="order-info-card">
                    <h3>Status Pesanan</h3>
                    <div class="order-timeline">
                        <div class="timeline-item">
                            <div class="timeline-icon"></div>
                            <div class="timeline-content">
                                <div class="timeline-date">{{ $order->order_date->format('d F Y, H:i') }}</div>
                                <div class="timeline-text">Pesanan diterima</div>
                            </div>
                        </div>
                        
                        @if(in_array($order->order_status, ['diproses', 'siap', 'selesai']))
                        <div class="timeline-item">
                            <div class="timeline-icon"></div>
                            <div class="timeline-content">
                                <div class="timeline-date">{{ $order->order_date->addMinutes(5)->format('d F Y, H:i') }}</div>
                                <div class="timeline-text">Pesanan dikonfirmasi</div>
                            </div>
                        </div>
                        @endif
                        
                        @if(in_array($order->order_status, ['siap', 'selesai']))
                        <div class="timeline-item">
                            <div class="timeline-icon"></div>
                            <div class="timeline-content">
                                <div class="timeline-date">{{ $order->order_date->addMinutes(25)->format('d F Y, H:i') }}</div>
                                <div class="timeline-text">Pesanan siap diambil</div>
                            </div>
                        </div>
                        @endif
                        
                        @if($order->order_status === 'selesai' && $order->order_complete)
                        <div class="timeline-item">
                            <div class="timeline-icon"></div>
                            <div class="timeline-content">
                                <div class="timeline-date">{{ $order->order_complete->format('d F Y, H:i') }}</div>
                                <div class="timeline-text">Pesanan diambil</div>
                            </div>
                        </div>
                        @endif
                        
                        @if($order->order_status === 'dibatalkan')
                        <div class="timeline-item">
                            <div class="timeline-icon"></div>
                            <div class="timeline-content">
                                <div class="timeline-date">{{ $order->order_date->addMinutes(15)->format('d F Y, H:i') }}</div>
                                <div class="timeline-text">Pesanan dibatalkan</div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Order Items -->
                <div class="order-info-card">
                    <h3>Detail Pesanan</h3>
                    <div class="order-items-list">
                        @foreach($order->orderDetails as $detail)
                        <div class="order-item">
                            <div class="item-image">
                                @if($detail->product_photo)
                                    <img src="{{ asset('images/products/' . $detail->product_name . '.jpg') }}" 
                                        alt="{{ $detail->product_name ?? 'Product' }}">
                                @else
                                    <img src="{{ asset('images/default-product.jpg') }}" 
                                        alt="Default Product Image">
                                @endif
                            </div>
                            <div class="item-details">
                                <h4>{{ $detail->product_name ?? 'Produk Tidak Tersedia' }}</h4>
                                <p class="item-variant">
                                    {{ $detail->category_name ?? 'Kategori' }} - 
                                    {{ $detail->temperature_name ?? 'Temperature' }}
                                    @if($detail->product_quantity >= 1)
                                        , {{ $detail->product_quantity }}x
                                    @endif
                                </p>
                                <div class="item-price">Rp {{ number_format($detail->product_price, 0, ',', '.') }}</div>
                                
                                @if($detail->product_description)
                                <p class="item-description" style="font-size: 12px; color: var(--dark-gray); margin-top: 5px;">
                                    {{ Str::limit($detail->product_description, 100) }}
                                </p>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="order-summary">
                        @php
                            $subtotal = $order->orderDetails->sum(function($detail) {
                                return $detail->product_price * $detail->product_quantity;
                            });
                            $tax = $subtotal * 0.1;
                        @endphp
                        <div class="summary-item">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="summary-item">
                            <span>PPn 10%</span>
                            <span>Rp {{ number_format($tax, 0, ',', '.') }}</span>
                        </div>
                        <div class="summary-total">
                            <span>Total</span>
                            <span>Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="order-actions">
                        <a href="{{ route('user-riwayat') }}">
                            <button class="btn btn-secondary">Kembali</button>
                        </a>
                        @if($order->order_status === 'siap')
                            <form action="{{ route('user-ambil-pesanan', $order->id_orders) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('POST')
                                <button type="submit" class="btn" onclick="return confirm('Konfirmasi bahwa Anda telah mengambil pesanan ini?')">Ambil Pesanan</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="order-detail-sidebar">
                
                <!-- Customer Info -->
                <div class="order-info-card">
                    <h3>Informasi Pelanggan</h3>
                    @if($order->orderDetails->first())
                    <div class="info-item">
                        <label>Nama</label>
                        <span>{{ $order->member_name ?? Auth::user()->name }}</span>
                    </div>
                    <div class="info-item">
                        <label>Email</label>
                        <span>{{ $order->orderDetails->first()->pickup_email ?? Auth::user()->email }}</span>
                    </div>
                    <div class="info-item">
                        <label>Nomor Telepon</label>
                        <span>{{ $order->orderDetails->first()->pickup_telephone ?? 'Tidak tersedia' }}</span>
                    </div>
                    @if($order->member_notes)
                    <div class="info-item">
                        <label>Catatan</label>
                        <span>{{ $order->member_notes }}</span>
                    </div>
                    @endif
                    @endif
                </div>
                
                <!-- Payment Info -->
                <div class="order-info-card">
                    <h3>Informasi Pembayaran</h3>
                    @if($order->orderDetails->first())
                    <div class="info-item">
                        <label>Metode Pembayaran</label>
                        <span>{{ ucfirst($order->orderDetails->first()->payment_method ?? 'Transfer Bank') }}</span>
                    </div>
                    <div class="info-item">
                        <label>Nomor Rekening</label>
                        <span>{{ $order->orderDetails->first()->bank_number ?? 'Tidak tersedia' }}</span>
                    </div>
                    <div class="info-item">
                        <label>Status Pembayaran</label>
                        <span>{{ ucfirst($order->orderDetails->first()->payment_status ?? 'Belum Lunas') }}</span>
                    </div>
                    <div class="info-item">
                        <label>Tanggal Pembayaran</label>
                        <span>{{ $order->order_date->format('d F Y, H:i') }}</span>
                    </div>
                    @if($order->member_bank)
                    <div class="info-item">
                        <label>Bank</label>
                        <span>{{ $order->member_bank }}</span>
                    </div>
                    @endif
                    @endif
                </div>

                <div class="qr-code">
                    @if($order->proof_payment)
                        <img src="{{ asset($order->proof_payment) }}" alt="Bukti Transfer">
                        <p>Bukti Transfer</p>
                    @else
                        <div style="padding: 20px; text-align: center; color: var(--dark-gray);">
                            <i class="fas fa-receipt" style="font-size: 2rem; margin-bottom: 10px;"></i>
                            <p>Bukti pembayaran tidak tersedia</p>
                        </div>
                    @endif
                    
                    <a href="{{ route('invoice', $order->id_orders) }}">
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