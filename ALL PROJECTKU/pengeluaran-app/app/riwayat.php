<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}
include 'koneksi.php';

$user_id = $_SESSION['user_id'];
$where = "WHERE user_id = $user_id";
if (!empty($_GET['dari']) && !empty($_GET['sampai'])) {
    $dari = $_GET['dari'];
    $sampai = $_GET['sampai'];
    $where .= " AND tanggal BETWEEN '$dari' AND '$sampai'";
}

$hasil = $conn->query("SELECT * FROM pengeluaran $where ORDER BY tanggal DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Riwayat Pengeluaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h3 class="mb-4 text-success">Riwayat Pengeluaran</h3>
    <form class="row g-3 mb-3">
        <div class="col-md-4">
            <input type="date" name="dari" value="<?= $_GET['dari'] ?? '' ?>" class="form-control" required>
        </div>
        <div class="col-md-4">
            <input type="date" name="sampai" value="<?= $_GET['sampai'] ?? '' ?>" class="form-control" required>
        </div>
            <div class="col-md-4">
                <button class="btn btn-outline-primary">Filter</button>
                <a href="riwayat.php" class="btn btn-outline-secondary">Reset</a>
            </div>
    </form>

    <table class="table table-bordered table-striped">
        <thead class="table-primary">
        <tr>
            <th>Tanggal</th>
            <th>Jenis</th>
            <th>Jumlah</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $hasil->fetch_assoc()): ?>
            <tr>
                <td><?= $row['tanggal'] ?></td>
                <td><?= $row['jenis'] ?></td>
                <td>Rp <?= number_format($row['jumlah']) ?></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
