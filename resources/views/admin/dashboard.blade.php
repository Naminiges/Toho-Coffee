<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard Admin - TOHO Coffee</title>
    @vite('resources/css/style.css')
    <script src="https://cdn.jsdelivr.net/npm/chart.js" async></script>
</head>
<body>
    <!-- Header -->
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
                    <a href="{{ route('admin-dashboard') }}" class="active">
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
                    <a href="{{ route('admin-laporan') }}">
                        <i class="fas fa-chart-pie"></i>
                        Laporan
                    </a>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="admin-page-header">
                <div class="page-title">
                    <h2>Dashboard</h2>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="icon blue">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="value">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</div>
                    <div class="label">Total Pendapatan</div>
                </div>

                <div class="stat-card">
                    <div class="icon green">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <div class="value">{{ number_format($stats['total_orders'], 0, ',', '.') }}</div>
                    <div class="label">Total Pesanan</div>
                </div>

                <div class="stat-card">
                    <div class="icon orange">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="value">{{ number_format($stats['total_customers'], 0, ',', '.') }}</div>
                    <div class="label">Total Pelanggan</div>
                </div>

                <div class="stat-card">
                    <div class="icon red">
                        <i class="fas fa-box"></i>
                    </div>
                    <div class="value">{{ number_format($stats['total_products'], 0, ',', '.') }}</div>
                    <div class="label">Produk Tersedia</div>
                </div>
            </div>

            <!-- Charts Grid -->
            <div class="charts-grid">
                <div class="chart-card">
                    <div class="card p-4">
                        <h5 class="mb-3"><i class="fas fa-chart-line text-primary me-2"></i> Grafik Penjualan (7 Hari Terakhir)</h5>
                        <div>
                            <canvas id="salesChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>

                <div class="chart-card">
                    <div class="card p-4 shadow-sm border-0">
                        <h5 class="mb-3 d-flex align-items-center">
                            <i class="fas fa-star text-warning me-2"></i> Produk Terlaris
                        </h5>

                        @if ($top_product_name)
                            <div class="d-flex align-items-center justify-content-between bg-light rounded px-3 py-2">
                                <div class="fw-semibold fs-6 text-dark">
                                    {{ $top_product_name }}
                                </div>
                                <span class="badge bg-success px-3 py-2">
                                    <i class="fas fa-box me-1"></i> Terlaris
                                </span>
                            </div>
                        @else
                            <p class="text-muted">Belum ada data produk terlaris.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @vite('resources/js/script.js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js" async></script>

    <script>
        // Setup CSRF token for AJAX requests
        window.Laravel = {
            csrfToken: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        };
    </script>

    <!-- Chart initialization script - bungkus dalam async function -->
    <script>
        async function initializeCharts() {
            // Tunggu Chart.js dimuat
            while (typeof Chart === 'undefined') {
                await new Promise(resolve => setTimeout(resolve, 100));
            }

            const ctx = document.getElementById('salesChart').getContext('2d');
            const salesChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($labels) !!},
                    datasets: [{
                        label: 'Penjualan (Rp)',
                        data: {!! json_encode($sales) !!},
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + value.toLocaleString('id-ID');
                                }
                            }
                        }
                    }
                }
            });

            // Initialize Sales Chart (Line Chart)
            const salesCtx = document.getElementById('salesChart').getContext('2d');
            new Chart(salesCtx, {
                type: 'line',
                data: {
                    labels: salesLabels,
                    datasets: [{
                        label: 'Penjualan (Rp)',
                        data: salesValues,
                        borderColor: 'rgb(75, 192, 192)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        tension: 0.1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + value.toLocaleString('id-ID');
                                }
                            }
                        }
                    }
                }
            });

            // Initialize Products Chart jika ada element productsChart
            const productsElement = document.getElementById('productsChart');
            if (productsElement) {
                const productsCtx = productsElement.getContext('2d');
                new Chart(productsCtx, {
                    type: 'doughnut',
                    data: {
                        labels: productLabels,
                        datasets: [{
                            data: productValues,
                            backgroundColor: [
                                '#FF6384',
                                '#36A2EB',
                                '#FFCE56',
                                '#4BC0C0',
                                '#9966FF'
                            ]
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                });
            }
        }

        // Initialize charts ketika DOM ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initializeCharts);
        } else {
            initializeCharts();
        }
    </script>

    <!-- Script untuk fungsi-fungsi lainnya tetap sama -->
    <script>
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

        // Event listeners untuk modal dan alert
        document.addEventListener('DOMContentLoaded', function() {
            // Close alert when clicking on it
            const alertContainer = document.getElementById('alertContainer');
            if (alertContainer) {
                alertContainer.addEventListener('click', function() {
                    this.style.display = 'none';
                });
            }

            // Prevent modal from closing when clicking inside modal content
            const modalContent = document.querySelector('.modal-content');
            if (modalContent) {
                modalContent.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            }

            // Close modal when clicking on overlay
            const logoutModal = document.getElementById('logoutModal');
            if (logoutModal) {
                logoutModal.addEventListener('click', function(e) {
                    if (e.target === this) {
                        closeLogoutModal();
                    }
                });
            }

            // Close modal with Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeLogoutModal();
                }
            });
        });
    </script>
    @vite('resources/js/script.js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js" async></script>
</body>
</html> 