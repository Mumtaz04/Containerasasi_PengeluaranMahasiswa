<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
    <div class="container">
    <span class="navbar-brand">PengeluaranApp</span>
    <div class="d-flex">
        <a href="logout.php" class="btn btn-outline-light btn-sm">Logout</a>
        </div>
    </div>
</nav>
<div class="container text-center">
    <h2 class="mb-4 text-success">Selamat datang, <?= $_SESSION['username'] ?>!</h2>
    <a class="btn btn-outline-primary m-2" href="form_input.php">+ Tambah Pengeluaran</a>
    <a class="btn btn-outline-success m-2" href="riwayat.php">📜 Riwayat</a>
    <a class="btn btn-outline-info m-2" href="grafik.php">📊 Grafik</a>
    <a class="btn btn-outline-dark m-2" href="ubah_password.php">🔒 Ubah Password</a>
</div>
</body>
</html>
