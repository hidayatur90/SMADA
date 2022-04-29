<?php

require_once('db_config.php');

$id_siswa = $_GET['id'];
 
$result = mysqli_query($conn, "SELECT * FROM detail_seragam WHERE id_siswa=$id_siswa");
 
while($row = mysqli_fetch_array($result))
{
	$nis = $row['nis'];
	$nama_siswa = $row['nama_siswa'];
	$uang_kesiswaan = $row['uang_kesiswaan'];
	$jenis_kelamin = $row['jenis_kelamin'];
	$jilbab = $_GET['jilbab'];
	$status = $row['status'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail data siswa</title>
</head>
<body>
    <table class="table table-light table-borderless">
        <tr>
            <th>NISN</th>
            <td>: <?= $nis; ?></td>
        </tr>
        <tr>
            <th>Nama</th>
            <td>: <?= $nama_siswa; ?></td>
        </tr>
        <tr>
            <th>Jenis Kelamin</th>
            <td>: <?= $jenis_kelamin; ?></td>
        </tr>
        <tr>
            <th>Berjilbab</th>
            <td>: <?= $jilbab; ?></td>
        </tr>
        <tr>
            <th>Total bayar</th>
            <td>: <?= $uang_kesiswaan; ?></td>
        </tr>
        <tr>
            <th>Status Bayar</th>
            <td>: <?= $status; ?></td>
        </tr>
    </table>
    <script>
        window.print();
    </script>
    <!-- <div class="col-12">
        <a href="index.php" class="btn btn-primary w-100 my-3">
            <i class="bi-arrow-left-short"></i> Back
        </a>
    </div> -->
    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>