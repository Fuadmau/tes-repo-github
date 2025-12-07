<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit();
}

include 'koneksi.php';

// Ambil input filter tanggal
$tanggal_awal  = $_GET['tanggal_awal']  ?? "";
$tanggal_akhir = $_GET['tanggal_akhir'] ?? "";

// Query filter rentang tanggal
$where = "";
if (!empty($tanggal_awal) && !empty($tanggal_akhir)) {
    $where = "WHERE tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir'";
}

// Total transaksi
$q_trans = $conn->query("SELECT COUNT(*) AS total FROM pembelian $where");
$total_trans = $q_trans->fetch_assoc()['total'] ?? 0;

// Total pemasukan
$q_income = $conn->query("SELECT SUM(total_harga) AS pemasukan FROM pembelian $where");
$pemasukan = $q_income->fetch_assoc()['pemasukan'] ?? 0;

// Total item terjual
$q_qty = $conn->query("SELECT SUM(qty) AS total_qty FROM pembelian $where");
$total_qty = $q_qty->fetch_assoc()['total_qty'] ?? 0;

// Chart bulanan
$q_chart = $conn->query("
    SELECT DATE_FORMAT(tanggal, '%M') AS bulan,
           SUM(total_harga) AS total
    FROM pembelian
    $where
    GROUP BY MONTH(tanggal)
");

$chart_data = [];
while ($row = $q_chart->fetch_assoc()) {
    $chart_data[] = $row;
}

// History Pembelian
$q_history = $conn->query("
    SELECT id, produk, jenis, harga, qty, total_harga, tanggal
    FROM pembelian
    $where
    ORDER BY tanggal DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>

<div class="dashboard-container">

    <header class="dashboard-header">
        <h1>Admin Dashboard</h1>
        <nav class="dashboard-nav">
            <a href="manage_paket.php" class="nav-link">Kelola Paket</a>
            <a href="manage_pulsa.php" class="nav-link">Pulsa</a>
            <a href="manage_token.php" class="nav-link">Token Listrik</a>
            <a href="manage_ewallet.php" class="nav-link">E-Wallet</a>
            <a href="logout.php" class="nav-link logout">Logout</a>
        </nav>
    </header>



    <!-- SELAMAT DATANG -->
    <main class="dashboard-content">
        <p>Selamat datang, <?= $_SESSION['admin']; ?>!</p>
    </main>

    <!-- FILTER TANGGAL -->
    <form method="GET" class="filter-box">
        <div>
            <label>Dari Tanggal:</label><br>
            <input type="date" name="tanggal_awal" value="<?= $tanggal_awal ?>" required>
        </div>

        <div>
            <label>Sampai Tanggal:</label><br>
            <input type="date" name="tanggal_akhir" value="<?= $tanggal_akhir ?>" required>
        </div>

        <div>
            <button type="submit">Filter</button>
        </div>

        <a href="admin_dashboard.php" class="reset-btn">Reset</a>
    </form>


    <!-- STATISTICS CARDS -->
    <div class="dashboard-grid">

        <div class="dashboard-card" style="background:#4C8BF5;">
            <div class="icon-box"><i class="fas fa-shopping-cart"></i></div>
            <div class="card-title">Total Transaksi</div>
            <div class="card-value"><?= $total_trans ?></div>
        </div>

        <div class="dashboard-card" style="background:#28A745;">
            <div class="icon-box"><i class="fas fa-money-bill-wave"></i></div>
            <div class="card-title">Total Pemasukan</div>
            <div class="card-value">Rp <?= number_format($pemasukan,0,',','.') ?></div>
        </div>

        <div class="dashboard-card" style="background:#FFC107; color:#333;">
            <div class="icon-box"><i class="fas fa-box-open"></i></div>
            <div class="card-title">Total Item Terjual</div>
            <div class="card-value"><?= $total_qty ?></div>
        </div>

    </div>

    <!-- CHART -->
    <div class="card mt-4" style="border-radius:15px; padding:20px; max-width:1200px; margin:auto;">
        <h4 class="mb-3"><i class="fas fa-chart-line"></i> Grafik Penjualan Bulanan</h4>
        <canvas id="chartPembelian" height="120"></canvas>
    </div>

    <!-- HISTORY PEMBELIAN -->
    <div class="history-card">
        <h3><i class="fas fa-clock-rotate-left"></i> Riwayat Pembelian</h3>

        <a href="download_history.php?tanggal_awal=<?= $tanggal_awal ?>&tanggal_akhir=<?= $tanggal_akhir ?>" 
        class="csv-btn">
        Download CSV
        </a>

        <table class="history-table">
            <tr>
                <th>ID</th>
                <th>Produk</th>
                <th>Jenis</th>
                <th>Harga Satuan</th>
                <th>Qty</th>
                <th>Total</th>
                <th>Tanggal</th>
            </tr>
            <?php $no = 1; ?>
            <?php while($row = $q_history->fetch_assoc()): ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $row['produk'] ?></td>
                    <td><?= $row['jenis'] ?></td>
                    <td>Rp <?= number_format($row['harga']) ?></td>
                    <td><?= $row['qty'] ?></td>
                    <td>Rp <?= number_format($row['total_harga']) ?></td>
                    <td><?= date("d-m-Y H:i:s", strtotime($row['tanggal'])) ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
new Chart(document.getElementById('chartPembelian'), {
    type: 'line',
    data: {
        labels: <?= json_encode(array_column($chart_data, 'bulan')); ?>,
        datasets: [{
            label: 'Total Penjualan',
            data: <?= json_encode(array_column($chart_data, 'total')); ?>,
            borderWidth: 3,
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false }
        },
        scales: { y: { beginAtZero: true } }
    }
});
</script>

</body>
</html>
