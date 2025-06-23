<?php
require 'koneksi.php';
$pesan = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['username'];
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Cek apakah username sudah ada
    $cek = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $cek->bind_param("s", $user);
    $cek->execute();
    $cek->store_result();

    if ($cek->num_rows > 0) {
        $pesan = "Username sudah digunakan.";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $user, $pass);
        if ($stmt->execute()) {
            $pesan = "Registrasi berhasil. Silakan login.";
        } else {
            $pesan = "Gagal mendaftar.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card w-50 mx-auto shadow">
        <div class="card-body">
            <h3 class="text-center mb-4 text-success">Register</h3>
            <?php if ($pesan): ?>
                <div class="alert alert-info"><?= $pesan ?></div>
            <?php endif; ?>
            <form method="post">
                <div class="mb-3">
                    <label>Username:</label>
                    <input type="text" name="username" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Password:</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button class="btn btn-success w-100">Register</button>
                <a href="login.php" class="btn btn-link d-block mt-2 text-center">Sudah punya akun?</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>
