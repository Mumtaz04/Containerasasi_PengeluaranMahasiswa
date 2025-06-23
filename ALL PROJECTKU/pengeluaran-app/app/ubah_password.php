<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}
include 'koneksi.php';
$pesan = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_SESSION['user_id'];
    $lama = $_POST['lama'];
    $baru = password_hash($_POST['baru'], PASSWORD_DEFAULT);

    $cek = $conn->prepare("SELECT password FROM users WHERE id = ?");
    $cek->bind_param("i", $id);
    $cek->execute();
    $cek->bind_result($pass);
    $cek->fetch();
    $cek->close();

if (password_verify($lama, $pass)) {
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
    $stmt->bind_param("si", $baru, $id);
    $stmt->execute();
    $pesan = "Password berhasil diubah.";
    } else {
        $pesan = "Password lama salah!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ubah Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-body">
        <h3 class="text-primary mb-4">Ubah Password</h3>
        <?php if ($pesan): ?>
            <div class="alert alert-info"><?= $pesan ?></div>
        <?php endif; ?>
        <form method="post">
        <div class="mb-3">
            <label>Password Lama:</label>
            <input type="password" name="lama" class="form-control" required>
        </div>
            <div class="mb-3">
                <label>Password Baru:</label>
                <input type="password" name="baru" class="form-control" required>
            </div>
                <button class="btn btn-primary">Ubah</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
