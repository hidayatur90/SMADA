<?php

require_once('db_config.php');

session_start();
$username = $_SESSION['username'];

$id_siswa = $_GET['id'];
 
$result = mysqli_query($conn, "SELECT * FROM detail_seragam WHERE id_siswa=$id_siswa");

while($row = mysqli_fetch_array($result))
{
	$no_pendaftaran = $row['no_pendaftaran'];
	$nama_siswa = $row['nama_siswa'];
	$total_bayar = $row['total_bayar'];
	$jenis_kelamin = $row['jenis_kelamin'];
	$asal_sekolah = $row['asal_sekolah'];
	$jilbab = $row['jilbab'];
    $penerima = $row['penerima'];
}

$select_nama_penerima = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
while($row = mysqli_fetch_array($select_nama_penerima))
{
	$id_user = $row['id_user'];
	$nama_user = $row['nama'];
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
    <!-- <link rel="stylesheet" type="text/css" href="print.css" media="print" /> -->
    <title>Detail data siswa</title>
</head>
<body>
    <style>
        body {
            /* display: none; */
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
        /* #noprint { display: none; }
        #print { display: block; } */
        /* ... the rest of the rules ... */
        }
    </style>
    <div id="noprint">
    </div>
    <div id="print">
    <!-- BUKTI PEMBAYARAN SERAGAM -->
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
    
    <h5 class="text-center"><strong>BUKTI PEMBAYARAN SERAGAM</strong></h5>

    <table class="table table-light table-borderless">
        <tr hidden>
            <th hidden>id</th>
            <td hidden id="id_siswa">: <?= $id_siswa; ?></td>
        </tr>
        <tr>
            <th>No. Pendaftaran</th>
            <td id="nis">: <?= $no_pendaftaran; ?></td>
        </tr>
        <tr>
            <th>Nama </th>
            <td id="nama_siswa">: <?= $nama_siswa;?></td>
        </tr>
        <tr>
            <th>Jenis Kelamin</th>
            <td id="jenis_kelamin">: <?= $jenis_kelamin; ?></td>
        </tr>
        <tr>
            <th>Asal Sekolah</th>
            <td id="asal_sekolah">: <?= $asal_sekolah; ?></td>
        </tr>
        <tr>
            <th>Jenis Seragam</th>
            <td id="jilbab">: <?= $jilbab; ?></td>
        </tr>
        <tr>
            <th>Total Bayar</th>
            <td id="total_bayar">: <?= "Rp " . number_format($total_bayar,2,',','.'); ?></td>
        </tr>
        <tr style="margin: 10px;">
            <th>Keterangan</th>
            <td id="keterangan" width="165" style="padding: 30px; border: 2px solid black;float: left;font-size: 30px"><strong>LUNAS</strong></td>
        </tr>
    </table>

    <div style="float: right">
        <table class="table table-light table-borderless">
            <div>
                <tr>
                    <td>Bondowoso, <?= date("d - m - Y"); ?></td>
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

    <!-- BUKTI PEMBAYARAN SERAGAM -->
    <p style="margin-top: 920px;">.</p>
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
    
    <h5 class="text-center"><strong>BUKTI PEMBAYARAN SERAGAM</strong></h5>

    <table class="table table-light table-borderless">
        <tr hidden>
            <th hidden>id</th>
            <td hidden id="id_siswa">: <?= $id_siswa; ?></td>
        </tr>
        <tr>
            <th>No. Pendaftaran</th>
            <td id="nis">: <?= $no_pendaftaran; ?></td>
        </tr>
        <tr>
            <th>Nama </th>
            <td id="nama_siswa">: <?= $nama_siswa;?></td>
        </tr>
        <tr>
            <th>Jenis Kelamin</th>
            <td id="jenis_kelamin">: <?= $jenis_kelamin; ?></td>
        </tr>
        <tr>
            <th>Asal Sekolah</th>
            <td id="asal_sekolah">: <?= $asal_sekolah; ?></td>
        </tr>
        <tr>
            <th>Jenis Seragam</th>
            <td id="jilbab">: <?= $jilbab; ?></td>
        </tr>
        <tr>
            <th>Total Bayar</th>
            <td id="total_bayar">: <?= $total_bayar; ?></td>
        </tr>
        <tr style="margin: 10px;">
            <th>Keterangan</th>
            <td id="keterangan" width="165" style="padding: 30px; border: 2px solid black;float: left;font-size: 30px"><strong>LUNAS</strong></td>
        </tr>
    </table>

    <div style="float: right">
        <table class="table table-light table-borderless">
            <div>
                <tr>
                    <td>Bondowoso, <?= date("d - m - Y"); ?></td>
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
    </div>

    <script>
        // window.print();
        // window.onafterprint = window.close;
        (function() {
        var beforePrint = function() {
            location.href = "./detail_seragam.php";
        };
        var afterPrint = function() {
            location.href = "./detail_seragam.php";
            <?php
            // update penerima
            $date = date('Y-m-d');
            $update = "UPDATE detail_seragam SET tanggal='$date', penerima='$nama_user' WHERE id_siswa=$id_siswa";
            $stmt = $conn->prepare($update);
            $stmt->execute(); ?>
        };

        if (window.matchMedia) {
            var mediaQueryList = window.print();
            mediaQueryList.addListener(function(mql) {
                if (mql.matches) {
                    beforePrint();
                } else {
                    afterPrint();
                }
            });
        }

        window.onbeforeprint = beforePrint;
        window.onafterprint = afterPrint;
    }());
        // window.onafterprint = function(){
        //     location.href = "./detail_seragam.php";
        //     <?php
        //     // update penerima
        //     $date = date('Y-m-d');
        //     $update = "UPDATE detail_seragam SET tanggal='$date', penerima='$nama_user' WHERE id_siswa=$id_siswa";
        //     $stmt = $conn->prepare($update);
        //     $stmt->execute(); ?>
        // }
    </script>
    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>