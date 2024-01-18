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

// Fungsi untuk menyimpan data ke database
function saveDataToDatabase($vin, $areaPart, $defect, $ctg, $pic, $model, $suffix, $analisis) {
    global $conn;

    // Periksa apakah VIN sudah ada di histori
    $sqlCheckVin = "SELECT * FROM input_2 WHERE `vin` = '$vin' AND `area/part` = '$areaPart' AND `defect` = '$defect' AND `ctg` = '$ctg' AND `pic` = '$pic' AND `model` = '$model' AND `suffix` = '$suffix'";
    $resultCheckVin = $conn->query($sqlCheckVin);

    if ($resultCheckVin && $resultCheckVin->num_rows > 0) {
        // VIN ditemukan di histori, simpan informasi file
        $sqlUpdateHistory = "UPDATE input_2 SET analisis = '$analisis' WHERE vin = '$vin'";

        if ($conn->query($sqlUpdateHistory) === TRUE) {
            echo "";
        } else {
            echo "Error: " . $sqlUpdateHistory . "<br>" . $conn->error;
        }
    } else {
        // VIN tidak ditemukan di histori
        echo "VIN tidak ditemukan di histori.";
    }
}

// Proses upload file
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $targetDir = "upload/"; // Direktori tempat file akan disimpan
    $targetFile = $targetDir . basename($_FILES["file"]["name"]);


    $uploadOk = 1;
    $allowedFileTypes = array('jpg', 'jpeg', 'png', 'gif', 'pdf', 'xls', 'xlsx'); // Jenis file yang diizinkan

    // Cek jenis file yang diizinkan
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    if (!in_array($imageFileType, $allowedFileTypes)) {
        echo "Maaf, hanya file JPG, JPEG, PNG, GIF, PDF, XLS, dan XLSX yang diizinkan.";
        $uploadOk = 0;
    }

    // Cek jika $uploadOk = 0
    if ($uploadOk == 0) {
        echo "Maaf, file tidak diunggah.";
    } else {
        // Coba unggah file
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
            

            // Dapatkan data dari sesi (pastikan data sudah ada di sesi sebelumnya)
            $vin = isset($_SESSION['selected_data']['vin']) ? $_SESSION['selected_data']['vin'] : '';
            $areaPart = isset($_SESSION['selected_data']['areaPart']) ? $_SESSION['selected_data']['areaPart'] : '';
            $defect = isset($_SESSION['selected_data']['defect']) ? $_SESSION['selected_data']['defect'] : '';
            $ctg = isset($_SESSION['selected_data']['ctg']) ? $_SESSION['selected_data']['ctg'] : '';
            $pic = isset($_SESSION['selected_data']['pic']) ? $_SESSION['selected_data']['pic'] : '';
            $model = isset($_SESSION['selected_data']['model']) ? $_SESSION['selected_data']['model'] : '';
            $suffix = isset($_SESSION['selected_data']['suffix']) ? $_SESSION['selected_data']['suffix'] : '';
            $analisis = isset($_SESSION['selected_data']['analisis']) ? $_SESSION['selected_data']['analisis'] : '';
            

            $sqlInsertData = "INSERT INTO input_2 (`vin`, `area/part`, `defect`, `ctg`, `pic`, `model`, `suffix`, `analisis`) VALUES ('$vin', '$areaPart', '$defect', '$ctg', '$pic', '$model', '$suffix', '$analisis')";
            if ($conn->query($sqlInsertData) === TRUE) {
                echo "";
            } else {
                echo "Error: " . $sqlInsertData . "<br>" . $conn->error;
            }
            
            // Simpan informasi file dan data lainnya di histori
            if ($vin && $areaPart && $defect && $ctg && $pic && $model && $suffix) {
                saveDataToDatabase($vin, $areaPart, $defect, $ctg, $pic, $model, $suffix, basename($_FILES["file"]["name"]));
                
            } else {
                echo "";
            }
        } else {
            echo "Maaf, terjadi kesalahan saat mengunggah file.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>COUNTERMEAURE</title>

    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .form-container {
            text-align: center;
            border: 2px solid #ccc;
            padding: 20px;
            border-radius: 8px;
            width: 300px; /* Optional: Set a fixed width for the form container */
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input[type="file"] {
            padding: 8px;
        }

        input[type="submit"] {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: black;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        #success-message {
            color: green;
            margin-top: 10px;
        }

        #view-link {
            margin-top: 10px;
            display: block;
            color: #82cfeb;
        }
    </style>
</head>

<body style="background-color: #0E1D35;">

    <div class="form-container">
        <h2 style="color:white;" >Upload Data</h2>

        <form action="ctm.php" method="post" enctype="multipart/form-data">
            <label style="color:white;" for="file">Pilih File:</label>
            <input style="color:white;" type="file" name="file" id="file" required>
            <br>
            <input type="submit" value="Unggah" name="submit">
        </form>

        <?php
        // Cek apakah file berhasil diunggah
        if (isset($_FILES["file"]["name"])) {
            echo '<div id="success-message">File ' . htmlspecialchars(basename($_FILES["file"]["name"])) . ' berhasil diunggah.</div>';

            echo "<a style=color: #82cfeb ; href='halaman_baru.php?vin=$vin&areaPart=$areaPart&defect=$defect&ctg=$ctg&pic=$pic&model=$model&suffix=$suffix'>Lihat</a>";
        }
        ?>
    </div>

</body>
</html>





