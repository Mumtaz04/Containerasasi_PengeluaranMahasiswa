<?php
session_start();
require 'koneksi.php';

if (isset($_SESSION['login'])) {
    header("Location: index.php");
    exit();
}

$pesan = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($id, $hashed);
        $stmt->fetch();
        if (password_verify($pass, $hashed)) {
            $_SESSION['login'] = true;
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $user;
            header("Location: index.php");
            exit();
        } else {
            $pesan = "Password salah.";
        }
    } else {
        $pesan = "Username tidak ditemukan.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card w-50 mx-auto shadow">
        <div class="card-body">
            <h3 class="text-center mb-4 text-primary">Login</h3>
            <?php if ($pesan): ?>
                <div class="alert alert-danger"><?= $pesan ?></div>
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
                <button class="btn btn-primary w-100">Login</button>
                <a href="register.php" class="btn btn-link d-block mt-2 text-center">Belum punya akun?</a>
            </form>
        </div>
    </div>
</div>
</body>
</html>
