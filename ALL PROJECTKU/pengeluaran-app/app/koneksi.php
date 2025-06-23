<?php
$host = 'db'; // gunakan nama service di docker-compose
$user = 'root';
$pass = 'password';
$db   = 'pengeluaran';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
