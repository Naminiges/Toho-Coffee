<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laporan Penjualan - TOHO Coffee</title>
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
        <div class="sidebar">
            <div class="sidebar-header">
                <img src="{{ asset('images/logo-toho.jpg') }}" alt="Admin Profile">
                <div class="admin-name">Admin TOHO</div>
                <div class="admin-role">Administrator</div>
            </div>

            <ul class="sidebar-menu">
                <li>
                    <a href="{{ route('admin-dashboard') }}">
                        <i class="fas fa-chart-line"></i>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin-manajemen-pesanan') }}">
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
                    <a href="{{ route('admin-laporan') }}" class="active">
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
                    <h2>Laporan Penjualan</h2>
                </div>
                <div class="header-actions">
                    <a href="{{ route('admin-laporan-print') }}?start_date={{ $startDate ?? '' }}&end_date={{ $endDate ?? '' }}" 
                    class="btn btn-primary">
                        <i class="fas fa-print"></i> Cetak Laporan
                    </a>
                </div>
            </div>

            <!-- Date Range Filter -->
            <form action="{{ route('admin-laporan-filter') }}" method="GET" class="filter-container report-filter">
                <div class="date-input-group">
                    <input type="date" name="start_date" id="startDate" class="form-control" value="{{ $startDate ?? '' }}">
                    <span>sampai</span>
                    <input type="date" name="end_date" id="endDate" class="form-control" value="{{ $endDate ?? '' }}">
                </div>
                <button type="submit" class="btn btn-primary filter-button">
                    <i class="fas fa-filter"></i> Filter
                </button>
            </form>

            <!-- Summary Cards -->
            <div class="summary-cards">
                <div class="card summary-card"> {{-- Added summary-card class --}}
                    <div class="card-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="card-info">
                        <h3>Total Pesanan</h3>
                        <h3>{{ $totalPenjualan }}</h3>
                    </div>
                </div>
                <div class="card summary-card"> {{-- Added summary-card class --}}
                    <div class="card-icon">
                        <i class="fas fa-box"></i>
                    </div>
                    <div class="card-info">
                        <h3>Produk Terjual</h3>
                        <h3>{{ $produkTerjual }}</h3>
                    </div>
                </div>
                <div class="card summary-card"> {{-- Added summary-card class --}}
                    <div class="card-icon">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <div class="card-info">
                        <h3>Total Pendapatan</h3>
                        <h3>Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
                    </div>
                </div>
            </div>
            
            <!-- Top Selling Products Table -->
            <div class="product-table-container">
                <h3>Produk Terlaris</h3>
                <table class="product-table">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Terjual</th>
                            <th>Pendapatan</th>
                            <th>Persentase</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($produkTerlars as $produk)
                        <tr>
                            <td>{{ $produk['nama_produk'] }}</td>
                            <td>{{ $produk['qty_terjual'] }}</td>
                            <td>Rp {{ number_format($produk['total_pendapatan'], 0, ',', '.') }}</td>
                            <td>{{ $produk['persentase'] ?? '0' }}%</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
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