<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email - TOHO Coffee</title>
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
        </div>
    </header>

    <!-- Verification Section -->
    <div class="auth-container">
        <div class="verification-container">
            @auth
                <div class="verification-icon">
                    <i class="fas fa-envelope-open-text"></i>
                </div>
                
                <div class="auth-header">
                    <h2>Verifikasi Email Anda</h2>
                    <p>Kami telah mengirimkan link verifikasi ke alamat email Anda. Silakan cek kotak masuk atau folder spam.</p>
                </div>

                @if (session('resent'))
                    <div class="alert alert-success">
                        Link verifikasi baru telah dikirim ke alamat email Anda.
                    </div>
                @endif

                <div class="verification-info">
                    <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                    <p>Klik link verifikasi di email untuk mengaktifkan akun Anda.</p>
                </div>

                <div class="verification-actions">
                    <form method="POST" action="{{ route('verification.send') }}" id="resend-form">
                        @csrf
                        <button type="submit" class="btn btn-primary" id="resend-btn">
                            <span class="btn-text">Kirim Ulang Email</span>
                            <span class="btn-loader" style="display: none;">
                                <i class="fas fa-spinner fa-spin"></i> Mengirim...
                            </span>
                        </button>
                    </form>

                    <div class="mt-3">
                        <a href="{{ route('logout') }}" 
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                           class="btn btn-secondary">
                            Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>

                <div class="verification-tips">
                    <h4>Tips:</h4>
                    <ul>
                        <li>Periksa folder spam/junk jika email tidak ada di kotak masuk</li>
                        <li>Pastikan alamat email yang digunakan benar</li>
                        <li>Link verifikasi berlaku selama 60 menit</li>
                    </ul>
                </div>
            @else
                <!-- Show this when user is not authenticated -->
                <div class="verification-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                
                <div class="auth-header">
                    <h2>Sesi Berakhir</h2>
                    <p>Sesi login Anda telah berakhir. Silakan login kembali untuk melanjutkan proses verifikasi email.</p>
                </div>

                <div class="verification-actions">
                    <a href="{{ route('login') }}" class="btn btn-primary">
                        Login Kembali
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-secondary">
                        Daftar Akun Baru
                    </a>
                </div>
            @endauth
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="copyright">
            <p>&copy; 2025 Toho Coffee. All Rights Reserved.</p>
        </div>
    </footer>

    <script>
        // Only run this script if user is authenticated
        @auth
        // Handle resend verification email
        document.getElementById('resend-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const btn = document.getElementById('resend-btn');
            const btnText = btn.querySelector('.btn-text');
            const btnLoader = btn.querySelector('.btn-loader');
            
            // Show loading state
            btnText.style.display = 'none';
            btnLoader.style.display = 'inline-block';
            btn.disabled = true;
            
            // Send AJAX request
            fetch('{{ route("verification.send") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message
                    const alertDiv = document.createElement('div');
                    alertDiv.className = 'alert alert-success';
                    alertDiv.textContent = data.message;
                    
                    const container = document.querySelector('.verification-container');
                    const existingAlert = container.querySelector('.alert');
                    if (existingAlert) {
                        existingAlert.remove();
                    }
                    
                    container.insertBefore(alertDiv, container.querySelector('.verification-info'));
                    
                    // Remove alert after 5 seconds
                    setTimeout(() => {
                        alertDiv.remove();
                    }, 5000);
                } else {
                    // Show error message
                    const alertDiv = document.createElement('div');
                    alertDiv.className = 'alert alert-danger';
                    alertDiv.textContent = data.message || 'Terjadi kesalahan';
                    
                    const container = document.querySelector('.verification-container');
                    const existingAlert = container.querySelector('.alert');
                    if (existingAlert) {
                        existingAlert.remove();
                    }
                    
                    container.insertBefore(alertDiv, container.querySelector('.verification-info'));
                    
                    setTimeout(() => {
                        alertDiv.remove();
                    }, 5000);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                
                const alertDiv = document.createElement('div');
                alertDiv.className = 'alert alert-danger';
                alertDiv.textContent = 'Terjadi kesalahan saat mengirim email';
                
                const container = document.querySelector('.verification-container');
                const existingAlert = container.querySelector('.alert');
                if (existingAlert) {
                    existingAlert.remove();
                }
                
                container.insertBefore(alertDiv, container.querySelector('.verification-info'));
                
                setTimeout(() => {
                    alertDiv.remove();
                }, 5000);
            })
            .finally(() => {
                // Reset button state
                btnText.style.display = 'inline-block';
                btnLoader.style.display = 'none';
                btn.disabled = false;
            });
        });
        @endauth
    </script>

    <style>
        .verification-container {
            max-width: 500px;
            margin: 0 auto;
            text-align: center;
        }
        
        .verification-icon {
            font-size: 4rem;
            color: #8B4513;
            margin-bottom: 2rem;
        }
        
        .verification-icon .fa-exclamation-triangle {
            color: #ffc107;
        }
        
        .verification-info {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 8px;
            margin: 2rem 0;
        }
        
        .verification-info p {
            margin-bottom: 0.5rem;
        }
        
        .verification-actions {
            margin: 2rem 0;
        }
        
        .verification-actions .btn {
            margin: 0.5rem;
        }
        
        .verification-tips {
            text-align: left;
            background: #e9ecef;
            padding: 1.5rem;
            border-radius: 8px;
            margin-top: 2rem;
        }
        
        .verification-tips h4 {
            margin-bottom: 1rem;
            color: #495057;
        }
        
        .verification-tips ul {
            margin: 0;
            padding-left: 1.5rem;
        }
        
        .verification-tips li {
            margin-bottom: 0.5rem;
            color: #6c757d;
        }
        
        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
            color: white;
            padding: 12px 24px;
            border-radius: 6px;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }
        
        .btn-secondary:hover {
            background-color: #545b62;
            border-color: #4e555b;
        }
    </style>
</body>
</html>