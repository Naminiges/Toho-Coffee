<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Green Garden</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/css/style.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
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
                <li><a href="{{ route('welcome') }}">Beranda</a></li>
                <li><a href="#products">Produk</a></li>
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

    <!-- Forgot Password Form -->
    <div class="auth-container">
        <div class="auth-header">
            <h2>Lupa Password</h2>
            <p>Masukkan email Anda untuk menerima link reset password</p>
        </div>

        <!-- Alert untuk menampilkan pesan -->
        <div id="alert-container" style="display: none;">
            <div id="alert-message" class="alert"></div>
        </div>

        <form id="forgot-password-form" class="auth-form">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" 
                       placeholder="Masukkan email Anda" required>
                <span class="error-message" id="email-error"></span>
                <div class="form-help">
                    <small>Pastikan email yang Anda masukkan sesuai dengan email yang terdaftar di akun Anda.</small>
                </div>
            </div>
            
            <button type="submit" class="btn btn-block" id="forgot-btn">
                <span class="btn-text">
                    <i class="fas fa-paper-plane"></i>
                    Kirim Link Reset
                </span>
                <span class="btn-loader" style="display: none;">
                    <i class="fas fa-spinner fa-spin"></i> Mengirim...
                </span>
            </button>
        </form>

        <div class="form-actions">
            <div class="back-to-login">
                <p>Ingat password Anda? <a href="{{ route('login') }}">Login di sini</a></p>
            </div>
            
            <div class="help-section">
                <h4>Butuh bantuan?</h4>
                <ul class="help-list">
                    <li><i class="fas fa-check-circle"></i> Periksa folder spam/junk email Anda</li>
                    <li><i class="fas fa-check-circle"></i> Link reset akan dikirim dalam 1-2 menit</li>
                    <li><i class="fas fa-check-circle"></i> Link berlaku selama 60 menit</li>
                </ul>
                <p class="contact-support">
                    Masih mengalami masalah? 
                    <a href="mailto:support@tohocoffee.com">Hubungi Support</a>
                </p>
            </div>
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

    <!-- Scripts -->
    @vite('resources/js/app.js')
    <script>
        // Setup CSRF token for AJAX requests
        window.Laravel = {
            csrfToken: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        };

        // Forgot password form submission
        document.getElementById('forgot-password-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const forgotBtn = document.getElementById('forgot-btn');
            const btnText = forgotBtn.querySelector('.btn-text');
            const btnLoader = forgotBtn.querySelector('.btn-loader');
            const emailInput = document.getElementById('email');
            
            // Clear previous errors
            document.getElementById('email-error').textContent = '';
            document.getElementById('alert-container').style.display = 'none';
            emailInput.classList.remove('is-invalid');
            
            // Validate email format
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(emailInput.value)) {
                document.getElementById('email-error').textContent = 'Format email tidak valid';
                emailInput.classList.add('is-invalid');
                return;
            }
            
            // Show loading state
            btnText.style.display = 'none';
            btnLoader.style.display = 'inline-block';
            forgotBtn.disabled = true;
            
            fetch('{{ route("password.email") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': window.Laravel.csrfToken,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert('success', data.message);
                    emailInput.value = '';
                    
                    // Show success state on button
                    setTimeout(() => {
                        btnText.innerHTML = '<i class="fas fa-check-circle"></i> Link Terkirim';
                        btnText.style.display = 'inline-block';
                        btnLoader.style.display = 'none';
                        forgotBtn.disabled = false;
                        
                        // Reset button after 3 seconds
                        setTimeout(() => {
                            btnText.innerHTML = '<i class="fas fa-paper-plane"></i> Kirim Link Reset';
                        }, 3000);
                    }, 1000);
                } else {
                    if (data.errors) {
                        // Show field-specific errors
                        Object.keys(data.errors).forEach(field => {
                            const errorElement = document.getElementById(field + '-error');
                            if (errorElement) {
                                errorElement.textContent = data.errors[field][0];
                                if (field === 'email') {
                                    emailInput.classList.add('is-invalid');
                                }
                            }
                        });
                    } else {
                        showAlert('error', data.message);
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('error', 'Terjadi kesalahan sistem. Silakan coba lagi.');
            })
            .finally(() => {
                // Reset button state if not success
                if (!forgotBtn.querySelector('.btn-text').innerHTML.includes('check-circle')) {
                    btnText.style.display = 'inline-block';
                    btnLoader.style.display = 'none';
                    forgotBtn.disabled = false;
                }
            });
        });

        function showAlert(type, message) {
            const alertContainer = document.getElementById('alert-container');
            const alertMessage = document.getElementById('alert-message');
            
            alertMessage.textContent = message;
            alertMessage.className = `alert alert-${type}`;
            alertContainer.style.display = 'block';
            
            // Scroll to alert
            alertContainer.scrollIntoView({ behavior: 'smooth', block: 'center' });
            
            // Auto hide after 8 seconds for success messages
            if (type === 'success') {
                setTimeout(() => {
                    alertContainer.style.display = 'none';
                }, 8000);
            }
        }

        // Email validation on input
        document.getElementById('email').addEventListener('input', function() {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            const errorElement = document.getElementById('email-error');
            
            if (this.value && !emailRegex.test(this.value)) {
                this.classList.add('is-invalid');
                errorElement.textContent = 'Format email tidak valid';
            } else {
                this.classList.remove('is-invalid');
                errorElement.textContent = '';
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
            align-items: center;
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
            margin-bottom: 32px;
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
        
        .help-section {
            background-color: #f8f9fa;
            padding: 24px;
            border-radius: 8px;
            border-left: 4px solid #007bff;
        }
        
        .help-section h4 {
            margin: 0 0 16px 0;
            color: #333;
            font-size: 16px;
        }
        
        .help-list {
            list-style: none;
            padding: 0;
            margin: 0 0 16px 0;
        }
        
        .help-list li {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 8px;
            font-size: 14px;
            color: #555;
        }
        
        .help-list i {
            color: #28a745;
            font-size: 12px;
        }
        
        .contact-support {
            margin: 0;
            font-size: 14px;
            color: #6c757d;
        }
        
        .contact-support a {
            color: #007bff;
            text-decoration: none;
            font-weight: 500;
        }
        
        .contact-support a:hover {
            text-decoration: underline;
        }
        
        .btn-loader {
            display: none;
        }
        
        .btn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }
        
        .btn .fas {
            margin-right: 8px;
        }
    </style>
</body>
</html>