<?php
include "koneksi.php";

$tanggal_awal  = $_GET['tanggal_awal'] ?? "";
$tanggal_akhir = $_GET['tanggal_akhir'] ?? "";

$where = "";
if (!empty($tanggal_awal) && !empty($tanggal_akhir)) {
    $where = "WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'";
}

$q = $conn->query("SELECT * FROM pembelian $where ORDER BY tanggal DESC");

header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=history_pembelian.csv");

$output = fopen("php://output", "w");

fputcsv($output, ["ID", "Produk", "Jenis", "Harga", "Qty", "Total", "Tanggal"]);

while ($row = $q->fetch_assoc()) {
    fputcsv($output, $row);
}

fclose($output);
exit();
?>
