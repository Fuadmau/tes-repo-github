<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paket Data</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/feather-icons"></script>
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<?php
    include 'navbar.php';
    ?>
    <section class="hero">
        <main class="content">
            <h1>Pulsa</h1>
            <p>Beli pulsa dengan mudah dan cepat.</p>
            <button class="cta" id="openModal">Lihat Daftar Isi</button>
        </main>
    </section>

    <!-- Modal -->
    <div id="pulsaModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Daftar Isi Pulsa</h2>
            <div id="paketList">
                <?php
                // Koneksi ke database
                $conn = new mysqli("localhost", "root", "", "adiva");

                if ($conn->connect_error) {
                    die("Koneksi gagal: " . $conn->connect_error);
                }

                $sql = "SELECT id, isi, harga FROM pulsa";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    echo "<table>
                            <tr>
                                <th>ID</th>
                                <th>Isi</th>
                                <th>Harga</th>
                                <th>Aksi</th>
                            </tr>";
                            $no = 1;
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                        <td>" . $no++ . "</td>
                                        <td>Rp " . number_format($row['isi'], 0, ',', '.') . "</td>
                                        <td>Rp " . number_format($row['harga'], 0, ',', '.') . "</td>
                                        <td>
                                            <form method='POST' action='tambah_keranjang.php'>
                                                <input type='hidden' name='id_produk' value='" . $row['id'] . "'>
                                                <input type='hidden' name='jenis' value='pulsa'>
                                                <button type='submit' class='btn'>Tambah ke Keranjang</button>
                                            </form>
                                        </td>
                                    </tr>";
                            }
                    echo "</table>";
                } else {
                    echo "<p>Saldo lagi kosong</p>";
                }
                $conn->close();
                ?>
            </div>
        </div>
    </div>

    <script>
        // Modal functionality
        const modal = document.getElementById("pulsaModal");
        const btn = document.getElementById("openModal");
        const span = document.getElementsByClassName("close")[0];

        btn.onclick = function() {
            modal.style.display = "block";
        }
        span.onclick = function() {
            modal.style.display = "none";
        }
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html>
