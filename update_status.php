<?php
session_start();

session_start();
$servername = "localhost";
$username = "root";
$password = "";
$database = "dbinput";
$conn = new mysqli($servername, $username, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari permintaan POST
    $vin = $_POST['vin'];
    $areaPart = $_POST['areaPart'];
    $defect = $_POST['defect'];
    $pic = $_POST['pic'];
    $model = $_POST['model'];
    $isClicked = $_POST['isClicked'];

    // Simpan status tombol ke dalam sesi PHP
    $_SESSION['status'][$vin][$areaPart][$defect][$pic][$model] = ($isClicked == 'true');
    
    echo "Status tombol berhasil diperbarui";
} else {
    echo "Permintaan tidak valid";
}
?>
