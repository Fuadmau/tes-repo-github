<?php
session_start();
$jumlah_keranjang = isset($_SESSION['cart'])
    ? array_sum(array_column($_SESSION['cart'], 'qty'))
    : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adiva cell</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/feather-icons"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="navbar">
        <a href="#" class="navbar-logo">Dina<span>Ponsel</span></a>

        <div class="navbar-nav">
            <a href="#home">Home</a>
            <a href="#about">Tentang kami</a>
            <a href="#daftar">Menu</a>
            <a href="#lokasi">Lokasi</a>
            <a href="index.php">Login</a>
            <a href="https://wa.me/6282181472950?text=Halo,%20saya%20tertarik%20dengan%20produk%20Anda" class="contact-link">kontak</a>
            <a href="#" class="cart-icon">
                <i data-feather="shopping-cart"></i>
                <?php if ($jumlah_keranjang > 0): ?>
                    <span class="cart-count"><?= $jumlah_keranjang ?></span>
                <?php endif; ?>
            </a>
        </div>
        <div class="navbar-extra">
            <a id="menu">
                <i data-feather="menu"></i>
            </a>
        </div>
    </nav>
    <section class="hero" id="home">
        <main class="content">
            <h1>Mari Nikmati<span> Kuota Murah</span></h1>
            <p>Beli paket data internet murah isi pulsa, data paket , top up e wallet dan token PLN tanpa ribet bisa order tanpa harus datang ke konter</p>
        </main>
    </section>
    <section id="about" class="about">
        <h2><span>Tentang</span> Kami</h2>
        <div class="row">
            <div class="about-img">
                <img src="img/about.jpg" alt="Tentang Kami">
            </div>
            <div class="content">
                <h3>Kenapa memilih kuota kami</h3>
                <p>DinaPonsel adalah situs website pulsa, kuota, top up dan token pln termurah serta terlengkap dengan pelayanan operator 24 jam, untuk memudahkan pembeli tanpa harus datang ke store offline</p>
                
            </div>
        </div>
    </section>
    <section id="daftar" class="daftar">
        <h2><span>Menu</span> Kami</h2>
        <p>Menyediakan paket data, token listrik dan E-wallet</p>
        <div class="row">
            <div class="menu-card">
                <img src="img/images.jpeg" alt="Paket" class="menu-card-img-paket">
                <h3 class="menu-card-title">Paket Data</h3>
                <a href="paket.php" class="cta">Beli disini</a>        
            </div>
            <div class="menu-card">
                <img src="img/pulsa.jpg" alt="Pulsa" class="menu-card-img-pulsa">
                <h3 class="menu-card-title">Pulsa</h3>
                <a href="pulsa.php" class="cta">Beli disini</a>        
            </div>
            <div class="menu-card">
                <img src="img/download.jpeg" alt="token" class="menu-card-img-token">
                <h3 class="menu-card-title">Token Listrik</h3>
                <a href="token.php" class="cta">Beli disini</a>        
            </div>
            <div class="menu-card">
                <img src="img/ewallet.jpeg" alt="E-wallet" class="menu-card-img-ewallet">
                <h3 class="menu-card-title">E-Wallet</h3>
                <a href="e_wallet.php" class="cta">Beli disini</a>        
            </div>
        </div>
    </section>
    <section id="lokasi" class="lokasi">
        <h2><span>Lokasi</span> Kami</h2>
        <div class="row">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3982.026653068475!2d98.74169719999999!3d3.5813517!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3031312993da2de5%3A0x6cdd7bf309ee3b5c!2sDina%20Ponsel!5e0!3m2!1sen!2sid!4v1764936773367!5m2!1sen!2sid"allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="map"></iframe>
        </div>
    </section>
    <footer>
        <div class="credit">
            <p>Created by <a>JAWA x MELAYU</a> | &copy; 2026.</p>
        </div>
    </footer>
    <!-- ========== SIDEBAR CART (SLIDE KANAN) ========== -->
<div id="cartSidebar" class="cart-sidebar">
    <h2>Keranjang</h2>

    <div class="cart-content">
        <?php if (!empty($_SESSION['cart'])): ?>
            <?php foreach ($_SESSION['cart'] as $id => $item): ?>
                <div class="cart-item">
                    <p><?= $item['produk'] ?> <br>
                        <small>Qty: <?= $item['qty'] ?></small>
                    </p>

                    <a href="keranjang.php?hapus=<?= $id ?>" class="hapus-item">Hapus</a>
                </div>
            <?php endforeach; ?>

            <a href="keranjang.php" class="goto-cart">Lihat Semua</a>

        <?php else: ?>
            <p>Keranjang masih kosong</p>
        <?php endif; ?>
    </div>

    <button id="closeCartBtn" class="close-cart">Tutup</button>
</div>

    <script>
        feather.replace();
    </script>
    <script src="script.js"></script>
</body>
</html>