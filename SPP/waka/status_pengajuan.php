<?php 
require_once('../db/db_config.php');

session_start();
$role = $_SESSION['role'];
$nama_asli = $_SESSION['nama_asli'];
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
    <title>Status Pengajuan</title>
    <style>
        body{
            background-color: #F4F4FF;
            background-repeat: no-repeat;
            background-size: 100% 125%;
            font-family: "Arial", Times, sans-serif;
        }
    </style>
</head>
<body>
    <div class="container mt-3">
        <?php if($role == "waka") {?>
            <a href="dash_waka.php" class="btn btn-secondary mb-2"><i class="bi bi-arrow-left me-2"></i>Kembali</a>
        <?php } else if ($role == "bendahara") {?>
            <a href="../bendahara/dash_bendahara.php" class="btn btn-secondary mb-2"><i class="bi bi-arrow-left me-2"></i>Kembali</a>
        <?php } ?>
        <div class="row">
            <div class="col-xl-12">
                <div class="card mb-4">
                    <div class="card-header">
                       <strong>Data Pengajuan Peminjaman</strong>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Oleh</th>
                                <th scope="col">Nominal</th>
                                <th scope="col">Keterangan</th>
                                <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $sql = "SELECT * FROM pengajuan WHERE nama='$nama_asli' ORDER BY tanggal";	
                                $result = $conn->query($sql); 	
                                $i = 1;
                                while($data = $result->fetch_assoc()){ ?>
                                <tr>
                                    <th><?= $i; ?></th>
                                    <td><?= $data['tanggal']; ?></td>
                                    <td><?= $data['nama']; ?></td>
                                    <td><?= $data['nominal']; ?></td>
                                    <td><?= $data['keterangan']; ?></td>
                                    <?php if($data['status'] == "Diajukan") { ?>
                                        <td>
                                            <input type="submit" class="btn btn-warning mx-3" value="Diajukan" disabled>
                                        </td>
                                    <?php } else if ($data['status'] == "Ditolak") { ?>
                                        <td>
                                            <input type="submit" class="btn btn-danger mx-3" value="Ditolak" disabled>
                                        </td>
                                    <?php } else { ?>
                                        <td>
                                            <input type="submit" class="btn btn-success mx-3" value="Disetujui" disabled>
                                        </td>
                                    <?php } ?>
                                    <?php $i++; ?>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script 
        src="https://code.jquery.com/jquery-3.6.0.slim.js"  integrity="sha256-HwWONEZrpuoh951cQD1ov2HUK5zA5DwJ1DNUXaM6FsY="
        crossorigin="anonymous">
    </script>
</body>
</html>