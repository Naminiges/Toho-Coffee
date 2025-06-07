<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Katalog Produk Kopi - TOHO</title>
    @vite('resources/css/style.css')
</head>
<body>
    @php
        $userCartItems = [];
        if(Auth::check()) {
            $userCartItems = \App\Models\Cart::where('user_id', Auth::user()->id_user)
                                            ->pluck('product_id')
                                            ->toArray();
        }
    @endphp
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

        <!-- Filter and Search Section -->
        <div class="filter-section">
            <div class="menu-filters">
                <button class="filter-btn {{ !request('category') || request('category') == 'all' ? 'active' : '' }}" 
                        onclick="filterProducts('all')">Semua</button>
                @if(isset($categories))
                    @foreach($categories as $category)
                        <button class="filter-btn {{ request('category') == $category->id_category ? 'active' : '' }}" 
                                onclick="filterProducts('{{ $category->id_category }}')">
                            {{ $category->category_name }}
                        </button>
                    @endforeach
                @else
                    <button class="filter-btn" onclick="filterProducts('kopi')">Kopi</button>
                    <button class="filter-btn" onclick="filterProducts('non-kopi')">Non-Kopi</button>
                    <button class="filter-btn" onclick="filterProducts('mix')">Mix</button>
                @endif
                <!-- Sort Options -->
            </div>
            <div class="sort-section">
                <form method="GET" action="{{ route('user-katalog') }}" id="sortForm">
                    <select name="sort_by" onchange="document.getElementById('sortForm').submit()">
                        <option value="product_name" {{ request('sort_by') == 'product_name' ? 'selected' : '' }}>
                            Nama Produk
                        </option>
                        <option value="product_price" {{ request('sort_by') == 'product_price' ? 'selected' : '' }}>
                            Harga
                        </option>
                        <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>
                            Terbaru
                        </option>
                    </select>
                    <select name="sort_order" onchange="document.getElementById('sortForm').submit()">
                        <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>
                            A-Z / Rendah-Tinggi
                        </option>
                        <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>
                            Z-A / Tinggi-Rendah
                        </option>
                    </select>
                    <input type="hidden" name="search" value="{{ request('search') }}">
                    <input type="hidden" name="category" value="{{ request('category') }}">
                </form>
            </div>
        </div>

        <div class="search-section">
            <div class="search-bar">
                <i class="fas fa-search"></i>
                <form method="GET" action="{{ route('user-katalog') }}" id="searchForm">
                    <input type="text" 
                            name="search" 
                            value="{{ request('search') }}" 
                            placeholder="Cari produk favorit Anda..."
                            onchange="document.getElementById('searchForm').submit()">
                    <input type="hidden" name="category" value="{{ request('category') }}">
                </form>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="menu-grid products-grid" id="productsGrid">
            @if(isset($products) && $products->count() > 0)
                @foreach($products as $product)
                    <div class="product-card" 
                         data-category="{{ $product->category->id_category ?? 'unknown' }}"
                         data-price="{{ $product->product_price }}">
                        <div class="product-image">
                            @if($product->product_name)
                                <img src="{{ asset('images/products/' . $product->product_name . '.jpg') }}" 
                                     alt="{{ $product->product_name }}"
                                     onerror="this.src='{{ asset('images/placeholder-product.jpg') }}'">
                            @else
                                <img src="{{ asset('images/placeholder-product.jpg') }}" 
                                     alt="{{ $product->product_name }}">
                            @endif
                            
                            <!-- Product Status Badge -->
                            @if($product->product_status === 'nonaktif')
                                <div class="status-badge inactive">Tidak Tersedia</div>
                            @endif
                        </div>
                        
                        <div class="product-info">
                            <h4>{{ $product->product_name }} ({{$product->description->temperatureType->temperature}})</h4>
                            <div class="price">{{ $product->formatted_price }}</div>
                            
                            @if($product->description && $product->description->product_description)
                                <div class="description">
                                    {{ Str::limit($product->description->product_description, 100) }}
                                </div>
                            @endif
                            @if(in_array($product->id_product, $userCartItems))
                                <button type="button" class="btn btn-success btn-added" disabled>
                                    <i class="fas fa-check"></i> Item Ditambahkan
                                </button>
                            @else
                                <form action="{{ route('user-keranjang-tambah') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id_product }}">
                                    <input type="hidden" name="product_name" value="{{ $product->product_name }}">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-plus"></i> Tambah ke Keranjang
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            @else
                <!-- No Products Found -->
                <div class="no-products">
                    <div class="no-products-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <h3>Tidak ada produk ditemukan</h3>
                    <p>
                        @if(request('search'))
                            Pencarian untuk "{{ request('search') }}" tidak menghasilkan produk.
                        @else
                            Belum ada produk yang tersedia untuk kategori ini.
                        @endif
                    </p>
                    <a href="{{ route('user-katalog') }}" class="btn btn-primary">
                        <i class="fas fa-arrow-left"></i> Lihat Semua Produk
                    </a>
                </div>
            @endif
        </div>

        <!-- Pagination -->
        {{ $products->links('custom-pagination') }}
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

        // Filter Products Function
        function filterProducts(category) {
            const url = new URL(window.location.href);
            if (category === 'all') {
                url.searchParams.delete('category');
            } else {
                url.searchParams.set('category', category);
            }
            window.location.href = url.toString();
        }

        // Event Listeners
        document.addEventListener('DOMContentLoaded', function() {
            // Add to cart button listeners
            document.querySelectorAll('.add-to-cart').forEach(button => {
                button.addEventListener('click', function() {
                    const productId = this.getAttribute('data-product-id');
                    addToCart(productId);
                });
            });
        });

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

        @if(session('cart_added'))
            document.addEventListener('DOMContentLoaded', function() {
                showCartPopup('{{ session("added_product_name", "Item") }} berhasil ditambahkan ke keranjang');
            });
        @endif

        // Cart Popup Functions
        function showCartPopup(message) {
            const popup = document.getElementById('cartPopup');
            const messageEl = document.getElementById('cartPopupMessage');
            
            messageEl.textContent = message;
            popup.style.display = 'block';
        }

        function closeCartPopup() {
            const popup = document.getElementById('cartPopup');
            popup.style.display = 'none';
        }

        // Close popup when clicking outside
        document.addEventListener('click', function(event) {
            const popup = document.getElementById('cartPopup');
            if (popup && popup.style.display === 'block' && !popup.contains(event.target)) {
                closeCartPopup();
            }
        });
    </script>
    <div class="cart-popup" id="cartPopup" style="display: none;">
        <div class="cart-popup-content">
            <div class="cart-popup-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="cart-popup-text">
                <span id="cartPopupMessage">Item berhasil ditambahkan ke keranjang</span>
            </div>
            <div class="cart-popup-actions">
                <a href="{{ route('user-keranjang') }}" class="btn-check-cart">
                    <i class="fas fa-shopping-cart"></i> Cek Keranjang
                </a>
                <button class="btn-cart-popup" onclick="closeCartPopup()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    </div>
</body>
</html>