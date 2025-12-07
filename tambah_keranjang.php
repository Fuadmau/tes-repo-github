<?php
session_start();
include 'koneksi.php';

$id_produk = $_POST['id_produk'];
$jenis = $_POST['jenis']; // paket / token / ewallet

// Ambil data sesuai jenis produk
if ($jenis == "paket") {
    $q = $conn->query("SELECT id, paket AS nama, harga FROM paket WHERE id='$id_produk'");
} else if ($jenis == "token") {
    $q = $conn->query("SELECT id, isi AS nama, harga FROM token WHERE id='$id_produk'");
} else if ($jenis == "ewallet") {
    $q = $conn->query("SELECT id, isi AS nama, harga FROM e_wallet WHERE id='$id_produk'");
} else if ($jenis == "pulsa") {
    $q = $conn->query("SELECT id, isi AS nama, harga FROM pulsa WHERE id='$id_produk'");
} else {
    die("Jenis tidak valid");
}

$data = $q->fetch_assoc();
if (!$data) {
    die("Produk tidak ditemukan");
}

$keranjang = $_SESSION['cart'] ?? [];

// Buat key unik berdasarkan jenis + id
$key = $jenis . "_" . $id_produk;

if (isset($keranjang[$key])) {
    $keranjang[$key]['qty'] += 1;
} else {
    $keranjang[$key] = [
        "id" => $id_produk,
        "jenis" => $jenis,
        "produk" => $data['nama'],
        "harga" => $data['harga'],
        "qty" => 1
    ];
}

$_SESSION['cart'] = $keranjang;

header("Location: keranjang.php");
exit;
?>
