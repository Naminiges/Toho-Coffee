<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - TOHO</title>
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
                <div class="auth-links">
                    <a href="{{ route('login') }}" class="login-btn">Login</a>
                </div>
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
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <form id="register-form" class="auth-form" method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" 
                       value="{{ old('name') }}" placeholder="Masukkan nama lengkap Anda" required>
                @error('name')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                       value="{{ old('email') }}" placeholder="Masukkan email Anda" required>
                @error('email')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="password-toggle">
                    <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" 
                           placeholder="Minimal 6 karakter" required>
                    <i class="fas fa-eye toggle-password"></i>
                </div>
                @error('password')
                    <span class="error-message">{{ $message }}</span>
                @enderror
                <div class="password-strength">
                    <div class="strength-bar">
                        <div class="strength-fill"></div>
                    </div>
                    <span class="strength-text">Kekuatan password</span>
                </div>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password</label>
                <div class="password-toggle">
                    <input type="password" id="password_confirmation" name="password_confirmation" 
                           class="form-control" placeholder="Masukkan password sekali lagi" required>
                    <i class="fas fa-eye toggle-password"></i>
                </div>
                <span class="error-message" id="password-match-error"></span>
            </div>

            <button type="submit" class="btn btn-block" id="register-btn">
                <span class="btn-text">Daftar Sekarang</span>
                <span class="btn-loader" style="display: none;">
                    <i class="fas fa-spinner fa-spin"></i> Memproses...
                </span>
            </button>
        </form>

        <div class="form-divider">
            <span>atau daftar dengan</span>
        </div>

        <div class="social-auth">
            <a href="#" class="social-btn">
                <i class="fab fa-google"></i>
            </a>
        </div>

        <div class="form-footer">
            Sudah memiliki akun? <a href="{{ route('login') }}">Masuk di sini</a>
        </div>
    </div>

    <!-- Footer -->
    <footer id="contact">
        <div class="footer-content">
            <div class="footer-column">
                <div class="logo">
                    <img src="{{ asset('images/logo-toho.jpg') }}" alt="Toho Coffee Logo">
                    <h1>TOHO Coffee</h1>
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

        // Password strength checker
        const passwordInput = document.getElementById('password');
        const strengthBar = document.querySelector('.strength-fill');
        const strengthText = document.querySelector('.strength-text');

        passwordInput.addEventListener('input', function() {
            const password = this.value;
            const strength = checkPasswordStrength(password);
            
            strengthBar.style.width = strength.percentage + '%';
            strengthBar.className = 'strength-fill strength-' + strength.level;
            strengthText.textContent = strength.text;
        });

        function checkPasswordStrength(password) {
            let score = 0;
            let feedback = [];

            if (password.length >= 8) score += 25;
            else feedback.push('minimal 8 karakter');

            if (/[a-z]/.test(password)) score += 25;
            else feedback.push('huruf kecil');

            if (/[A-Z]/.test(password)) score += 25;
            else feedback.push('huruf besar');

            if (/[0-9]/.test(password)) score += 25;
            else feedback.push('angka');

            let level, text;
            if (score < 50) {
                level = 'weak';
                text = 'Lemah - Tambahkan: ' + feedback.join(', ');
            } else if (score < 75) {
                level = 'medium';
                text = 'Sedang - Bisa ditingkatkan';
            } else {
                level = 'strong';
                text = 'Kuat - Password bagus!';
            }

            return {
                percentage: score,
                level: level,
                text: text
            };
        }

        // Password confirmation checker
        const confirmPasswordInput = document.getElementById('password_confirmation');
        const passwordMatchError = document.getElementById('password-match-error');

        confirmPasswordInput.addEventListener('input', function() {
            const password = passwordInput.value;
            const confirmPassword = this.value;

            if (confirmPassword && password !== confirmPassword) {
                passwordMatchError.textContent = 'Konfirmasi password tidak cocok';
                this.classList.add('is-invalid');
            } else {
                passwordMatchError.textContent = '';
                this.classList.remove('is-invalid');
            }
        });

        // Form submission with loading state
        document.getElementById('register-form').addEventListener('submit', function(e) {
            const password = passwordInput.value;
            const confirmPassword = confirmPasswordInput.value;
            const termsCheckbox = document.getElementById('terms');
            
            // Validate password match
            if (password !== confirmPassword) {
                e.preventDefault();
                passwordMatchError.textContent = 'Konfirmasi password tidak cocok';
                confirmPasswordInput.classList.add('is-invalid');
                return;
            }

            // Validate terms acceptance
            if (!termsCheckbox.checked) {
                e.preventDefault();
                alert('Anda harus menyetujui Syarat dan Ketentuan untuk melanjutkan.');
                return;
            }

            // Show loading state
            const registerBtn = document.getElementById('register-btn');
            const btnText = registerBtn.querySelector('.btn-text');
            const btnLoader = registerBtn.querySelector('.btn-loader');
            
            btnText.style.display = 'none';
            btnLoader.style.display = 'inline-block';
            registerBtn.disabled = true;
        });

        // Real-time email validation
        const emailInput = document.getElementById('email');
        emailInput.addEventListener('blur', function() {
            const email = this.value;
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            
            if (email && !emailRegex.test(email)) {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
            }
        });
    </script>

    <style>
        .alert {
            padding: 12px 16px;
            margin-bottom: 20px;
            border-radius: 4px;
            font-size: 14px;
        }
        
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .error-message {
            color: #dc3545;
            font-size: 12px;
            margin-top: 4px;
            display: block;
        }
        
        .is-invalid {
            border-color: #dc3545 !important;
        }
        
        .password-toggle {
            position: relative;
        }
        
        .password-toggle .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #666;
        }
        
        .password-toggle .toggle-password:hover {
            color: #333;
        }
        
        .password-strength {
            margin-top: 8px;
        }
        
        .strength-bar {
            height: 4px;
            background-color: #e9ecef;
            border-radius: 2px;
            overflow: hidden;
        }
        
        .strength-fill {
            height: 100%;
            transition: all 0.3s ease;
            border-radius: 2px;
        }
        
        .strength-weak {
            background-color: #dc3545;
        }
        
        .strength-medium {
            background-color: #ffc107;
        }
        
        .strength-strong {
            background-color: #28a745;
        }
        
        .strength-text {
            font-size: 12px;
            margin-top: 4px;
            display: block;
        }
        
        .checkbox-container {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            font-size: 14px;
            line-height: 1.4;
            cursor: pointer;
        }
        
        .checkbox-container input[type="checkbox"] {
            width: auto;
            margin: 0;
            margin-top: 2px;
        }
        
        .terms-link {
            color: #007bff;
            text-decoration: none;
        }
        
        .terms-link:hover {
            text-decoration: underline;
        }
        
        .btn-loader {
            display: none;
        }
        
        .btn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }
    </style>
</body>
</html>