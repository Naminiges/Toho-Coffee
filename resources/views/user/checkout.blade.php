<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Checkout - TOHO Coffee</title>
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
        <h2>Checkout</h2>
    </div>

    <div class="container">
        <!-- Breadcrumb -->
        <ul class="breadcrumb">
            <li><a href="{{ route('welcome') }}">Beranda</a></li>
            <li><a href="{{ route('user-keranjang') }}">Keranjang</a></li>
            <li>Checkout</li>
        </ul>

        <div class="cart-container">
            <!-- Checkout Form Section -->
            <div class="cart-items">
                <h3>Informasi Pesanan</h3>
                
                <form id="checkoutForm" action="{{ route('user-checkout-process') }}" method="POST" enctype="multipart/form-data" class="checkout-form">
                @csrf
                
                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ old('name', Auth::user()->name) }}" required>
                    @error('name')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="phone">Nomor Telepon</label>
                    <input type="tel" id="phone" name="phone" class="form-control" value="{{ old('phone', Auth::user()->user_phone) }}" required>
                    @error('phone')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email', Auth::user()->email) }}" required>
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="member_bank">Nama Bank Customer</label>
                    <select id="member_bank" name="member_bank" class="form-control" required>
                        <option value="">Pilih Bank/E-Wallet</option>
                        <optgroup label="Bank">
                            <option value="BRI" {{ old('member_bank') == 'BRI' ? 'selected' : '' }}>BRI</option>
                            <option value="Bank Mega" {{ old('member_bank') == 'Bank Mega' ? 'selected' : '' }}>Bank Mega</option>
                            <option value="CIMB Niaga" {{ old('member_bank') == 'CIMB Niaga' ? 'selected' : '' }}>CIMB Niaga</option>
                            <option value="Bank Mandiri" {{ old('member_bank') == 'Bank Mandiri' ? 'selected' : '' }}>Bank Mandiri</option>
                            <option value="BNI" {{ old('member_bank') == 'BNI' ? 'selected' : '' }}>BNI</option>
                            <option value="BCA" {{ old('member_bank') == 'BCA' ? 'selected' : '' }}>BCA</option>
                            <option value="Bank Sinarmas" {{ old('member_bank') == 'Bank Sinarmas' ? 'selected' : '' }}>Bank Sinarmas</option>
                            <option value="Bank Permata" {{ old('member_bank') == 'Bank Permata' ? 'selected' : '' }}>Bank Permata</option>
                            <option value="Danamon" {{ old('member_bank') == 'Danamon' ? 'selected' : '' }}>Danamon</option>
                        </optgroup>
                        <optgroup label="E-Wallet">
                            <option value="OVO" {{ old('member_bank') == 'OVO' ? 'selected' : '' }}>OVO</option>
                            <option value="DANA" {{ old('member_bank') == 'DANA' ? 'selected' : '' }}>DANA</option>
                            <option value="GOPAY" {{ old('member_bank') == 'GOPAY' ? 'selected' : '' }}>GOPAY</option>
                        </optgroup>
                    </select>
                    @error('member_bank')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="bank_number">Nomor Rekening Customer</label>
                    <input type="text" id="bank_number" name="bank_number" class="form-control" required>
                    @error('bank_number')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Metode Pengambilan</label>
                    <div class="pickup-options">
                        <div class="pickup-option">
                            <input type="radio" id="pickup1" name="pickup" value="pickup1" checked>
                            <label for="pickup1">
                                <strong>TOHO Coffee - Cabang Utama</strong><br>
                                Universitas Sumatera Utara, Medan<br>
                                Buka: 08:00 - 17:00
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="pickup_time">Waktu Pengambilan</label>
                    <input type="datetime-local" id="pickup_time" name="pickup_time" class="form-control"
                        value="{{ old('pickup_time') }}" required>
                    @error('pickup_time')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="transfer_proof">Bukti Transfer</label>
                    <input type="file" id="transfer_proof" name="transfer_proof" class="form-control" accept="image/*" required>
                    <small class="form-text">Upload bukti transfer dalam format JPG (maksimal 2MB)</small>
                    @error('transfer_proof')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="notes">Catatan (Opsional)</label>
                    <textarea id="notes" name="notes" class="form-control" rows="3" 
                            placeholder="Tambahkan catatan khusus untuk pesanan Anda">{{ old('notes') }}</textarea>
                    @error('notes')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="cart-actions">
                    <div class="continue-shopping">
                        <a href="{{ route('user-keranjang') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali ke Keranjang
                        </a>
                    </div>
                </div>
            </form>
            </div>

            <!-- Order Summary -->
            <div class="cart-summary">
                <div class="cart-summary">
                    <h3>Ringkasan Pesanan</h3>
                    
                    @foreach ($cartItems as $item)
                        <div class="cart-item">
                            <div class="item-image">
                                <img src="{{ asset('images/products/' . $item->product->product_name . '.jpg') }}" 
                                    alt="{{ $item->product->product_name }}"
                                    onerror="this.src='{{ asset('images/products/default.jpg') }}'">
                            </div>
                            <div class="item-details">
                                <h4>{{ $item->product->product_name }}
                                @if($item->product->temperatureType)
                                    ({{ $item->product->temperatureType->temperature }})
                                @endif
                                </h4>
                                <div class="item-quantity">Qty: {{ $item->item_quantity }}</div>
                                <div class="item-price">Rp {{ number_format($item->product->product_price, 0, ',', '.') }}</div>
                            </div>
                        </div>
                    @endforeach
                    
                    <div class="summary-item">
                        <span>Subtotal</span>
                        <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    
                    <div class="summary-item">
                        <span>PPn 10%</span>
                        <span>Rp {{ number_format($ppn, 0, ',', '.') }}</span>
                    </div>
                    
                    <div class="summary-total">
                        <span>Total</span>
                        <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    
                    <button id="orderBtn" type="submit" form="checkoutForm" class="btn btn-block">Buat Pesanan</button>
                    
                    <div class="secure-checkout">
                        <i class="fas fa-lock"></i> Pembayaran Aman & Terenkripsi
                    </div>
                    
                    <div class="payment-methods">
                        <span>Metode Pembayaran:</span>
                        <div class="payment-icons">
                            <i class="fas fa-wallet"></i>
                        </div>
                    </div>
                </div>
                <div class="qr-code">
                    <h3>Rekening TOHO Coffee</h3>
                    <h4 style="text-align: left">Nama: TOHO COFFEE 01</h4>
                    <h4 style="text-align: left">Bank: BNI</h4>
                    <h4 style="text-align: left">Nomor Rekening: 1858161668</h4>
                </div>
                <div class="qr-code">
                    <h3>QRIS</h3>
                    <img src="{{ asset('images/qris/qris-toho.png') }}" style="width: 100%; height: 100%;" alt="QRIS">
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

        function setTimeRestrictions() {
            const timeInput = document.getElementById('pickup_time');
            const orderBtn = document.getElementById('orderBtn');
            const now = new Date();
            const currentHour = now.getHours();
            
            // Fungsi format datetime untuk input
            function formatDateTime(date) {
                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                const hours = String(date.getHours()).padStart(2, '0');
                const minutes = String(date.getMinutes()).padStart(2, '0');
                return `${year}-${month}-${day}T${hours}:${minutes}`;
            }
            
            // Jika sudah lewat jam 17:00, disable untuk hari ini
            if (currentHour >= 17) {
                // Set minimum ke hari berikutnya jam 8:00
                const tomorrow = new Date();
                tomorrow.setDate(tomorrow.getDate() + 1);
                tomorrow.setHours(8, 0, 0, 0);
                timeInput.min = formatDateTime(tomorrow);
            } else if (currentHour < 8) {
                // Jika sebelum jam 8:00, set minimum ke jam 8:00 hari ini
                const today8AM = new Date();
                today8AM.setHours(8, 0, 0, 0);
                timeInput.min = formatDateTime(today8AM);
            } else {
                // Jika dalam jam operasional, set minimum ke waktu sekarang
                timeInput.min = formatDateTime(now);
            }
            
            // Set maksimum ke jam 17:00 hari ini (atau besok jika sudah lewat jam 17)
            const maxDate = new Date();
            if (currentHour >= 17) {
                maxDate.setDate(maxDate.getDate() + 1);
            }
            maxDate.setHours(17, 0, 0, 0);
            timeInput.max = formatDateTime(maxDate);
            
            // Validasi saat input berubah
            timeInput.addEventListener('change', function() {
                const selectedDateTime = new Date(this.value);
                const selectedHour = selectedDateTime.getHours();
                const today = new Date().toDateString();
                const selectedDate = selectedDateTime.toDateString();
                
                // Validasi jam operasional (8:00 - 17:00)
                if (selectedHour < 8 || selectedHour >= 17) {
                    showAlert('error', 'Waktu pengambilan hanya tersedia jam 08:00 - 17:00');
                    this.value = '';
                    return;
                }
                
                // Jika hari ini, validasi tidak boleh kurang dari waktu sekarang
                if (selectedDate === today && selectedDateTime < now) {
                    showAlert('error', 'Waktu tidak boleh kurang dari waktu saat ini');
                    this.value = '';
                    return;
                }
            });
        }

        // Panggil fungsi dan update setiap menit
        setTimeRestrictions();
        setInterval(setTimeRestrictions, 60000);
    </script>
</body>
</html>