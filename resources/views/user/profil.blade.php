<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pengguna - TOHO Coffee</title>
    @vite('resources/css/style.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Header -->
    <header>
        <div class="navbar">
            <div class="logo">
                <img src="" alt="TOHO Coffee Logo">
                <h1>TOHO Coffee</h1>
            </div>
            <ul class="nav-links">
                <li><a href="index.html">Beranda</a></li>
                <li><a href="menu.html">Produk</a></li>
            </ul>
            <div class="nav-actions">
                <i class="fas fa-shopping-cart cart-icon">
                    <span class="cart-count">3</span>
                </i>
                <i class="fas fa-user user-icon"></i>
            </div>
            <div class="hamburger">
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
    </header>

    <!-- Page Header -->
    <div class="page-header">
        <h2>Profil Saya</h2>
    </div>

    <div class="container">
        <!-- Breadcrumb -->
        <ul class="breadcrumb">
            <li><a href="index.html">Beranda</a></li>
            <li>Profil Saya</li>
        </ul>

        <div class="profile-container">
            <!-- Sidebar -->
            <div class="profile-sidebar">
                <div class="profile-header">
                    <div class="profile-avatar">
                        <img src="" alt="Profile Picture">
                    </div>
                    <h3 class="profile-name">John Doe</h3>
                    <p class="profile-email">john.doe@example.com</p>
                </div>

                <ul class="profile-menu">
                    <li>
                        <a href="#" class="active">
                            <i class="fas fa-user"></i>
                            Informasi Pribadi
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fas fa-shopping-bag"></i>
                            Pesanan Saya
                        </a>
                    </li>
                    <li>
                    <li>
                        <a href="#" class="logout">
                            <i class="fas fa-sign-out-alt"></i>
                            Logout
                        </a>
                    </li>
                </ul>

                <div class="profile-stats">
                    <div class="stat-item">
                        <div class="stat-value">12</div>
                        <div class="stat-label">Pesanan</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">5</div>
                        <div class="stat-label">Wishlist</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">3</div>
                        <div class="stat-label">Alamat</div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="profile-content">
                <!-- Personal Information -->
                <div class="profile-section">
                    <h3>Informasi Pribadi</h3>
                    <form id="profileForm">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="firstName">Nama Depan</label>
                                <input type="text" id="firstName" class="form-control" value="John" required>
                            </div>
                            <div class="form-group">
                                <label for="lastName">Nama Belakang</label>
                                <input type="text" id="lastName" class="form-control" value="Doe" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" class="form-control" value="john.doe@example.com" required>
                        </div>

                        <div class="form-group">
                            <label for="phone">Nomor Telepon</label>
                            <input type="tel" id="phone" class="form-control" value="+62 812 3456 7890" required>
                        </div>

                        <div class="form-group">
                            <label for="birthDate">Tanggal Lahir</label>
                            <input type="date" id="birthDate" class="form-control" value="1990-01-01">
                        </div>

                        <div class="form-group">
                            <label>Jenis Kelamin</label>
                            <div style="display: flex; gap: 20px;">
                                <label style="display: flex; align-items: center; gap: 5px;">
                                    <input type="radio" name="gender" value="male" checked>
                                    Laki-laki
                                </label>
                                <label style="display: flex; align-items: center; gap: 5px;">
                                    <input type="radio" name="gender" value="female">
                                    Perempuan
                                </label>
                            </div>
                        </div>

                        <div class="profile-actions">
                            <button type="button" class="btn btn-cancel">Batal</button>
                            <button type="submit" class="btn">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>

                <!-- Change Password -->
                <div class="profile-section">
                    <h3>Ubah Password</h3>
                    <form id="passwordForm">
                        <div class="form-group">
                            <label for="currentPassword">Password Saat Ini</label>
                            <div class="password-toggle">
                                <input type="password" id="currentPassword" class="form-control" required>
                                <i class="fas fa-eye"></i>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="newPassword">Password Baru</label>
                            <div class="password-toggle">
                                <input type="password" id="newPassword" class="form-control" required>
                                <i class="fas fa-eye"></i>
                            </div>
                            <div class="validation-message">
                                Password harus minimal 8 karakter dan mengandung huruf besar, huruf kecil, angka, dan karakter khusus
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="confirmPassword">Konfirmasi Password Baru</label>
                            <div class="password-toggle">
                                <input type="password" id="confirmPassword" class="form-control" required>
                                <i class="fas fa-eye"></i>
                            </div>
                        </div>

                        <div class="profile-actions">
                            <button type="button" class="btn btn-cancel">Batal</button>
                            <button type="submit" class="btn">Ubah Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <div class="footer-column">
                <h4>TOHO Coffee</h4>
                <p>Kopi berkualitas dari petani lokal terbaik Indonesia langsung ke cangkir Anda.</p>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            
            <div class="footer-column">
                <h4>Menu</h4>
                <ul class="footer-links">
                    <li><a href="#">Kopi</a></li>
                    <li><a href="#">Teh</a></li>
                    <li><a href="#">Snack</a></li>
                    <li><a href="#">Merchandise</a></li>
                </ul>
            </div>
            
            <div class="footer-column">
                <h4>Informasi</h4>
                <ul class="footer-links">
                    <li><a href="#">Tentang Kami</a></li>
                    <li><a href="#">Karier</a></li>
                    <li><a href="#">Blog</a></li>
                    <li><a href="#">Kontak</a></li>
                </ul>
            </div>
            
            <div class="footer-column">
                <h4>Bantuan</h4>
                <ul class="footer-links">
                    <li><a href="#">FAQ</a></li>
                    <li><a href="#">Pengiriman</a></li>
                    <li><a href="#">Pengembalian</a></li>
                    <li><a href="#">Kebijakan Privasi</a></li>
                </ul>
            </div>
        </div>
        
        <div class="copyright">
            <p>&copy; 2024 TOHO Coffee. All rights reserved.</p>
        </div>
    </footer>

    <a href="#" class="back-to-top">
        <i class="fas fa-arrow-up"></i>
    </a>

    @vite('resources/js/script.js')
</body>
</html>