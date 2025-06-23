<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}

$pesan = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $jenis   = $_POST['jenis'];
    $jumlah  = $_POST['jumlah'];
    $tanggal = $_POST['tanggal'];

    $stmt = $conn->prepare("INSERT INTO pengeluaran (user_id, jenis, jumlah, tanggal) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isis", $user_id, $jenis, $jumlah, $tanggal);
    if ($stmt->execute()) {
        $pesan = "Data berhasil disimpan.";
    } else {
        $pesan = "Gagal menyimpan: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Input Pengeluaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow">
    <div class="card-body">
        <h3 class="text-primary mb-4">Form Pengeluaran</h3>
        <?php if ($pesan): ?>
        <div class="alert alert-info"><?= $pesan ?></div>
        <?php endif; ?>
        <form method="post">
        <div class="mb-3">
            <label>Jenis Pengeluaran:</label>
            <input type="text" name="jenis" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Jumlah (Rp):</label>
            <input type="number" name="jumlah" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Tanggal:</label>
            <input type="date" name="tanggal" class="form-control" value="<?= date('Y-m-d') ?>">
        </div>
            <button class="btn btn-primary">Simpan</button>
        </form>
        </div>
    </div>
</div>
</body>
</html>
