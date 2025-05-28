<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Toho Coffee</title>
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
                <div class="user-icon">
                    <a href="{{ route('welcome') }}" class="register-btn">Kembali</a>
                </div>
            </div>
            <div class="hamburger">
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
    </header>

    <!-- Reset Password Form -->
    <div class="auth-container">
        <div class="auth-header">
            <h2>Reset Password</h2>
            <p>Masukkan password baru untuk akun Anda</p>
        </div>

        <!-- Alert untuk menampilkan pesan error -->
        @if ($errors->any())
            <div class="alert alert-error">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Alert untuk menampilkan pesan sukses -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}" class="auth-form">
            @csrf
            
            <!-- Hidden token and email fields -->
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ $email }}">
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" 
                       value="{{ old('email', $email) }}" readonly
                       style="background-color: #f8f9fa; cursor: not-allowed;">
                <div class="form-help">
                    <small>Email yang akan direset passwordnya</small>
                </div>
            </div>

            <div class="form-group">
                <label for="password">Password Baru</label>
                <div class="password-input-wrapper">
                    <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" 
                           placeholder="Masukkan password baru (minimal 6 karakter)" required>
                    <button type="button" class="password-toggle" onclick="togglePassword('password')">
                        <i class="fas fa-eye" id="password-eye"></i>
                    </button>
                </div>
                @error('password')
                    <span class="error-message">{{ $message }}</span>
                @enderror
                <div class="password-strength" id="password-strength"></div>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password</label>
                <div class="password-input-wrapper">
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" 
                           placeholder="Konfirmasi password baru" required>
                    <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">
                        <i class="fas fa-eye" id="password_confirmation-eye"></i>
                    </button>
                </div>
                @error('password_confirmation')
                    <span class="error-message">{{ $message }}</span>
                @enderror
                <div class="form-help">
                    <small>Masukkan kembali password yang sama</small>
                </div>
            </div>

            <div class="password-requirements">
                <h4>Persyaratan Password:</h4>
                <ul class="requirements-list">
                    <li id="length-req"><i class="fas fa-times"></i> Minimal 6 karakter</li>
                    <li id="match-req"><i class="fas fa-times"></i> Password harus sama</li>
                </ul>
            </div>
            
            <button type="submit" class="btn btn-block" id="reset-btn">
                <i class="fas fa-key"></i>
                Reset Password
            </button>
        </form>

        <div class="form-actions">
            <div class="back-to-login">
                <p>Ingat password Anda? <a href="{{ route('login') }}">Login di sini</a></p>
            </div>
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

    <!-- Scripts -->
    @vite('resources/js/app.js')
    <script>
        // Password toggle functionality
        function togglePassword(fieldId) {
            const passwordField = document.getElementById(fieldId);
            const eyeIcon = document.getElementById(fieldId + '-eye');
            
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        }

        // Password strength and validation
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('password_confirmation');
        const lengthReq = document.getElementById('length-req');
        const matchReq = document.getElementById('match-req');
        const strengthIndicator = document.getElementById('password-strength');

        function updateRequirements() {
            const password = passwordInput.value;
            const confirmPassword = confirmPasswordInput.value;

            // Length requirement
            if (password.length >= 6) {
                lengthReq.innerHTML = '<i class="fas fa-check"></i> Minimal 6 karakter';
                lengthReq.classList.add('valid');
            } else {
                lengthReq.innerHTML = '<i class="fas fa-times"></i> Minimal 6 karakter';
                lengthReq.classList.remove('valid');
            }

            // Match requirement
            if (password && confirmPassword && password === confirmPassword) {
                matchReq.innerHTML = '<i class="fas fa-check"></i> Password harus sama';
                matchReq.classList.add('valid');
            } else {
                matchReq.innerHTML = '<i class="fas fa-times"></i> Password harus sama';
                matchReq.classList.remove('valid');
            }

            // Password strength
            updatePasswordStrength(password);
        }

        function updatePasswordStrength(password) {
            let strength = 0;
            let strengthText = '';
            let strengthClass = '';

            if (password.length >= 6) strength++;
            if (password.match(/[a-z]/)) strength++;
            if (password.match(/[A-Z]/)) strength++;
            if (password.match(/[0-9]/)) strength++;
            if (password.match(/[^a-zA-Z0-9]/)) strength++;

            switch (strength) {
                case 0:
                case 1:
                    strengthText = 'Sangat Lemah';
                    strengthClass = 'very-weak';
                    break;
                case 2:
                    strengthText = 'Lemah';
                    strengthClass = 'weak';
                    break;
                case 3:
                    strengthText = 'Sedang';
                    strengthClass = 'medium';
                    break;
                case 4:
                    strengthText = 'Kuat';
                    strengthClass = 'strong';
                    break;
                case 5:
                    strengthText = 'Sangat Kuat';
                    strengthClass = 'very-strong';
                    break;
            }

            if (password.length > 0) {
                strengthIndicator.innerHTML = `Kekuatan Password: <span class="${strengthClass}">${strengthText}</span>`;
                strengthIndicator.style.display = 'block';
            } else {
                strengthIndicator.style.display = 'none';
            }
        }

        passwordInput.addEventListener('input', updateRequirements);
        confirmPasswordInput.addEventListener('input', updateRequirements);

        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const password = passwordInput.value;
            const confirmPassword = confirmPasswordInput.value;

            if (password.length < 6) {
                e.preventDefault();
                alert('Password harus minimal 6 karakter');
                return false;
            }

            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Konfirmasi password tidak cocok');
                return false;
            }
        });
    </script>

    <style>
        .alert {
            padding: 16px 20px;
            margin-bottom: 24px;
            border-radius: 8px;
            font-size: 14px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }
        
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert-success::before {
            content: "✓";
            font-weight: bold;
            font-size: 16px;
            margin-top: 2px;
        }
        
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .alert-error::before {
            content: "⚠";
            font-weight: bold;
            font-size: 16px;
            margin-top: 2px;
        }
        
        .error-message {
            color: #dc3545;
            font-size: 12px;
            margin-top: 4px;
            display: block;
        }
        
        .is-invalid {
            border-color: #dc3545 !important;
            box-shadow: 0 0 0 2px rgba(220, 53, 69, 0.1);
        }
        
        .password-input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }
        
        .password-toggle {
            position: absolute;
            right: 12px;
            background: none;
            border: none;
            color: #6c757d;
            cursor: pointer;
            font-size: 14px;
            padding: 4px;
        }
        
        .password-toggle:hover {
            color: #333;
        }
        
        .password-strength {
            margin-top: 8px;
            font-size: 12px;
            display: none;
        }
        
        .password-strength .very-weak { color: #dc3545; }
        .password-strength .weak { color: #fd7e14; }
        .password-strength .medium { color: #ffc107; }
        .password-strength .strong { color: #198754; }
        .password-strength .very-strong { color: #0d6efd; }
        
        .password-requirements {
            background-color: #f8f9fa;
            padding: 16px;
            border-radius: 8px;
            margin-bottom: 24px;
            border-left: 4px solid #007bff;
        }
        
        .password-requirements h4 {
            margin: 0 0 12px 0;
            color: #333;
            font-size: 14px;
        }
        
        .requirements-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .requirements-list li {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 4px;
            font-size: 12px;
            color: #6c757d;
        }
        
        .requirements-list li.valid {
            color: #28a745;
        }
        
        .requirements-list li i {
            width: 12px;
            font-size: 10px;
        }
        
        .form-help {
            margin-top: 8px;
        }
        
        .form-help small {
            color: #6c757d;
            font-size: 12px;
            line-height: 1.4;
        }
        
        .form-actions {
            margin-top: 32px;
        }
        
        .back-to-login {
            text-align: center;
        }
        
        .back-to-login p {
            margin: 0;
            color: #6c757d;
        }
        
        .back-to-login a {
            color: #007bff;
            text-decoration: none;
            font-weight: 500;
        }
        
        .back-to-login a:hover {
            text-decoration: underline;
        }
        
        .btn .fas {
            margin-right: 8px;
        }
    </style>
</body>
</html>