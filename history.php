        
<?php
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

// Fungsi untuk menyimpan data ke session
function saveDataToSession($data) {
    $_SESSION['selected_data'] = $data;
}

// Fungsi untuk mendapatkan data yang disimpan di session
function getSavedDataFromSession() {
    return isset($_SESSION['selected_data']) ? $_SESSION['selected_data'] : null;
}

// Fungsi untuk menyimpan data ke database
function saveDataToDatabase($data) {
    global $conn;

    // Lakukan validasi atau sanitasi data jika diperlukan
    // ...

    // Ekstrak data
    $vin = $data['vin'];
    $areaPart = $data['areaPart'];
    $defect = $data['defect'];
    $pic = $data['pic'];
    $model = $data['model'];


    // Periksa apakah VIN sudah ada di histori
    
    $sqlCheckVin = "SELECT * FROM input_2 WHERE `vin` = '$vin'";
    $resultCheckVin = $conn->query($sqlCheckVin);

    if ($resultCheckVin && $resultCheckVin->num_rows === 0) {
        // VIN belum ada di histori, simpan ke histori hanya jika tidak ada parameter status di URL
        if (!isset($_GET['analisis'])) {

            $sqlInsertHistory = "INSERT INTO input_2 (`vin`, `area/part`, `defect`, `pic`, `model`) VALUES ('$vin', '$areaPart', '$defect', '$pic', '$model')";
        }
    } else {
        // VIN sudah ada di histori, mungkin beri pesan atau lakukan sesuatu yang sesuai
        echo "";
    }
}

// Menerima parameter dari URL
$vin = isset($_GET['vin']) ? $_GET['vin'] : '';
$areaPart = isset($_GET['areaPart']) ? $_GET['areaPart'] : '';
$defect = isset($_GET['defect']) ? $_GET['defect'] : '';
$pic = isset($_GET['pic']) ? $_GET['pic'] : '';
$model = isset($_GET['model']) ? $_GET['model'] : '';

// Menyimpan data ke session
$data = array(
    'vin' => $vin,
    'areaPart' => $areaPart,
    'defect' => $defect,
    'pic' => $pic,
    'model' => $model
);

    saveDataToSession($data);

    saveDataToDatabase($data);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Lain</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Tambahkan pengaturan gaya atau skrip lainnya jika diperlukan -->
    <style>
        body {
            background-color: #0E1D35;
            color: white;
            margin: 0; /* Hapus margin default untuk menggunakan seluruh lebar viewport */
            padding: 0; /* Hapus padding default */
        }

        header {
            margin-bottom: 30px; /* Berikan ruang di bawah header */
            width: 80%;
            margin-right : 200px;
            margin-left : 500px;
            margin-top : 30px;
            
        }

        .navbar {
            width: 100%; /* Lebar penuh */
            text-align: center;
        }

        .container {
            width: 80%;
            margin: auto;
        }

        h2 {
            margin: 0; /* Hapus margin untuk mencegah spasi di sekitar judul */
        }

        table {
            border-collapse: collapse;
            width: 100%;
            border: 2px solid #ccc;
            border-radius: 8px;
            margin-top: 20px; /* Tambahkan margin di atas tabel */
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
            /* Center text horizontally */
            vertical-align: middle;
            /* Center text vertically */
        }

        th {
            background-color: #f2f2f2;
            color: #0E1D35;
        }

        .navbar-brand {
            text-align: center !important;
        }
    </style>
</head>

<body>

    <header>
            <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #0E1D35;">
                <h3 style="text-align: center;" class="navbar-brand" href="#">Analisis Defect</h3>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item active">
                            <h5><a class="nav-link" href="index.php">Beranda</a></h5>
                        </li>
                    </ul>
                </div>
            </nav>
    </header>

    <div class="container">
        <h3>Histori</h3>

        <table>
            <tr>
                <th>VIN</th>
                <th>AREA/PART</th>
                <th>DEFECT</th>
                <th>PIC</th>
                <th>MODEL</th>
                <th>HASIL ANALISIS</th>
            </tr>

            <?php
            // Ambil data histori dengan Area/Part dan Defect yang sama dari database
            $sqlSelectHistory = "SELECT * FROM input_2 WHERE `area/part` = '$areaPart' AND `defect` = '$defect'";
            $resultHistory = $conn->query($sqlSelectHistory);

            // Cek apakah query berhasil dijalankan
            if ($resultHistory) {
                if ($resultHistory->num_rows > 0) {
                    // Output data dari setiap baris histori
                    while ($rowHistory = $resultHistory->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $rowHistory['vin'] . "</td>";
                        echo "<td>" . $rowHistory['area/part'] . "</td>";
                        echo "<td>" . $rowHistory['defect'] . "</td>";
                        echo "<td>" . $rowHistory['pic'] . "</td>";
                        echo "<td>" . $rowHistory['model'] . "</td>";
                        echo "<td><a href='hasil.php?vin=" . $rowHistory['vin'] . "&areaPart=" . $rowHistory['area/part'] . "&defect=" . $rowHistory['defect'] . "&pic=" . $rowHistory['pic'] . "&model=" . $rowHistory['model'] . "&analisis=" . urlencode($rowHistory['analisis']) . "'>Hasil Analisis</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Tidak ada histori dengan Area/Part '$areaPart' dan Defect '$defect'.</td></tr>";
                }
            } else {
                echo "Error: " . $sqlSelectHistory . "<br>" . $conn->error;
            }
            ?>
        </table>
    </div>

    <!-- Tambahkan konten halaman lainnya di sini -->

</body>

</html>

