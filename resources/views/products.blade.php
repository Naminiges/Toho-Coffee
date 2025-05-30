<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar Produk - TOHO</title>
    @vite('resources/css/style.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
    @media (max-width: 768px) {
    .menu-grid {
        grid-template-columns: 1fr;
        padding: 16px;
        gap: 16px;
    }
    
    .product-actions {
        flex-direction: column;
    }
    
    .btn {
        flex: none;
    }
    
    .product-info h4 {
        font-size: 1.1rem;
    }
    
    .price {
        font-size: 1.3rem;
    }
}

@media (max-width: 480px) {
    .product-image {
        height: 160px;
    }
    
    .product-info {
        padding: 16px;
    }
    
    .btn {
        padding: 10px 14px;
        font-size: 0.85rem;
    }
}

/* Additional Enhancements */
.product-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, #22c55e, #3b82f6);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.product-card:hover::before {
    opacity: 1;
}

/* Loading State */
.product-card.loading {
    opacity: 0.7;
    pointer-events: none;
}

.product-card.loading::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 20px;
    height: 20px;
    margin: -10px 0 0 -10px;
    border: 2px solid #22c55e;
    border-top: 2px solid transparent;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Focus States for Accessibility */
.btn:focus {
    outline: 2px solid #22c55e;
    outline-offset: 2px;
}

.product-card:focus-within {
    box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.1);
}

