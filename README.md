# TOHO Coffee - Sistem Manajemen Kafe

## Introduction
Pickup Order System Wesbite TOHO Coffee adalah sistem pickup order kafe yang dikembangkan untuk mengelola operasional kafe, termasuk manajemen produk, pesanan, pelanggan, dan laporan penjualan. Sistem ini dirancang dengan arsitektur web modern menggunakan Laravel framework dan menyediakan antarmuka yang intuitif untuk admin, staff, dan pelanggan. Sistem ini juga terintegrasi dengan Google OAuth untuk autentikasi pengguna.

### Fitur Utama
- **Autentikasi Multi-platform**: Login dengan email/password dan Google OAuth
- **Manajemen Produk**: Pengelolaan menu, kategori, dan stok produk
- **Sistem Pesanan**: Proses pemesanan online dan manajemen pesanan
- **Manajemen Pengguna**: Pengelolaan admin, staff, dan pelanggan
- **Laporan Penjualan**: Analisis penjualan dan laporan keuangan
- **Keranjang Belanja**: Sistem keranjang belanja untuk pelanggan
- **Dashboard Admin**: Tampilan statistik dan metrik penting

### Prerequisites
- PHP >= 8.1
- Composer
- MySQL >= 5.7
- Node.js & NPM
- Web Server (Apache/Nginx)
- Google Cloud Platform Account
- Mailtrap.io Account

### Installation Steps

1. **Clone Repository**
   ```bash
   git clone [https://github.com/Naminiges/Toho-Coffee.git]
   cd toho-coffee
   ```

2. **Install Dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment Setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database Configuration**
   - Buat database baru di MySQL
   - Update file `.env` dengan konfigurasi database:
     ```
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=toho_coffee
     DB_USERNAME=your_username
     DB_PASSWORD=your_password
     ```

5. **Google OAuth Configuration**
   - Buat project di [Google Cloud Console](https://console.cloud.google.com)
   - Aktifkan Google+ API
   - Buat OAuth 2.0 credentials
   - Update file `.env` dengan kredensial Google:
     ```
     GOOGLE_CLIENT_ID=your_client_id
     GOOGLE_CLIENT_SECRET=your_client_secret
     GOOGLE_REDIRECT_URI=http://your-domain/auth/google/callback
     ```

6. **Mailtrap Configuration**
   - Buat akun di [Mailtrap.io](https://mailtrap.io)
   - Buat inbox baru untuk project
   - Update file `.env` dengan konfigurasi Mailtrap:
     ```
     MAIL_MAILER=smtp
     MAIL_HOST=smtp.mailtrap.io
     MAIL_PORT=2525
     MAIL_USERNAME=your_mailtrap_username
     MAIL_PASSWORD=your_mailtrap_password
     MAIL_FROM_ADDRESS=noreply@tohocoffee.com
     MAIL_FROM_NAME="${APP_NAME}"
     ```

7. **Database Migration & Seeding**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

9. **Compile Assets**
   ```bash
   npm run dev
   ```

10. **Start Development Server**
    ```bash
    php artisan serve
    ```

### Default Login Credentials

#### Admin
- Email: admintoho@gmail.com
- Password: admin123

#### Staff
- Email: stafftoho@gmail.com
- Password: staff123

## Project Structure

toho-coffee/
├── app/
│ ├── Http/
│ │ ├── Controllers/
│ │ │ └── Auth/
│ │ └── Middleware/
│ ├── Models/
│ ├── Notifications/
│ └── Providers/
├── config/
│ ├── services.php
│ └── mail.php
├── database/
│ ├── migrations/
│ └── seeders/
├── public/
│ ├── css/
│ ├── js/
│ └── images/
├── resources/
│ ├── css/
│ ├── js/
│ └── views/
│ ├── auth/
│ ├── admin/
│ ├── staff/
│ └── user/
└── routes/
└── web.php

## Features & Usage

### Authentication & Email
- Login dengan email/password
- Login dengan Google OAuth
- Verifikasi email
- Reset password via email
- Notifikasi email untuk:
  - Konfirmasi pesanan
  - Status pesanan
  - Reset password
  - Verifikasi akun
- 404 Fallback Page

### Admin Panel
- Dashboard dengan statistik penjualan
- Manajemen produk dan kategori
- Manajemen pesanan
- Manajemen pengguna (admin, staff, pelanggan)
- Laporan penjualan dan analisis

### Staff Panel
- Manajemen produk
- Pemrosesan pesanan
- Update status pesanan

### Customer Panel
- Katalog produk
- Keranjang belanja
- Riwayat pesanan
- Checkout Payment
- Profil pengguna

## Contributors

### Development Team
- [Putera Nami Shiddieqy] - Project Manager
- [Wynn Thomas Salim] - Backend Developer
- [Raswan Haqqi Al Amwi] - Frontend Developer
- [Fauzan Khair Siregar] - UI/UX Designer

### Special Thanks
- [Fando Pasaribu] - CEO TOHO Coffee

## Sources & References

### Technologies Used
- [Laravel](https://laravel.com) - PHP Framework
- [Laravel Socialite](https://laravel.com/docs/socialite) - OAuth Authentication
- [Google Cloud Platform](https://cloud.google.com) - OAuth Provider
- [Mailtrap.io](https://mailtrap.io) - Email Testing Platform
- [MySQL](https://www.mysql.com) - Database
- [Bootstrap](https://getbootstrap.com) - CSS Framework
- [Font Awesome](https://fontawesome.com) - Icons
- [Chart.js](https://www.chartjs.org) - Charts & Graphs

### Documentation
- [Laravel Documentation](https://laravel.com/docs)
- [Laravel Socialite Documentation](https://laravel.com/docs/socialite)
- [Google OAuth Documentation](https://developers.google.com/identity/protocols/oauth2)
- [Laravel Mail Documentation](https://laravel.com/docs/mail)
- [Mailtrap Documentation](https://mailtrap.io/docs)
- [Bootstrap Documentation](https://getbootstrap.com/docs)
- [MySQL Documentation](https://dev.mysql.com/doc)
- [Font Awesome Documentation](https://fontawesome.com/docs)

## Security Considerations
- Implementasi OAuth 2.0 dengan Google
- CSRF Protection
- Secure Password Hashing
- Session Management
- Rate Limiting
- Input Validation
- Email Verification
- Secure Email Configuration

## Support
For support, create an issue in the repository.