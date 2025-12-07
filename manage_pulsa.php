<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "adiva");

// CREATE
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    $isi = $_POST['isi'];
    $harga = $_POST['harga'];
    $conn->query("INSERT INTO pulsa (isi, harga) VALUES ('$isi', '$harga')");
}

// UPDATE
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $id = $_POST['id'];
    $isi = $_POST['isi'];
    $harga = $_POST['harga'];
    $conn->query("UPDATE pulsa SET isi='$isi', harga='$harga' WHERE id=$id");
    header("Location: manage_pulsa.php");
    exit();
}

// DELETE
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM pulsa WHERE id=$id");
}

$result = $conn->query("SELECT * FROM pulsa");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pulsa</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="admin.css">
</head>
<body>
<?php
include 'navbar_admin.php'
?>
    <div class="container">
        <h1>Kelola Pulsa</h1>
        <form method="POST">
            <input type="text" name="isi" placeholder="Isi Pulsa" required>
            <input type="number" name="harga" placeholder="Harga" required>
            <button type="submit" name="add">Tambah Pulsa</button>
        </form>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Isi</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td>Rp <?= number_format($row['isi'], 0, ',', '.'); ?></td>
                    <td>Rp <?= number_format($row['harga'], 0, ',', '.'); ?></td>
                    <td>
                        <button class="update-btn" onclick="openEwalletModal(<?= $row['id']; ?>, '<?= $row['isi']; ?>', <?= $row['harga']; ?>)">Update</button>
                        <a href="?delete=<?= $row['id']; ?>" class="delete-btn">Hapus</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <div id="updateModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal()">&times;</span>
            <h2>Update Pulsa</h2>
            <form id="updateForm" method="POST">
                <input type="hidden" name="id" id="updateId">
                <input type="text" name="isi" id="updatePulsa" required>
                <input type="number" name="harga" id="updateHarga" required>
                <button type="submit" name="update">Simpan Perubahan</button>
            </form>
        </div>  
    </div>
</body>
</html>
