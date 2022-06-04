<?php

require_once('db_config.php');

session_start();
$username = $_SESSION['username'];

$id_siswa = $_GET['id'];

$select_nama_penerima = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
while($row = mysqli_fetch_array($select_nama_penerima))
{
	$id_user = $row['id_user'];
	$nama_user = $row['nama'];
}

$total_jilbab = 0;
$total_no_jilbab = 0;

$get_sum_jilbab = mysqli_query($conn, "SELECT jilbab FROM detail_seragam WHERE penerima='$nama_user'");
while($row = mysqli_fetch_array($get_sum_jilbab))
{
    if($row['jilbab'] == 'Ya'){
        $total_jilbab += 1;
    } else {
        $total_no_jilbab += 1;
    }
}

$get_total_terima = mysqli_query($conn, "SELECT SUM(total_bayar) as total_terima FROM detail_seragam WHERE penerima='$nama_user'");
while($row = mysqli_fetch_array($get_total_terima))
{
    $total_terima = $row['total_terima'];
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
    <!-- Jquery CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <title>Detail data siswa</title>
</head>
<body>
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
        }
        img {
            -webkit-filter: grayscale(100%); /* Safari 6.0 - 9.0 */
            filter: grayscale(100%);
        }
        div.h4,p {
            line-height: 50%;
        }
        tr {
            line-height: 50%;
        }
        hr {
            border-top: solid 1px #000 !important;
        }
        @page {
            size: A4;
            margin: 0;
        }
        @media print {
        html, body {
            width: 210mm;
            height: 297mm;
        }
        /* ... the rest of the rules ... */
        }
    </style>
    <!-- REKAP PEMBAYARAN SERAGAM -->
    <div class="mt-3" style="margin-bottom: 30px;">
        <div style="float: left; margin-right: 50px;">
            <img src="smada.png" width="80" height="80"/>
        </div>
        <div>
            <h4>SMAN 2 BONDOWOSO</h4>
            <p>Penerimaan Peserta Didik Baru</p>
            <p>Tahun 2022</p>
        </div>
    </div>
    <hr style="height:5px;">
    
    <h5 class="text-center"><strong>REKAP PEMBAYARAN SERAGAM</strong></h5>

    <table class="table table-light table-borderless">
        <tr>
            <th>Nama Penerima</th>
            <td>: <?= $nama_user; ?></td>
        </tr>
        <tr>
            <th>Tanggal </th>
            <td>: <?= date('d - m - Y');?></td>
        </tr>
        <tr style="padding: 5px;">
            <th>Jenis Seragam :</th>
        </tr>
        <tr>
            <td>1. Berjilbab</td>
            <td>: <?= $total_jilbab; ?></td>
        </tr>
        <tr>
            <td>2. Tidak Berjilbab</td>
            <td>: <?= $total_no_jilbab; ?></td>
        </tr>
        <tr>
            <th>Total Terima : </th>
            <td>: <?= "Rp " . number_format($total_terima,2,',','.'); ?></td>
        </tr>
    </table>

    <div style="float: right">
        <table class="table table-light table-borderless">
            <div>
                <tr>
                    <td>Bondowoso, <?= date("d-m-Y"); ?></td>
                </tr>
                <tr>
                    <td>Penerima</td>
                </tr>
                <tr>
                    <td ></td>
                </tr>
                <tr>
                    <td ></td>
                </tr>
                <tr>
                    <td ></td>
                </tr>
                <tr>
                    <td ></td>
                </tr>
                <tr>
                    <td ><?= $nama_user; ?></td>
                </tr>
            </div>
        </table>
    </div>

    <script>
        window.print();
        var id_siswa = $('#id_siswa').value;
        var nis = $('#nis').value;
        var nama_siswa = $('#nama_siswa').value;
        var jenis_kelamin = $('#jenis_kelamin').value;
        // var jilbab = $('#jilbab').value;
        var uang_kesiswaan = $('#uang_kesiswaan').value;

        window.onafterprint = function(){
            alert('Berhasil');
            location.href = "./detail_seragam.php";
        }
    </script>
    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>