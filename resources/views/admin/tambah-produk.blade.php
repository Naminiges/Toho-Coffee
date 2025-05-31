<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk - TOHO Coffee Admin</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/css/style.css')
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

    <div class="product-management-container">
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
                    <a href="{{ route('admin-manajemen-produk') }}" class="active">
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
                    <h2>Tambah Produk Baru</h2>
                </div>
            </div>

            <!-- Product Form Section -->
            <div class="product-form-section active">
                <form id="productForm" action="{{ route('admin-produk-store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-row">
                        <div class="form-group">
                            <label for="productName">Nama Produk</label>
                            <input type="text" id="productName" name="name" class="form-control" required>
                            @error('name')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="productCategory">Kategori</label>
                            <select id="productCategory" name="category" class="form-control" required>
                                <option value="">-- Pilih Kategori --</option>
                                <option value="kopi">Kopi</option>
                                <option value="non-kopi">Non-kopi</option>
                                <option value="mix">Mix</option>
                            </select>
                            @error('category')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="productDescription">Deskripsi</label>
                        <textarea id="productDescription" name="description" class="form-control" rows="3" required></textarea>
                        @error('description')
                                <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="productPrice">Harga (Rp)</label>
                        <input type="number" id="productPrice" name="price" class="form-control" min="0" required>
                        @error('price')
                                <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="productImage">Gambar Produk (JPG)</label>
                        <input type="file" id="productImage" name="image" class="form-control" accept="image/*" required>
                        <p style="font-size: 12px; color: var(--dark-gray); margin-top: 5px;">Format: JPG. Maks: 2MB</p>
                        @error('image')
                                <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="productTemperature">Temperature</label>
                        <select id="productTemperature" name="temperature" class="form-control" required>
                            <option value="active">Cold</option>
                            <option value="inactive">Hot</option>
                        </select>
                        @error('temperature')
                                <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-actions">
                        <a href="{{route('admin-manajemen-produk')}}" class="btn btn-cancel">Batal</a>
                        <button type="submit" class="btn">Simpan Produk</button>
                    </div>
                </form>
            </div>
        </div>
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

<?php 
// <form id="productForm" action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
?>
                        