<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Produk Kopi - TOHO</title>
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
    <section class="page-header">
        <h2>Katalog Produk</h2>
    </section>

    <!-- Main Content -->
    <div class="container">
        <!-- Breadcrumb -->
        <ul class="breadcrumb">
            <li><a href="{{ route('welcome') }}">Beranda</a></li>
            <li>Katalog</li>
        </ul>

        <!-- Menu Filters -->
        <div class="menu-filters">
            <button class="filter-btn active" data-category="all">Semua</button>
            <button class="filter-btn" data-category="coffee">Kopi</button>
            <button class="filter-btn" data-category="non-coffee">Non-Kopi</button>
        </div>

        <!-- Search Bar -->
        <div class="search-bar">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Cari produk kopi...">
        </div>

        <!-- Products Grid -->
        <div class="menu-grid">
            <!-- Product 1 -->
            <div class="product-card" data-category="arabica">
                <div class="product-image">
                    <img src="{{ asset('images/kopi1.jpg') }}" alt="Arabica Aceh Gayo">
                </div>
                <div class="product-info">
                    <h4>Arabica Aceh Gayo</h4>
                    <div class="price">Rp 75.000</div>
                    <div class="description">Kopi dengan aroma floral dan citrus, rasa fruity dengan keasaman sedang.</div>
                    <button class="add-to-cart">Tambah ke Keranjang</button>
                </div>
            </div>

            <!-- Product 2 -->
            <div class="product-card" data-category="robusta">
                <div class="product-image">
                    <img src="{{ asset('images/kopi5.jpg') }}" alt="Robusta Lampung">
                </div>
                <div class="product-info">
                    <h4>Robusta Lampung</h4>
                    <div class="price">Rp 65.000</div>
                    <div class="description">Kopi dengan karakter rasa kuat, earthy, dan sedikit sentuhan coklat.</div>
                    <button class="add-to-cart">Tambah ke Keranjang</button>
                </div>
            </div>

            <!-- Product 3 -->
            <div class="product-card" data-category="blend">
                <div class="product-image">
                    <img src="{{ asset('images/kopi6.jpg') }}" alt="House Blend">
                </div>
                <div class="product-info">
                    <h4>House Blend</h4>
                    <div class="price">Rp 70.000</div>
                    <div class="description">Perpaduan sempurna arabica dan robusta dengan rasa seimbang dan body sedang.</div>
                    <button class="add-to-cart">Tambah ke Keranjang</button>
                </div>
            </div>

            <!-- Product 4 -->
            <div class="product-card" data-category="single-origin">
                <div class="product-image">
                    <img src="{{ asset('images/kopi2.jpg') }}" alt="Toraja Kalosi">
                </div>
                <div class="product-info">
                    <h4>Toraja Kalosi</h4>
                    <div class="price">Rp 85.000</div>
                    <div class="description">Single origin dengan karakter rasa herbal, spicy, dan sentuhan dark chocolate.</div>
                    <button class="add-to-cart">Tambah ke Keranjang</button>
                </div>
            </div>

            <!-- Product 5 -->
            <div class="product-card" data-category="arabica">
                <div class="product-image">
                    <img src="{{ asset('images/kopi3.jpg') }}" alt="Arabica Java Preanger">
                </div>
                <div class="product-info">
                    <h4>Arabica Java Preanger</h4>
                    <div class="price">Rp 78.000</div>
                    <div class="description">Kopi dengan karakter jasmine aroma, rasa caramel dan keasaman rendah.</div>
                    <button class="add-to-cart">Tambah ke Keranjang</button>
                </div>
            </div>

            <!-- Product 6 -->
            <div class="product-card" data-category="robusta">
                <div class="product-image">
                    <img src="{{ asset('images/kopi7.jpg') }}" alt="Robusta Temanggung">
                </div>
                <div class="product-info">
                    <h4>Robusta Temanggung</h4>
                    <div class="price">Rp 68.000</div>
                    <div class="description">Kopi dengan body tebal, aftertaste panjang, dan sentuhan nutty.</div>
                    <button class="add-to-cart">Tambah ke Keranjang</button>
                </div>
            </div>

            <!-- Product 7 -->
            <div class="product-card" data-category="blend">
                <div class="product-image">
                    <img src="{{ asset('images/kopi4.jpg') }}" alt="Morning Blend">
                </div>
                <div class="product-info">
                    <h4>Morning Blend</h4>
                    <div class="price">Rp 72.000</div>
                    <div class="description">Blend khusus untuk pagi hari dengan karakter rasa bright dan menyegarkan.</div>
                    <button class="add-to-cart">Tambah ke Keranjang</button>
                </div>
            </div>

            <!-- Product 8 -->
            <div class="product-card" data-category="single-origin">
                <div class="product-image">
                    <img src="{{ asset('images/kopi8.jpg') }}" alt="Flores Bajawa">
                </div>
                <div class="product-info">
                    <h4>Flores Bajawa</h4>
                    <div class="price">Rp 82.000</div>
                    <div class="description">Single origin dengan karakter floral, hint of vanilla, dan keasaman medium.</div>
                    <button class="add-to-cart">Tambah ke Keranjang</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Back to Top Button -->
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