<?php

require_once('../db/db_config.php');

$start_date = $_GET['start'];
$end_date = $_GET['end'];

session_start();
$nama_asli = $_SESSION['nama_asli'];

if ($start_date == "" || $end_date == ""){
    $get_sum_nominal = mysqli_query($conn, "SELECT SUM(pendidikan) as sum_spp, SUM(insidental) as sum_insidental, SUM(kesiswaan) as sum_kesiswaan, COUNT(DISTINCT(namapd)) as count_siswa FROM keuangan WHERE (penerima='$nama_asli')");
} else {
    $get_sum_nominal = mysqli_query($conn, "SELECT SUM(pendidikan) as sum_spp, SUM(insidental) as sum_insidental, SUM(kesiswaan) as sum_kesiswaan, COUNT(DISTINCT(namapd)) as count_siswa FROM keuangan WHERE (penerima='$nama_asli') AND (tanggal BETWEEN '$start_date' AND '$end_date')");
}

while($row = mysqli_fetch_array($get_sum_nominal))
{
    $sum_spp = $row['sum_spp'];
    $sum_insidental = $row['sum_insidental'];
    $sum_kesiswaan = $row['sum_kesiswaan'];
    $count_siswa = $row['count_siswa'];
}
$sum_total = $sum_spp + $sum_insidental + $sum_kesiswaan;

function penyebut($nilai) {
    $nilai = abs($nilai);
    $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    $temp = "";
    if ($nilai < 12) {
        $temp = " ". $huruf[$nilai];
    } else if ($nilai <20) {
        $temp = penyebut($nilai - 10). " belas";
    } else if ($nilai < 100) {
        $temp = penyebut($nilai/10)." puluh". penyebut($nilai % 10);
    } else if ($nilai < 200) {
        $temp = " seratus" . penyebut($nilai - 100);
    } else if ($nilai < 1000) {
        $temp = penyebut($nilai/100) . " ratus" . penyebut($nilai % 100);
    } else if ($nilai < 2000) {
        $temp = " seribu" . penyebut($nilai - 1000);
    } else if ($nilai < 1000000) {
        $temp = penyebut($nilai/1000) . " ribu" . penyebut($nilai % 1000);
    } else if ($nilai < 1000000000) {
        $temp = penyebut($nilai/1000000) . " juta" . penyebut($nilai % 1000000);
    } else if ($nilai < 1000000000000) {
        $temp = penyebut($nilai/1000000000) . " milyar" . penyebut(fmod($nilai,1000000000));
    } else if ($nilai < 1000000000000000) {
        $temp = penyebut($nilai/1000000000000) . " trilyun" . penyebut(fmod($nilai,1000000000000));
    }     
    return $temp;
}

function terbilang($nilai) {
    if($nilai<0) {
        $hasil = "minus ". trim(penyebut($nilai));
    } else {
        $hasil = trim(penyebut($nilai));
    }     		
    return $hasil;
}

$terbilang = terbilang($sum_total);

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
    <title>Cetak Rekapitulasi</title>
</head>
<body>
    <style>
        body {
            /* display: none; */
            padding: 10px;
            font-family: "Calibri", Times, sans-serif;
            border: 1px solid grey;
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
                margin-top: 10px;
                width: 210mm;
                height: 140mm;
            }
            .pagebreak { 
                page-break-after: always; 
            } /* page-break-after works, as well */
        }
        .guru {
            border: 1px solid black;
        }
    </style>
    <div id="print">
        <!-- Peserta Didik -->
        <div class="text-center">
            <h5><strong>BUKTI REKAP KEUANGAN</strong></h5>
            <h4><strong>SMA NEGERI 2 BONDOWOSO</strong></h4>
        </div>
        <hr style="height:5px;">

        <table class="table table-light table-borderless">
            <tr>
                <th>Nama Penerima </th>
                <td>: <?= $nama_asli ?></td>
            </tr>
            <tr>
                <th>Periode </th>
                <?php if($start_date=="" || $end_date==""){ ?>            
                    <td>: Keseluruhan </td>
                <?php }else{?>
                    <td>: <?= $start_date.' sampai dengan '.$end_date ?></td>
                <?php }?>    
            </tr>
            <tr>
                <th>Sejumlah (terbilang) </th>
                <td style="font-style: italic;">: <?= $terbilang;?></td>
            </tr>
            <tr>
                <th>Untuk Pembayaran </th>
                <td>
                    <table class="table table-borderless text-center" style="width:75%">
                    <tbody>
                        <tr>
                            <th class="text-start">1. Dana Pendidikan</th>
                            <td class="text-end"><?= "Rp. " . number_format($sum_spp); ?></td>
                        </tr>
                        <tr>
                            <th class="text-start">2. Sumbangan Insidental</th>
                            <td class="text-end"><?= "Rp. " . number_format($sum_insidental); ?></td>
                        </tr>
                        <tr>
                            <th class="text-start">3. Dana Kegiatan Kesiswaan</th>
                            <td class="text-end"><?= "Rp. " . number_format($sum_kesiswaan); ?></td>
                        </tr>
                    </tbody>
                </table>
            </tr>
        </table>
        
        <div style="float: left">
            <table class="table table-light table-borderless ms-2">
                <tr>
                    <th class="text-start align-middle" style="margin-top:100px;"><h5><strong>Sejumlah</strong></h5></th>
                    <td class="text-end" style="padding: 30px; border: 2px solid black;float: left;font-size: 30px"><?= "Rp. " . number_format($sum_total); ?></td>
                </tr>
            </table>
        </div>
        <div style="float: right">
            <table class="table table-light table-borderless me-2">
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
                        <td ><?= $nama_asli; ?></td>
                    </tr>
                </div>
            </table>
        </div>
    </div>

    <script>
        var url_string = document.URL;
        var url = new URL(url_string);
        var start = url.searchParams.get("start");
        var end = url.searchParams.get("end");
        window.print();
        window.onafterprint = function(){
            location.href = "rekap.php?start="+start+"&end="+end;
        }
    </script>
    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>