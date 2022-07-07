<?php

require_once('../db/db_config.php');

$nipd = $_GET['nipd'];

$get_max_id = mysqli_query($conn, "SELECT max(id) as max_id FROM keuangan WHERE nipd=$nipd");
while($row = mysqli_fetch_array($get_max_id))
{
	$last_record = $row['max_id'];
}

$get_last_record = mysqli_query($conn, "SELECT * FROM keuangan WHERE nipd=$nipd AND id=$last_record");
while($row = mysqli_fetch_array($get_last_record))
{
	$namapd = $row['namapd'];
	$kelas = $row['kelas'];
	$insidental = $row['insidental'];
	$kesiswaan = $row['kesiswaan'];
	$pendidikan = $row['pendidikan'];
	$penerima = $row['penerima'];
}

$sum_total = $insidental + $kesiswaan + $pendidikan;

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
    <title>Cetak Bukti Pembayaran</title>
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
        <div style="margin-bottom: 30px;">
            <div style="float: left; margin-left: 10px;">
                <p>Lebar 1. Untuk Peserta didik</p>
            </div>
            <div style="float: right; margin-right: 10px;">
                <p><strong>NIPD. <?= $nipd; ?></strong></p>
            </div>
        </div><br>
        <div class="text-center">
            <h5><strong>BUKTI PEMBAYARAN</strong></h5>
            <h4><strong>SMA NEGERI 2 BONDOWOSO</strong></h4>
        </div>
        <hr style="height:5px;">

        <table class="table table-light table-borderless">
            <tr>
                <th>Terima dari </th>
                <td>: <?= $namapd." / ".$kelas ?></td>
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
                            <td class="text-end"><?= "Rp. " . number_format($pendidikan,2,',','.'); ?></td>
                        </tr>
                        <tr>
                            <th class="text-start">2. Sumbangan Insidental</th>
                            <td class="text-end"><?= "Rp. " . number_format($insidental,2,',','.'); ?></td>
                        </tr>
                        <tr>
                            <th class="text-start">3. Dana Kegiatan Kesiswaan</th>
                            <td class="text-end"><?= "Rp. " . number_format($kesiswaan,2,',','.'); ?></td>
                        </tr>
                    </tbody>
                </table>
            </tr>
        </table>
        
        <div style="float: left">
            <table class="table table-light table-borderless ms-2">
                <tr>
                    <th class="text-start align-middle" style="margin-top:100px;"><h5><strong>Sejumlah</strong></h5></th>
                    <td class="text-end" style="padding: 30px; border: 2px solid black;float: left;font-size: 30px"><?= "Rp. " . number_format($sum_total,2,',','.'); ?></td>
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
                        <td ><?= $penerima; ?></td>
                    </tr>
                </div>
            </table>
        </div>
    </div>

    <div class="pagebreak"> </div>

    <div class="print" style="margin-top:10px; border: 1px solid grey; height:100%; padding:10px">

        <!-- Guru -->
        <div class="mt-3" style="margin-bottom: 30px; margin-top: 50px;">
            <div style="float: left; margin-left: 10px;">
                <p>Lebar 2. Untuk Penerima</p>
            </div>
            <div style="float: right; margin-right: 10px;">
                <p><strong>NIPD. <?= $nipd; ?></strong></p>
            </div>
        </div><br>
        <div class="text-center">
            <h5><strong>BUKTI PEMBAYARAN</strong></h5>
            <h4><strong>SMA NEGERI 2 BONDOWOSO</strong></h4>
        </div>
        <hr style="height:5px;">
    
        <table class="table table-light table-borderless">
            <tr>
                <th>Terima dari </th>
                <td>: <?= $namapd ." / ".$kelas; ?></td>
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
                            <td class="text-end"><?= "Rp. " . number_format($pendidikan,2,',','.'); ?></td>
                        </tr>
                        <tr>
                            <th class="text-start">2. Sumbangan Insidental</th>
                            <td class="text-end"><?= "Rp. " . number_format($insidental,2,',','.'); ?></td>
                        </tr>
                        <tr>
                            <th class="text-start">3. Dana Kegiatan Kesiswaan</th>
                            <td class="text-end"><?= "Rp. " . number_format($kesiswaan,2,',','.'); ?></td>
                        </tr>
                    </tbody>
                </table>
            </tr>
        </table>
    
        <div style="float: left">
            <table class="table table-light table-borderless ms-2">
                <tr>
                    <th class="text-start align-middle" style="margin-top:100px;"><h5><strong>Sejumlah</strong></h5></th>
                    <td class="text-end" style="padding: 30px; border: 2px solid black;float: left;font-size: 30px"><?= "Rp. " . number_format($sum_total,2,',','.'); ?></td>
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
                        <td ><?= $penerima; ?></td>
                    </tr>
                </div>
            </table>
        </div>
    </div>

    <script>
        var url_string = document.URL;
        var url = new URL(url_string);
        var nipd = url.searchParams.get("nipd");
        window.print();
        window.onafterprint = function(){
            location.href = "detail_pembayaran.php?cari="+nipd;
        }
    </script>
    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>