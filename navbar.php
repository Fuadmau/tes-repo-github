<?php
session_start();
$jumlah_keranjang = isset($_SESSION['cart'])
    ? array_sum(array_column($_SESSION['cart'], 'qty'))
    : 0;
?>

<nav class="navbar">
    <a href="#" class="navbar-logo">Dina<span>Ponsel</span></a>

    <div class="navbar-nav">
        <a href="home.php">Home</a>
        <a href="index.php">Login</a>
        <a href="https://wa.me/6282181472950?text=Halo,%20saya%20tertarik%20dengan%20produk%20Anda" class="contact-link">Kontak</a>
        <a href="keranjang.php" class="cart-icon">
            <i data-feather="shopping-cart"></i>
            <?php if ($jumlah_keranjang > 0): ?>
                <span class="cart-count"><?= $jumlah_keranjang ?></span>
            <?php endif; ?>
        </a>
    </div>

    <div class="navbar-extra">
        <!-- Ikon menu -->
        <a href="#" id="menu">
            <i data-feather="menu"></i>
        </a>
    </div>
</nav>

