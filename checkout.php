<?php
session_start();
include 'koneksi.php';

$cart = $_SESSION['cart'] ?? [];

if (empty($cart)) {
    die("Keranjang kosong!");
}

foreach ($cart as $item) {
    $produk = $item['produk'];
    $jenis = $item['jenis'];
    $harga = $item['harga'];
    $qty = $item['qty'];
    $total = $qty * $harga;
    $tanggal = date("Y-m-d H:i:s");

    $conn->query("
        INSERT INTO pembelian (produk, jenis, harga, qty, total_harga, tanggal)
        VALUES ('$produk', '$jenis', '$harga', '$qty', '$total', '$tanggal')
    ");
}

unset($_SESSION['cart']);

echo "<script>alert('Checkout berhasil!'); window.location='paket.php';</script>";
?>
