<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>404 - Halaman Tidak Ditemukan | TOHO Coffee</title>
    @vite('resources/css/style.css')
    <style>
        .error-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
            text-align: center;
            background-color: #f5f5f5;
        }

        .error-content {
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
        }

        .error-code {
            font-size: 120px;
            font-weight: bold;
            color: #2c3e50;
            margin: 0;
            line-height: 1;
        }

        .error-message {
            font-size: 24px;
            color: #34495e;
            margin: 20px 0;
        }

        .error-description {
            color: #7f8c8d;
            margin-bottom: 30px;
        }

        .back-button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #2c3e50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .back-button:hover {
            background-color: #34495e;
        }

        .error-icon {
            font-size: 80px;
            color: #e74c3c;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-content">
            <div class="error-icon">
                <i class="fas fa-exclamation-circle"></i>
            </div>
            <h1 class="error-code">404</h1>
            <h2 class="error-message">Halaman Tidak Ditemukan</h2>
            <p class="error-description">
                Maaf, halaman yang Anda cari tidak dapat ditemukan atau telah dipindahkan.
            </p>
            @auth
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin-dashboard') }}" class="back-button">
                        <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
                    </a>
                @elseif(auth()->user()->role === 'staff')
                    <a href="{{ route('staff-dashboard') }}" class="back-button">
                        <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
                    </a>
                @else
                    <a href="{{ route('user-katalog') }}" class="back-button">
                        <i class="fas fa-arrow-left"></i> Kembali ke Katalog
                    </a>
                @endif
            @else
                <a href="{{ route('welcome') }}" class="back-button">
                    <i class="fas fa-arrow-left"></i> Kembali ke Beranda
                </a>
            @endauth
        </div>
    </div>

    @vite('resources/js/script.js')
</body>
</html>