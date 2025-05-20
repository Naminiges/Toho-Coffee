<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - TOHO</title>
    @vite('resources/css/style.css')
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <!-- Header -->
    <header>
        <div class="navbar">
            <div class="logo">
                <img src="/api/placeholder/40/40" alt="Toho Coffee Logo">
                <h1>Toho Coffee</h1>
            </div>
            <ul class="nav-links">
                <li><a href="#home">Beranda</a></li>
                <li><a href="#products">Produk</a></li>
            </ul>
            <div class="nav-actions">
                @auth
                    <div class="user-icon">
                        <i class="fas fa-user"></i>
                    </div>
                @else
                    <div class="auth-links">
                        <a href="{{ url('login') }}" class="login-btn">Login</a>
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

    <!-- Register Section -->
    <div class="auth-container">
        <div class="auth-header">
            <h2>Daftar Akun</h2>
            <p>Daftarkan diri Anda untuk menikmati berbagai keuntungan</p>
        </div>

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form id="register-form" class="auth-form" method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" placeholder="Masukkan nama lengkap Anda" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="Masukkan email Anda" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="password-toggle">
                    <input type="password" id="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required>
                    <i class="fas fa-eye toggle-password"></i>
                </div>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password</label>
                <div class="password-toggle">
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Masukkan password sekali lagi" required>
                    <i class="fas fa-eye toggle-password"></i>
                </div>
            </div>

            <button type="submit" class="btn btn-block">Daftar Sekarang</button>
        </form>

        <div class="form-divider">
            <span>atau daftar dengan</span>
        </div>

        <div class="social-auth">
            <a href="#" class="social-btn">
                <i class="fab fa-google"></i>
            </a>
            <a href="#" class="social-btn">
                <i class="fab fa-facebook-f"></i>
            </a>
            <a href="#" class="social-btn">
                <i class="fab fa-twitter"></i>
            </a>
        </div>

        <div class="form-footer">
            Sudah memiliki akun? <a href="{{ url('login') }}">Masuk di sini</a>
        </div>
    </div>

    <!-- Footer -->
    <footer id="contact">
        <div class="footer-content">
            <div class="footer-column">
                <div class="logo">
                    <img src="/api/placeholder/40/40" alt="Toho Coffee Logo">
                    <h1>Toho Coffee</h1>
                </div>
                <p>Kopi premium untuk pengalaman menikmati kopi terbaik di rumah ataupun di kafe Anda.</p>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            <div class="footer-column">
                <h4>Informasi</h4>
                <ul class="footer-links">
                    <li><a href="#">Tentang Kami</a></li>
                    <li><a href="#">Produk</a></li>
                    <li><a href="#">Blog</a></li>
                    <li><a href="#">Cara Pemesanan</a></li>
                    <li><a href="#">FAQ</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h4>Layanan Pelanggan</h4>
                <ul class="footer-links">
                    <li><a href="#">Hubungi Kami</a></li>
                    <li><a href="#">Kebijakan Pengembalian</a></li>
                    <li><a href="#">Syarat dan Ketentuan</a></li>
                    <li><a href="#">Kebijakan Privasi</a></li>
                    <li><a href="#">Metode Pembayaran</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h4>Kontak Kami</h4>
                <ul class="contact-info">
                    <li><span><i class="fas fa-map-marker-alt"></i></span> Jl. Kopi No. 123, Jakarta Selatan</li>
                    <li><span><i class="fas fa-phone"></i></span> +62 21 1234 5678</li>
                    <li><span><i class="fas fa-envelope"></i></span> info@tohocoffee.com</li>
                    <li><span><i class="fas fa-clock"></i></span> Senin - Jumat: 08.00 - 17.00</li>
                </ul>
            </div>
            <div class="footer-column">
                <h4>Newsletter</h4>
                <p>Berlangganan newsletter kami untuk mendapatkan info dan penawaran terbaru.</p>
                <div class="newsletter">
                    <input type="email" placeholder="Email Anda...">
                    <button>Berlangganan</button>
                </div>
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

    @vite('resources/js/app.js')
    <script>
        // Toggle password visibility
        document.querySelectorAll('.toggle-password').forEach(function(eye) {
            eye.addEventListener('click', function() {
                const passwordField = this.previousElementSibling;
                const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordField.setAttribute('type', type);
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });
        });
    </script>
</body>
</html>