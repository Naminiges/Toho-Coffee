<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TOHO Coffee - Nikmati Kopi Premium</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="hero-content">
            <h2>Nikmati Kopi Premium Berkualitas Terbaik</h2>
            <p>Temukan kenikmatan kopi yang diproses dengan teliti dari biji pilihan dan dipanggang dengan sempurna untuk menghasilkan cita rasa terbaik.</p>
            @auth
            <a href="{{ route('user-katalog') }}" class="cta-button">Belanja Sekarang</a>
            <a href="{{ route('user-katalog') }}" class="secondary-button">Pelajari Lebih Lanjut</a>
            @else
            <a href="{{ route('login') }}" class="cta-button">Belanja Sekarang</a>
            <a href="{{ route('login') }}" class="secondary-button">Pelajari Lebih Lanjut</a>
            @endauth
        </div>
    </section>

    <!-- Featured Products -->
    <section class="featured" id="products">
        <div class="section-title">
            <h3>Produk Unggulan</h3>
            <p>Koleksi kopi premium kami yang dipilih dengan teliti untuk memberikan pengalaman kopi terbaik bagi Anda.</p>
        </div>
        <div class="products-grid">
            @if($products->count() > 0)
                @foreach($products as $product)
                <!-- Produk 1 -->
                <div class="product-card">
                    <div class="product-image">
                        <img src="{{ asset($product->description->product_photo) }}" alt="Arabica Premium">
                    </div>
                    <div class="product-info">
                        <h4>{{ $product->product_name }}</h4>
                        <div class="price">{{ $product->formatted_price }}</div>
                        <div class="description">{{ $product->description->product_description }}</div>
                    </div>
                </div>
                @endforeach
            @endif
        </div>
    </section>

    <!-- About Section -->
    <section class="about" id="about">
        <div class="about-image">
            <img src="{{ asset('images/diorama-toho.jpg') }}" alt="About Toho Coffee">
        </div>
        <div class="about-content">
            <h3>Tentang Toho Coffee</h3>
            <p>Toho Coffee adalah merek kopi premium yang berdedikasi untuk menghadirkan pengalaman kopi terbaik bagi para pecinta kopi di Indonesia. Kami memilih biji kopi terbaik dari petani lokal terpilih dan memproses dengan standar kualitas tinggi.</p>
            <p>Setiap biji kopi yang kami gunakan dipanen secara berkelanjutan dengan memperhatikan kelestarian lingkungan dan kesejahteraan petani kopi lokal.</p>
            <div class="features">
                <div class="feature">
                    <h5><span><i class="fas fa-check"></i></span> Kualitas Premium</h5>
                    <p>Hanya biji kopi terbaik yang lolos seleksi ketat kami.</p>
                </div>
                <div class="feature">
                    <h5><span><i class="fas fa-check"></i></span> Proses Terbaik</h5>
                    <p>Metode pengolahan modern dengan kontrol kualitas ketat.</p>
                </div>
                <div class="feature">
                    <h5><span><i class="fas fa-check"></i></span> Ramah Lingkungan</h5>
                    <p>Praktek bisnis yang berkelanjutan dan bertanggung jawab.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="testimonials" id="testimonials">
        <div class="section-title">
            <h3>Apa Kata Mereka</h3>
            <p>Pengalaman para pelanggan setia Toho Coffee yang telah menikmati produk kami.</p>
        </div>
        <div class="testimonial-slider">
            <div class="testimonial-slides">
                <!-- Testimonial 1 -->
                <div class="testimonial">
                    <div class="testimonial-content">
                        <p>"Kopi dari Toho Coffee selalu menjadi favorit saya. Aromanya sangat harum dan rasanya konsisten dari waktu ke waktu. Sangat direkomendasikan untuk para pecinta kopi!"</p>
                    </div>
                    <div class="testimonial-author">
                        <div class="author-image">
                            <img src="{{ asset('images/kopi5.jpg') }}" alt="Budi Santoso">
                        </div>
                        <div class="author-info">
                            <h5>Aditya Mufti</h5>
                            <span>Pelanggan Setia</span>
                        </div>
                    </div>
                </div>
                <!-- Testimonial 2 -->
                <div class="testimonial">
                    <div class="testimonial-content">
                        <p>"Saya telah mencoba berbagai merek kopi, tetapi Toho Coffee benar-benar berbeda. Kualitasnya luar biasa dan layanan pengirimannya cepat. Definitely worth every penny!"</p>
                    </div>
                    <div class="testimonial-author">
                        <div class="author-image">
                            <img src="{{ asset('images/kopi6.jpg') }}" alt="Ani Wijaya">
                        </div>
                        <div class="author-info">
                            <h5>Muhammad Syahqi</h5>
                            <span>Barista</span>
                        </div>
                    </div>
                </div>
                <!-- Testimonial 3 -->
                <div class="testimonial">
                    <div class="testimonial-content">
                        <p>"Sebagai pemilik kafe, saya sangat memperhatikan kualitas kopi yang saya sajikan. Toho Coffee selalu menjadi pilihan utama kami karena kualitasnya yang konsisten dan respons positif dari pelanggan."</p>
                    </div>
                    <div class="testimonial-author">
                        <div class="author-image">
                            <img src="{{ asset('images/kopi6.jpg') }}" alt="Dimas Purnomo">
                        </div>
                        <div class="author-info">
                            <h5>Nando</h5>
                            <span>Pemilik Kafe</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="testimonial-controls">
                <div class="control-dot active"></div>
                <div class="control-dot"></div>
                <div class="control-dot"></div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="cta-content">
            <h3>Dapatkan Kopi Pertama Anda</h3>
            <p>Bergabunglah dengan Toho Coffee.</p>
            <a href="{{ route('register') }}" class="cta-button">Daftar Sekarang</a>
        </div>
    </section>

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
                    <a href="https://www.instagram.com/tohocoffee.id/"><i class="fab fa-instagram"></i></a>
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
                    <li><a href="https://wa.me/6281397306005">Hubungi Kami</a></li>
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
    <a href="#" class="back-to-top">
        <i class="fas fa-arrow-up"></i>
    </a>

    <!-- JavaScript -->
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