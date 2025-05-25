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
                <h1>Toho Coffee</h1>
            </div>
            <ul class="nav-links">
                <li><a href="{{ route('user-katalog') }}">Katalog</a></li>
                <li><a href="{{ route('user-riwayat') }}">Riwayat</a></li>
            </ul>
            <div class="nav-actions">
                <div class="cart-icon">
                    <a href="{{ route('user-keranjang') }}" style="text-decoration : none;">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="cart-count">0</span>
                    </a>
                </div>
                <div class="user-icon">
                    <i class="fas fa-user"></i>
                </div>
            </div>
            <div class="hamburger">
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
    </header>

    <!-- Page Header -->
    <section class="page-header">
        <h2>Katalog Produk Kopi</h2>
    </section>

    <!-- Main Content -->
    <div class="container">
        <!-- Breadcrumb -->
        <ul class="breadcrumb">
            <li><a href="{{ route('user-katalog') }}">Katalog</a></li>
            <li>Katalog Produk</li>
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
</body>
</html>