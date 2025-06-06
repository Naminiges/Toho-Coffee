<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Toho Coffee</title>
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
                <li><a href="{{ route('welcome') }}">Beranda</a></li>
                <li><a href="{{ route('products') }}">Katalog</a></li>
            </ul>
            <div class="nav-actions">
                <div class="auth-links">
                    <a href="{{ route('login') }}" class="register-btn">Kembali</a>
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

        <!-- Alert Messages -->
        <div id="alert-container"></div>

        <form id="forgot-password-form" class="auth-form">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" 
                       placeholder="Masukkan email Gmail Anda" required>
                <div class="form-help">
                    <small>Masukkan email asli yang terdaftar (harus Gmail)</small>
                </div>
            </div>
            
            <button type="submit" class="btn btn-block" id="submit-btn">
                <i class="fas fa-paper-plane"></i>
                Kirim Link Reset Password
            </button>
        </form>

        <div class="form-actions">
            <div class="form-footer">
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

    <script>
        document.getElementById('forgot-password-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const form = this;
            const submitBtn = document.getElementById('submit-btn');
            const alertContainer = document.getElementById('alert-container');
            const email = document.getElementById('email').value;
            
            // Disable submit button
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengirim...';
            
            // Clear previous alerts
            alertContainer.innerHTML = '';
            
            fetch('{{ route("password.email") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ email: email })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alertContainer.innerHTML = `
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle"></i>
                            <div>
                                <strong>Berhasil!</strong><br>
                                ${data.message}
                            </div>
                        </div>
                    `;
                    form.reset();
                } else {
                    let errorMessage = data.message || 'Terjadi kesalahan';
                    if (data.errors) {
                        const errorList = Object.values(data.errors).flat();
                        errorMessage = errorList.join('<br>');
                    }
                    alertContainer.innerHTML = `
                        <div class="alert alert-error">
                            <i class="fas fa-exclamation-triangle"></i>
                            <div>
                                <strong>Error!</strong><br>
                                ${errorMessage}
                            </div>
                        </div>
                    `;
                }
                
                // Scroll to alert
                alertContainer.scrollIntoView({ behavior: 'smooth', block: 'center' });
            })
            .catch(error => {
                console.error('Error:', error);
                alertContainer.innerHTML = `
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-triangle"></i>
                        <div>
                            <strong>Error!</strong><br>
                            Terjadi kesalahan jaringan. Silakan coba lagi.
                        </div>
                    </div>
                `;
                alertContainer.scrollIntoView({ behavior: 'smooth', block: 'center' });
            })
            .finally(() => {
                // Re-enable submit button
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-paper-plane"></i> Kirim Link Reset Password';
            });
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
            animation: slideIn 0.3s ease-out;
        }
        
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .alert i {
            font-size: 18px;
            margin-top: 2px;
        }
        
        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
        
        .fa-spin {
            animation: fa-spin 2s infinite linear;
        }
        
        @keyframes fa-spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
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
        
        .back-to-login, .back-to-register {
            text-align: center;
            margin-bottom: 16px;
        }
        
        .back-to-login p, .back-to-register p {
            margin: 0;
            color: #6c757d;
        }
        
        .back-to-login a, .back-to-register a {
            color: #007bff;
            text-decoration: none;
            font-weight: 500;
        }
        
        .back-to-login a:hover, .back-to-register a:hover {
            text-decoration: underline;
        }
    </style>
</body>
</html>