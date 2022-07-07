<?php
require_once('../db/db_config.php');

session_start();
$nama_asli = $_SESSION['nama_asli'];

if(isset($_POST['submit'])) {
    $tanggal = date('Y-m-d');
    $nama = $nama_asli;
    $nominal = $_POST['nominal'];
    $status = "Diajukan";
    $keterangan = $_POST['keterangan'];
            
    $result = mysqli_query($conn, "INSERT INTO pengajuan(tanggal,nama,nominal,status,keterangan) VALUES('$tanggal','$nama',$nominal,'$status','$keterangan')");
    echo "
    <script>
        alert('Peminjaman berhasil diajukan, silahkan tunggu konfirmasi dari bendahara utama.');
        document.location.href = 'dash_waka.php';
    </script>";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
    <title>Pengajuan Peminjaman</title>
    <style>
        body{
            background-color: #F4F4FF;
            background-repeat: no-repeat;
            background-size: 100% 170%;
            font-family: "Arial", Times, sans-serif;
        }
        .icon {
            font-size: 100px;
        }
        .icon i {
            color: black;
        }
        .icon i:hover {
            color: #5271FF;
        }
    </style>
</head>
<body>
    <div class="container my-4 py-2">
        <div class="header">
            <h3 class="h2 mb-3" id="sub_title_page">
                <i class="bi bi-plus-circle-fill me-2"></i><strong>Pengajuan Peminjaman Dana</strong>
            </h3>
        </div>
        <form method="post" action="pengajuan.php">
            <!-- Oleh -->
            <div class="row mb-3">
                <label for="oleh" class="col-form-label col-sm-4 col-md-3 col-xl-2"><strong>Oleh</strong></i></label>
                <div class="col-sm-8 col-md-9 col-xl-10">
                    <input type="text" id="oleh" name="oleh" class="form-control" readonly required value="<?= $nama_asli?>">
                </div>
            </div>
            <!-- Nominal -->
            <div class="row mb-3">
                <label for="nominal" class="col-form-label col-sm-4 col-md-3 col-xl-2"><strong>Nominal</strong></label>
                <div class="col-sm-8 col-md-9 col-xl-10">
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">Rp. </span>
                        <input type="number" min=0 id="nominal" name="nominal" class="form-control" placeholder="Nominal peminjaman" required>
                    </div>
                </div> 
            </div>
            <!-- Description -->
            <div class="row mb-3">
                <label for="keterangan" class="col-form-label col-sm-4 col-md-3 col-xl-2"><strong>Keterangan</strong></label>
                <div class="col-sm-8 col-md-9 col-xl-10">
                    <textarea type="textarea" class="form-control" name="keterangan" id="keterangan" rows="4" placeholder="Keterangan peminjaman"></textarea>
                </div>
            </div>
            <!-- Button -->
            <div class="row mb-3 justify-content-end">
                <div class="col-sm-8 col-md-9 col-xl-10">
                    <button type="submit" class="btn btn-primary" name="submit" id="submit">
                        <span class="bi bi-send-fill me-2"></span>
                        Ajukan
                    </button>
                    <a href="dash_waka.php" class="btn btn-light border">
                        <span class="bi bi-arrow-left me-2"></span>
                        Kembali
                    </a>
                </div>
            </div>
        </form>
    </div>
    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!-- pooper js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous">
    </script>
</body>

</html>