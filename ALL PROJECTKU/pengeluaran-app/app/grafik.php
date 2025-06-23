<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}
include 'koneksi.php';
$user_id = $_SESSION['user_id'];

// Grafik bar mingguan
$bar = $conn->query("SELECT tanggal, SUM(jumlah) as total 
                        FROM pengeluaran 
                        WHERE user_id = $user_id 
                        GROUP BY tanggal ORDER BY tanggal DESC LIMIT 7");

$dataBar = $dataLabel = [];
while ($row = $bar->fetch_assoc()) {
    $dataLabel[] = $row['tanggal'];
    $dataBar[] = $row['total'];
}

// Grafik pie kategori
$pie = $conn->query("SELECT jenis, SUM(jumlah) as total 
                        FROM pengeluaran 
                        WHERE user_id = $user_id 
                        GROUP BY jenis");

$dataPie = $dataJenis = [];
while ($row = $pie->fetch_assoc()) {
    $dataJenis[] = $row['jenis'];
    $dataPie[] = $row['total'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Grafik Pengeluaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-light">
<div class="container mt-5">
    <h3 class="mb-4 text-primary">Grafik Pengeluaran</h3>
    <div class="row">
    <div class="col-md-6">
        <h5>Grafik Bar (Mingguan)</h5>
        <canvas id="barChart"></canvas>
    </div>
        <div class="col-md-6">
            <h5>Grafik Pie (Per Jenis)</h5>
            <canvas id="pieChart"></canvas>
        </div>
    </div>
</div>

<script>
new Chart(document.getElementById("barChart").getContext("2d"), {
    type: 'bar',
    data: {
        labels: <?= json_encode($dataLabel) ?>,
        datasets: [{
            label: 'Total Pengeluaran',
            data: <?= json_encode($dataBar) ?>,
            backgroundColor: 'rgba(54, 162, 235, 0.7)'
        }]
    }
});

new Chart(document.getElementById("pieChart").getContext("2d"), {
    type: 'pie',
    data: {
        labels: <?= json_encode($dataJenis) ?>,
        datasets: [{
            label: 'Per Jenis',
            data: <?= json_encode($dataPie) ?>,
            backgroundColor: [
                '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'
            ]
        }]
    }
});
</script>
</body>
</html>