.select-custom {
    padding: 8px 16px;
    padding-right: 40px;
    border-radius: 12px;
    background-color: #f5f5f5;
    border: 1px solid #ccc;
    font-size: 14px;
    transition: all 0.3s ease;
    appearance: none;

    background-image: url("data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns='http://www.w3.org/2000/svg'%20width='10'%20height='10'%20viewBox='0%200%2010%2010'%3E%3Cpolygon%20points='0,0%2010,0%205,7'%20style='fill:%23666;'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 12px center;
    background-size: 10px;
}

.select-custom:hover {
    background-color: #e2e8f0;
    border-color: #999;
}

</style>
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
                @auth
                <li><a href="{{ route('welcome') }}">Beranda</a></li>
                <li><a href="{{ route('user-katalog') }}">Katalog</a></li>
                <li><a href="{{ route('user-riwayat') }}">Riwayat</a></li>
                @else
                <li><a href="{{ route('welcome') }}">Beranda</a></li>
                <li><a href="{{ route('products') }}">Katalog</a></li>
                @endauth
            </ul>
            <div class="nav-actions">
                @auth
                    <!-- User Menu Dropdown -->
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
                @else 
                    <div class="auth-links">
                        <a href="{{ route('login') }}" class="login-btn">Masuk</a>
                        <a href="{{ route('register') }}" class="register-btn">Daftar</a>
                    </div>
                @endauth
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
        <h2 class="fw-bold">Daftar Produk Kami</h2>
        {{-- <p class="text-muted">Temukan kopi dan minuman favorit Anda</p> --}}
    </div>


    <!-- Menu Content -->
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="{{ route('welcome') }}">Beranda</a></li>
            <li>Katalog</li>
        </ul>

        <!-- Filter and Search Section -->
        <div class="filter-section">
            <div class="menu-filters">
                <button class="filter-btn {{ !request('category') || request('category') == 'all' ? 'active' : '' }}" 
                        onclick="filterProducts('all')">Semua</button>
                @if(isset($categories) && $categories->count() > 0)
                    @foreach($categories as $category)
                        <button class="filter-btn {{ request('category') == $category->id_category ? 'active' : '' }}" 
                                onclick="filterProducts('{{ $category->id_category }}')">
                            {{ $category->category }}
                        </button>
                    @endforeach
                @endif
            </div>

            <div class="search-section">
                <div class="search-bar">
                    <i class="fas fa-search"></i>
                    <form method="GET" action="{{ route('products') }}" id="searchForm">
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}" 
                               placeholder="Cari produk favorit Anda..."
                               onchange="document.getElementById('searchForm').submit()">
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    </form>
                </div>

                <!-- Sort Options -->
                <div class="sort-section">
                    <form method="GET" action="{{ route('products') }}" id="sortForm">
                        <select name="sort_by" class="select-custom" onchange="document.getElementById('sortForm').submit()">
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
                        <select name="sort_order" class="select-custom" onchange="document.getElementById('sortForm').submit()">
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
        </div>

        <!-- Products Grid -->
        <div class="menu-grid products-grid" id="productsGrid">
            @if(isset($products) && $products->count() > 0)
                @foreach($products as $product)
                    <div class="product-card">
                        <div class="product-content">
                            <div class="product-image">
                                <img src="{{ asset('images/' . $product->description->product_photo . '.jpg') }}"
                                    alt="{{ $product->product_name }}"
                                    onerror="this.src='{{ asset('images/placeholder-product.jpg') }}'">
                            </div>
                            
                            <div class="product-info">
                                <h4>{{ $product->product_name }}</h4>
                                <div class="price">Rp {{ number_format($product->product_price, 0, ',', '.') }}</div>
                                
                                @if($product->description && $product->description->product_description)
                                    <div class="description">
                                        {{ Str::limit($product->description->product_description, 100) }}
                                    </div>
                                @endif
                                
                                <!-- Product Metadata -->
                                <div class="product-meta">
                                    @if($product->description && $product->description->category)
                                        <span class="category-badge">
                                            <i class="fas fa-{{ $product->description->category->category == 'Coffee' ? 'coffee' : 'glass' }}"></i>
                                            {{ $product->description->category->category }}
                                        </span>
                                    @endif
                                </div>
                                
                                <!-- Action Buttons -->
                                <div class="product-actions">
                                    @if($product->product_status === 'aktif')
                                        @auth
                                            <button class="btn btn-primary add-to-cart" 
                                                    data-product-id="{{ $product->id_product }}"
                                                    data-product-name="{{ $product->product_name }}"
                                                    data-product-price="{{ $product->product_price }}">
                                                <i class="fas fa-cart-plus"></i> Tambah ke Keranjang
                                            </button>
                                        @else
                                            <a href="{{ route('login') }}" class="btn btn-primary">
                                                <i class="fas fa-sign-in-alt"></i> Login untuk Membeli
                                            </a>
                                        @endauth
                                        
                                        <button class="btn btn-secondary view-detail" 
                                                data-product-id="{{ $product->id_product }}">
                                            <i class="fas fa-eye"></i> Detail
                                        </button>
                                    @else
                                        <button class="btn btn-disabled" disabled>
                                            <i class="fas fa-times"></i> Tidak Tersedia
                                        </button>
                                    @endif
                                </div>
                            </div>
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
                        @elseif(request('category') && request('category') != 'all')
                            Belum ada produk yang tersedia untuk kategori ini.
                        @else
                            Belum ada produk yang tersedia saat ini.
                        @endif
                    </p>
                    <a href="{{ route('products') }}" class="btn btn-primary">
                        <i class="fas fa-arrow-left"></i> Lihat Semua Produk
                    </a>
                </div>
            @endif
        </div>

        <!-- Pagination -->
        @if(isset($products) && $products->hasPages())
            <div class="pagination-wrapper">
                {{ $products->appends(request()->query())->links() }}
            </div>
        @endif

        <!-- Loading Indicator -->
        <div class="loading-indicator" id="loadingIndicator" style="display: none;">
            <div class="spinner">
                <i class="fas fa-spinner fa-spin"></i>
            </div>
            <p>Memuat produk...</p>
        </div>
    </div>

    <!-- Product Detail Modal -->
    <div class="modal-overlay" id="productDetailModal" style="display: none;">
        <div class="modal-content large">
            <div class="modal-header">
                <h3 id="modalProductName">Detail Produk</h3>
                <button class="modal-close" onclick="closeProductDetailModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="product-detail-content">
                    <div class="product-detail-image">
                        <img id="modalProductImage" src="" alt="">
                    </div>
                    <div class="product-detail-info">
                        <h4 id="modalProductTitle"></h4>
                        <div class="price" id="modalProductPrice"></div>
                        <div class="description" id="modalProductDescription"></div>
                        <div class="product-meta" id="modalProductMeta"></div>
                        <div class="product-actions">
                            <button class="btn btn-primary" id="modalAddToCart">
                                <i class="fas fa-cart-plus"></i> Tambah ke Keranjang
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer id="contact">
        <div class="footer-content">
            <div class="footer-column">
                <div class="logo">
                    <img src="{{ asset('images/logo-toho.jpg') }}" alt="Toho Coffee Logo">
                    <h1>Toho Coffee</h1>
                </div>
                <p>Kopi premium untuk pengalaman menikmati kopi terbaik di rumah ataupun di kafe Anda.</p>
                <div class="social-links">
                    <a href="https://www.instagram.com/tohocoffee.id/" target="_blank"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
            <div class="footer-column">
                <h4>Informasi</h4>
                <ul class="footer-links">
                    <li><a href="{{ route('welcome') }}">Tentang Kami</a></li>
                    <li><a href="{{ route('products') }}">Produk</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h4>Layanan Pelanggan</h4>
                <ul class="footer-links">
                    <li><a href="https://wa.me/6281397306005" target="_blank">Hubungi Kami</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h4>Kontak Kami</h4>
                <ul class="contact-info">
                    <li><span><i class="fas fa-map-marker-alt"></i></span> Universitas Sumatera Utara</li>
                    <li><span><i class="fas fa-phone"></i></span> +62 813-9730-6005</li>
                    <li><span><i class="fas fa-clock"></i></span> Senin - Jumat: 08.00 - 17.00</li>
                </ul>
            </div>
        </div>
        <div class="copyright">
            <p>&copy; 2025 Toho Coffee. All Rights Reserved.</p>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <a href="#" class="back-to-top" id="backToTop">
        <i class="fas fa-arrow-up"></i>
    </a>

    @vite('resources/js/script.js')

    <script>
        // Setup CSRF token for AJAX requests
        window.Laravel = {
            csrfToken: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        };

        // Global variables
        let currentProducts = [];
        let isLoading = false;

        // Initialize when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            initializeProductPage();
            setupEventListeners();
            loadProducts();
        });

        // Initialize product page
        function initializeProductPage() {
            // Show loading indicator
            showLoadingIndicator();
            
            // Setup search input with debounce
            const searchInput = document.querySelector('input[name="search"]');
            if (searchInput) {
                let debounceTimer;
                searchInput.addEventListener('input', function() {
                    clearTimeout(debounceTimer);
                    debounceTimer = setTimeout(() => {
                        if (this.value.length >= 3 || this.value.length === 0) {
                            searchProducts(this.value);
                        }
                    }, 500);
                });
            }

            // Setup back to top button
            setupBackToTop();
        }

        // Setup event listeners
        function setupEventListeners() {
            // Add to cart button listeners
            document.addEventListener('click', function(e) {
                if (e.target.closest('.add-to-cart')) {
                    const button = e.target.closest('.add-to-cart');
                    const productId = button.getAttribute('data-product-id');
                    const productName = button.getAttribute('data-product-name');
                    const productPrice = button.getAttribute('data-product-price');
                    addToCart(productId, productName, productPrice, button);
                }

                if (e.target.closest('.view-detail')) {
                    const button = e.target.closest('.view-detail');
                    const productId = button.getAttribute('data-product-id');
                    showProductDetail(productId);
                }
            });

            // Close modals when clicking outside
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('modal-overlay')) {
                    closeAllModals();
                }
            });

            // Close modals with Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeAllModals();
                }
            });
        }

        // Load products from server
        function loadProducts() {
            // This function can be used for AJAX loading if needed
            // For now, products are loaded server-side
            hideLoadingIndicator();
        }

        // Filter products by category
        function filterProducts(category) {
            showLoadingIndicator();
            
            const url = new URL(window.location.href);
            if (category === 'all') {
                url.searchParams.delete('category');
            } else {
                url.searchParams.set('category', category);
            }
            
            // Remove page parameter to start from page 1
            url.searchParams.delete('page');
            
            window.location.href = url.toString();
        }

        // Search products
        function searchProducts(query) {
            showLoadingIndicator();
            
            const url = new URL(window.location.href);
            if (query && query.trim() !== '') {
                url.searchParams.set('search', query.trim());
            } else {
                url.searchParams.delete('search');
            }
            
            // Remove page parameter to start from page 1
            url.searchParams.delete('page');
            
            // Redirect to new URL
            setTimeout(() => {
                window.location.href = url.toString();
            }, 300);
        }

        // Add product to cart
        function addToCart(productId, productName, productPrice, button) {
            if (isLoading) return;
            
            isLoading = true;
            
            // Show loading state on button
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menambahkan...';
            button.disabled = true;

            fetch('{{ route("cart.add") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': window.Laravel.csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: 1
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    showAlert('success', data.message || `${productName} berhasil ditambahkan ke keranjang`);
                    updateCartCount();
                    
                    // Change button text temporarily
                    button.innerHTML = '<i class="fas fa-check"></i> Ditambahkan';
                    setTimeout(() => {
                        button.innerHTML = originalText;
                        button.disabled = false;
                    }, 2000);
                } else {
                    throw new Error(data.message || 'Gagal menambahkan ke keranjang');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('error', error.message || 'Terjadi kesalahan saat menambahkan ke keranjang');
                button.innerHTML = originalText;
                button.disabled = false;
            })
            .finally(() => {
                isLoading = false;
            });
        }

        // Update cart count in navbar
        function updateCartCount() {
            fetch('{{ route("cart.count") }}', {
                headers: {
                    'X-CSRF-TOKEN': window.Laravel.csrfToken,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                const cartBadge = document.querySelector('.cart-count');
                if (cartBadge && data.count !== undefined) {
                    cartBadge.textContent = data.count;
                    if (data.count > 0) {
                        cartBadge.style.display = 'inline-block';
                    }
                }
            })
            .catch(error => {
                console.error('Error updating cart count:', error);
            });
        }

        // Show product detail in modal
        function showProductDetail(productId) {
            // Find product data from current page
            const productCard = document.querySelector(`[data-product-id="${productId}"]`);
            if (!productCard) return;

            const productImage = productCard.querySelector('.product-image img');
            const productName = productCard.querySelector('.product-info h4').textContent;
            const productPrice = productCard.querySelector('.price').textContent;
            const productDescription = productCard.querySelector('.description')?.textContent || 'Tidak ada deskripsi';
            const productMeta = productCard.querySelector('.product-meta').innerHTML;

            // Populate modal
            document.getElementById('modalProductName').textContent = productName;
            document.getElementById('modalProductTitle').textContent = productName;
            document.getElementById('modalProductPrice').textContent = productPrice;
            document.getElementById('modalProductDescription').textContent = productDescription;
            document.getElementById('modalProductMeta').innerHTML = productMeta;
            document.getElementById('modalProductImage').src = productImage.src;
            document.getElementById('modalProductImage').alt = productName;

            // Setup add to cart button in modal
            const modalAddToCartBtn = document.getElementById('modalAddToCart');
            modalAddToCartBtn.setAttribute('data-product-id', productId);
            modalAddToCartBtn.setAttribute('data-product-name', productName);
            modalAddToCartBtn.setAttribute('data-product-price', productCard.getAttribute('data-price'));

            // Show modal
            document.getElementById('productDetailModal').style.display = 'flex';
        }

        // Close product detail modal
        function closeProductDetailModal() {
            document.getElementById('productDetailModal').style.display = 'none';
        }

        // Close all modals
        function closeAllModals() {
            closeLogoutModal();
            closeProductDetailModal();
        }

        // User Menu Functions
        function toggleUserMenu() {
            const dropdown = document.getElementById('userDropdown');
            const trigger = document.querySelector('.user-trigger');
            const arrow = document.querySelector('.dropdown-arrow');
            
            if (dropdown && trigger && arrow) {
                dropdown.classList.toggle('show');
                trigger.classList.toggle('active');
                
                if (dropdown.classList.contains('show')) {
                    arrow.style.transform = 'rotate(180deg)';
                } else {
                    arrow.style.transform = 'rotate(0deg)';
                }
            }
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const userMenu = document.querySelector('.user-menu');
            const dropdown = document.getElementById('userDropdown');
            
            if (userMenu && dropdown && !userMenu.contains(event.target)) {
                dropdown.classList.remove('show');
                const trigger = document.querySelector('.user-trigger');
                const arrow = document.querySelector('.dropdown-arrow');
                
                if (trigger) trigger.classList.remove('active');
                if (arrow) arrow.style.transform = 'rotate(0deg)';
            }
        });

        // Logout Functions
        function confirmLogout() {
            document.getElementById('logoutModal').style.display = 'flex';
            // Close user dropdown
            const dropdown = document.getElementById('userDropdown');
            if (dropdown) {
                dropdown.classList.remove('show');
                const trigger = document.querySelector('.user-trigger');
                const arrow = document.querySelector('.dropdown-arrow');
                
                if (trigger) trigger.classList.remove('active');
                if (arrow) arrow.style.transform = 'rotate(0deg)';
            }
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
            } else if (type === 'info') {
                alertIcon.className = 'alert-icon fas fa-info-circle';
            }
            
            // Show alert
            alertContainer.style.display = 'flex';
            
            // Auto hide after 5 seconds
            setTimeout(() => {
                alertContainer.style.display = 'none';
            }, 5000);
        }

        // Loading indicator functions
        function showLoadingIndicator() {
            const indicator = document.getElementById('loadingIndicator');
            if (indicator) {
                indicator.style.display = 'flex';
            }
        }

        function hideLoadingIndicator() {
            const indicator = document.getElementById('loadingIndicator');
            if (indicator) {
                indicator.style.display = 'none';
            }
        }

        // Back to top functionality
       function setupBackToTop() {
           const backToTopBtn = document.getElementById('backToTop');
           
           if (backToTopBtn) {
               // Show/hide button based on scroll position
               window.addEventListener('scroll', function() {
                   if (window.pageYOffset > 300) {
                       backToTopBtn.classList.add('show');
                   } else {
                       backToTopBtn.classList.remove('show');
                   }
               });
               
               // Smooth scroll to top when clicked
               backToTopBtn.addEventListener('click', function(e) {
                   e.preventDefault();
                   window.scrollTo({
                       top: 0,
                       behavior: 'smooth'
                   });
               });
           }
       }

       // Mobile hamburger menu functionality
       function setupMobileMenu() {
           const hamburger = document.querySelector('.hamburger');
           const navLinks = document.querySelector('.nav-links');
           
           if (hamburger && navLinks) {
               hamburger.addEventListener('click', function() {
                   hamburger.classList.toggle('active');
                   navLinks.classList.toggle('active');
               });
               
               // Close menu when clicking on a link
               navLinks.addEventListener('click', function(e) {
                   if (e.target.tagName === 'A') {
                       hamburger.classList.remove('active');
                       navLinks.classList.remove('active');
                   }
               });
           }
       }

       // Product grid animations
       function animateProductCards() {
           const cards = document.querySelectorAll('.product-card');
           
           const observer = new IntersectionObserver((entries) => {
               entries.forEach(entry => {
                   if (entry.isIntersecting) {
                       entry.target.classList.add('animate-in');
                   }
               });
           }, {
               threshold: 0.1,
               rootMargin: '0px 0px -50px 0px'
           });
           
           cards.forEach(card => {
               observer.observe(card);
           });
       }

       // Price formatting
       function formatPrice(price) {
           return new Intl.NumberFormat('id-ID', {
               style: 'currency',
               currency: 'IDR',
               minimumFractionDigits: 0,
               maximumFractionDigits: 0
           }).format(price).replace('IDR', 'Rp');
       }

       // Product card hover effects
       function setupProductCardEffects() {
           const productCards = document.querySelectorAll('.product-card');
           
           productCards.forEach(card => {
               const image = card.querySelector('.product-image');
               const actions = card.querySelector('.product-actions');
               
               if (image && actions) {
                   card.addEventListener('mouseenter', function() {
                       image.style.transform = 'scale(1.05)';
                       actions.style.opacity = '1';
                       actions.style.transform = 'translateY(0)';
                   });
                   
                   card.addEventListener('mouseleave', function() {
                       image.style.transform = 'scale(1)';
                       actions.style.opacity = '0.8';
                       actions.style.transform = 'translateY(10px)';
                   });
               }
           });
       }

       // Initialize all functionality
       function initializeAllFeatures() {
           setupMobileMenu();
           animateProductCards();
           setupProductCardEffects();
           
           // Initialize cart count on page load
           if (document.querySelector('.cart-count')) {
               updateCartCount();
           }
       }

       // Run initialization after DOM is fully loaded
       document.addEventListener('DOMContentLoaded', function() {
           initializeAllFeatures();
       });

       // Handle form submissions with loading states
       function handleFormSubmission(formId, buttonId) {
           const form = document.getElementById(formId);
           const button = document.getElementById(buttonId);
           
           if (form && button) {
               form.addEventListener('submit', function() {
                   button.disabled = true;
                   button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
               });
           }
       }

       // Initialize form handlers
       handleFormSubmission('searchForm', 'searchButton');
       handleFormSubmission('sortForm', 'sortButton');

       // Lazy loading for product images
       function initializeLazyLoading() {
           const images = document.querySelectorAll('img[data-src]');
           
           const imageObserver = new IntersectionObserver((entries, observer) => {
               entries.forEach(entry => {
                   if (entry.isIntersecting) {
                       const img = entry.target;
                       img.src = img.dataset.src;
                       img.classList.remove('lazy');
                       imageObserver.unobserve(img);
                   }
               });
           });
           
           images.forEach(img => imageObserver.observe(img));
       }

       // Initialize lazy loading
       initializeLazyLoading();

       // Handle network errors gracefully
       function handleNetworkError(error) {
           console.error('Network error:', error);
           showAlert('error', 'Terjadi kesalahan koneksi. Silakan coba lagi.');
       }

       // Utility function to debounce function calls
       function debounce(func, wait) {
           let timeout;
           return function executedFunction(...args) {
               const later = () => {
                   clearTimeout(timeout);
                   func(...args);
               };
               clearTimeout(timeout);
               timeout = setTimeout(later, wait);
           };
       }

       // Enhanced search with debounce
       const debouncedSearch = debounce(searchProducts, 300);

       // Update search input event listener
       document.addEventListener('DOMContentLoaded', function() {
           const searchInput = document.querySelector('input[name="search"]');
           if (searchInput) {
               searchInput.addEventListener('input', function() {
                   if (this.value.length >= 3 || this.value.length === 0) {
                       debouncedSearch(this.value);
                   }
               });
           }
       });

   </script>
</body>
</html>