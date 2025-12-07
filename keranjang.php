<?php
session_start();
$cart = $_SESSION['cart'] ?? [];
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Keranjang Saya</title>
    <link rel="stylesheet" href="keranjang.css">

    <script src="https://unpkg.com/feather-icons"></script>
</head>

<body>

<!-- ================= NAVBAR ================= -->
<nav class="navbar">
    <a href="#" class="navbar-logo">Dina<span>Ponsel</span></a>

    <div class="navbar-nav">
        <a href="home.php">Home</a>
        <a href="paket.php">Paket Data</a>
        <a href="pulsa.php">Pulsa</a>
        <a href="token.php">Token Listrik</a>
        <a href="e_wallet.php">E-Wallet</a>
    </div>

    <div class="navbar-extra">
        <a href="#" id="menu"><i data-feather="menu"></i></a>
    </div>
</nav>
<!-- ================= END NAVBAR ================= -->

<h2 class="title">🛒 Keranjang Belanja</h2>

<?php if (empty($cart)): ?>
    <p class="empty-cart">Keranjang masih kosong.</p>
<?php else: ?>

<div class="table-container">
    <table class="cart-table">
        <tr>
            <th>Produk</th>
            <th>Jenis</th>
            <th>Harga</th>
            <th>Qty</th>
            <th>Total</th>
            <th>Aksi</th>
        </tr>

        <?php
        $grand_total = 0;
        foreach ($cart as $key => $item):
            $sub_total = $item['qty'] * $item['harga'];
            $grand_total += $sub_total;
        ?>
        <tr>
            <td><?= $item['produk']; ?></td>
            <td><?= ucfirst($item['jenis']); ?></td>
            <td>Rp <?= number_format($item['harga']); ?></td>
            <td><?= $item['qty']; ?></td>
            <td>Rp <?= number_format($sub_total); ?></td>
            <td><a href="hapus_keranjang.php?id=<?= $key; ?>" class="btn-delete">Hapus</a></td>
        </tr>
        <?php endforeach; ?>

        <tr class="total-row">
            <td colspan="4" class="right"><b>Total Semua:</b></td>
            <td colspan="2"><b>Rp <?= number_format($grand_total); ?></b></td>
        </tr>
    </table>
</div>

<div class="center">
    <a href="checkout.php" class="btn-checkout">Checkout</a>
    <a href="checkout.php" class="btn-lanjut">Lanjutkan Belanja</a>
</div>

<?php endif; ?>

<script src="script.js"></script>
<script>feather.replace();</script>

</body>
</html>
