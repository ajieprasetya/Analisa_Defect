<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pencarian Data yang Sudah di Analisis</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">

    <!-- Tambahkan kode JavaScript di sini -->
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <style>
        .clicked {
        background-color: green !important;
        }
        .not-clicked {
            background-color: red !important;
        }

        /* Gaya header */
    #header {
        display: flex;
        justify-content: flex-end; /* Menempatkan logo di sebelah kanan */
        padding: 10px;
        background-color: #0E1D35; /* Warna latar belakang header */
        color: white;
    }

    /* Gaya logo */
    #logo {
        cursor: pointer;
        color: white;
        background-color: #d4d4d4;
    }

    /* Gaya modal */
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.7);
    }
    
        .modal-content {
        background-color: #0E1D35; /* Warna latar belakang modal */
        margin: 5% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 50%;
        color: white;
        }

        #loginModal {
        display: none; /* Modal diatur menjadi tidak terlihat secara default */
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.7); /* Memberikan efek transparansi */
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: white;
        text-decoration: none;
        cursor: pointer;
    }

    </style>

    <?php
    session_start();
    // Pengecekan login
    $isUserLoggedIn = isset($_SESSION['username']);
    ?>

<script>
        function showPopup() {
            var popup = document.getElementById('loginPopup');
            popup.style.display = 'block';
        }

        document.addEventListener('DOMContentLoaded', function () {
        var logo = document.getElementById('logo');
        var loginModal = document.getElementById('loginModal');

        logo.addEventListener('click', function () {
            // Tampilkan modal
            loginModal.style.display = 'block';
        });
    });

    function showLoginModal() {
        var loginModal = document.getElementById('loginModal');
        loginModal.style.display = 'block';
    }

    function closeModal() {
        // Tutup modal
        document.getElementById('loginModal').style.display = 'none';
    }
</script>
    
<script>
    $(document).ready(function() {
        $('#myTable').DataTable();

        // Menangani peristiwa klik pada tombol Status
        $('tbody').on('click', '.status-button', function() {
            // Toggle class 'clicked' untuk mengubah warna
            var isClicked = $(this).hasClass('clicked');

            if (!isClicked) {
            $(this).toggleClass('clicked');
            saveButtonStatus($(this));

            // Ganti kelas status sesuai dengan status
            if ($(this).hasClass('clicked')) {
                $(this).removeClass('not-clicked').addClass('clicked');
            } else {
                $(this).removeClass('clicked').addClass('not-clicked');
            }

            // Ambil data yang sesuai dari baris tabel
            var vin = $(this).closest('tr').find('td:eq(1)').text();
            var areaPart = $(this).closest('tr').find('td:eq(2)').text();
            var defect = $(this).closest('tr').find('td:eq(3)').text();
            var pic = $(this).closest('tr').find('td:eq(4)').text();
            var model = $(this).closest('tr').find('td:eq(5)').data('model');

            // Redirect ke halaman lain dengan parameter data
            window.location.href = 'halaman_baru.php?vin=' + vin + '&areaPart=' + areaPart + '&defect=' + defect + '&pic=' + pic + '&model=' + model + '&analisis=true';
            }
        });

        function checkButtonStatus() {
            var statusArray = JSON.parse(localStorage.getItem('buttonStatus')) || {};

            $('.status-button').each(function(index) {
                var buttonId = $(this).closest('tr').find('td:eq(1)').text(); // Ganti dengan cara yang sesuai untuk menghasilkan ID unik
                if (statusArray[buttonId]) {
                    $(this).addClass('clicked');
                }
            });
        }

        // Fungsi untuk menyimpan status tombol ke dalam penyimpanan lokal
        function saveButtonStatus(button) {
            var statusArray = JSON.parse(localStorage.getItem('buttonStatus')) || {};
            var buttonId = button.closest('tr').find('td:eq(1)').text(); // Ganti dengan cara yang sesuai untuk menghasilkan ID unik
            statusArray[buttonId] = true;
            localStorage.setItem('buttonStatus', JSON.stringify(statusArray));
        }

    });
</script>
</head>



