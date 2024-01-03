<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Analisis</title>
    <style>
        body {
            background-color: #0E1D35;
            color: white; /* Set text color to white */
            padding: 20px; /* Add padding for better spacing */
            border: 2px solid #ccc; /* Add border to the body */
            border-radius: 8px; /* Optional: Add border-radius for rounded corners */
            max-width: 400px; /* Optional: Set a maximum width for the content */
            margin: auto; /* Center the content horizontally */
        }

        h2 {
            text-align: center; /* Center the heading */
        }

        p {
            margin-bottom: 10px; /* Add margin between paragraphs */
        }

        a {
            color: #4CAF50; /* Set link color to green */
        }
    </style>
</head>
<body>

    <h2>Hasil Analisis</h2>

    <?php
    // Menerima parameter dari URL
    $vin = isset($_GET['vin']) ? $_GET['vin'] : '';
    $areaPart = isset($_GET['areaPart']) ? $_GET['areaPart'] : '';
    $defect = isset($_GET['defect']) ? $_GET['defect'] : '';
    $pic = isset($_GET['pic']) ? $_GET['pic'] : '';
    $model = isset($_GET['model']) ? $_GET['model'] : '';
    $analisis = isset($_GET['analisis']) ? $_GET['analisis'] : '';

    // Menampilkan informasi hasil analisis
    echo "<p>VIN: $vin</p>";
    echo "<p>Area/Part: $areaPart</p>";
    echo "<p>Defect: $defect</p>";
    echo "<p>PIC: $pic</p>";
    echo "<p>Model: $model</p>";

    // Memeriksa apakah $analisis tidak kosong dan menampilkan tautan jika iya
    echo "<p>Hasil Analisis: <a href='upload/$analisis' target='_blank'>Lihat Hasil Analisis</a></p>";
    ?>

    <!-- Tambahkan konten hasil analisis di sini -->

</body>
</html>
