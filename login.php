<?php
session_start();

// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$database = "dbinput";

$conn = new mysqli($servername, $username, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data yang dikirimkan melalui form
    $inputUsername = $_POST["username"];
    $inputPassword = $_POST["password"];

    // Lakukan validasi atau sanitasi data jika diperlukan
    // ...

    // Query ke database untuk memeriksa keberadaan pengguna
    $sql = "SELECT * FROM users WHERE username = '$inputUsername' and password = '$inputPassword'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Memeriksa kecocokan kata sandi
        
            // Jika kata sandi cocok, set session dan arahkan ke halaman lain
            $_SESSION["username"] = $inputUsername;
            header("Location: index.php");
    } else {
        echo "Pengguna tidak ditemukan";
    }
}

// Tutup koneksi database
$conn->close();
?>