<body style="background-color: #0E1D35;">

<div id="header" style="background-color: #0E1D35; padding: 10px;">
    <?php if ($isUserLoggedIn) : ?>
        <form method="post" action="logout.php" style="float: right;">
            <button type="submit">Logout</button>
        </form>
    <?php else : ?>
        <!-- Tombol login atau tampilkan modal login di sini -->
        <button style="color: black; float: right;" onclick="showLoginModal()">Login</button>
    <?php endif; ?>
</div>


    <h2 style="text-align: center; margin-top: 1em; color:white;">Analisis Defect</h2><br>


    <div id="loginModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Login</h2>
        <!-- Formulir login di sini -->
        <form method="post" action="login.php">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>
            
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>

            <button type="submit">Login</button>
        </form>
    </div>
</div>



    
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-9">
                    <div class="col-md-11">
                        <div class="card" style="color:white;">
                            <div class="card-header" style= "background-color: #0E1D35; text-align: center;">
                                <h5 style="color:white;">Tampilan Data</h5>
                            </div>
                            
                            <div class="card-body" style= "background-color: #15253F">
                                <div>
                                </div> 
                                <table class="table table-bordered" id="myTable" style="color:white; text-align: center;">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;">No</th>
                                        <th style="text-align: center;">VIN</th>
                                        <th style="text-align: center;">AREA/PART</th>
                                        <th style="text-align: center;">DEFECT</th>
                                        <th style="text-align: center;">PIC</th>
                                        <th style="text-align: center;">MODEL</th>
                                        <?php if ($isUserLoggedIn) : ?>
                                            <th>Status</th>
                                        <?php endif; ?> 
                                    </tr>
                                </thead>
                                    <tbody>


                                        <?php
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


                                        // Fungsi untuk mendapatkan semua data
                                        function getAllData() {
                                            global $conn;
                                            $sql = "SELECT * FROM input_data";
                                            $result = $conn->query($sql);
                                            return $result->fetch_all(MYSQLI_ASSOC);
                                        }

                                        // Tampilkan semua data
                                        $allData = getAllData();
                                        $no = 1;
                                        foreach ($allData as $row) {
                                            ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= $row['vin']; ?></td>
                                                <td><?= $row['area/part']; ?></td>
                                                <td><?= $row['defect']; ?></td>
                                                <td><?= $row['pic']; ?>
                                                    <div style="display: flex; flex-direction: column; align-items: left;">
                                                        <a href="history.php?areaPart=<?= $row['area/part']; ?>&defect=<?= $row['defect']; ?>">
                                                            <img src="car-check.png" alt="Logo" style="width: 33px; height: 33px;">
                                                        </a>
                                                    
                                                    </div>
                                                </td>
                                                <td class="model-cell" data-model="<?= $row['model']; ?>">
                                                    <?= $row['model']; ?>
                                                    <span class="status-marker not-clicked"></span>
                                                </td>
                                                <?php if ($isUserLoggedIn) : ?>
                                                <td>
                                                    <!-- Tombol Status -->
                                                    <button class="status-button btn btn-danger">Status</button>
                                                </td>
                                                <?php endif; ?>
                                            </tr>

                                            <?php
                                        }

                                        // Proses penambahan data baru
                                        if (isset($_POST['addData'])) {
                                            $vin = $_POST['vin'];
                                            $areaPart = $_POST['areaPart'];
                                            $defect = $_POST['defect'];
                                            $pic = $_POST['pic'];
                                            $model = $_POST['model'];

                                            // Lakukan validasi atau sanitasi data jika diperlukan
                                            // ...

                                            // Tambahkan data baru ke database
                                            $sqlInsert = "INSERT INTO input_data (`vin`, `area/part`, `defect`, `pic`, `model`) VALUES ('$vin', '$areaPart', '$defect', '$pic', '$model')";
                                            
                                            if ($conn->query($sqlInsert) === TRUE) {
                                                echo "Data berhasil ditambahkan!";
                                            } else {
                                                echo "Error: " . $sqlInsert . "<br>" . $conn->error;
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
