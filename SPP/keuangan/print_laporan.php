<?php

require_once('../db/db_config.php');

$this_kelas = $_GET['kelas'];
$this_date = date('d-M-Y');
$all_kelas = [];
if ($this_kelas == "Semua"){
    $get_kelas = mysqli_query($conn, "SELECT DISTINCT(kelas) as kelas FROM rekap ORDER BY kelas");
    while($row = mysqli_fetch_array($get_kelas)) {
        $all_kelas[] = $row['kelas'];
    }
    foreach ($all_kelas as $kelas) {
        $get_sum_nominal = mysqli_query($conn, "SELECT *,SUM(insidental) as sum_insidental, SUM(kesiswaan) as sum_kesiswaan, SUM(pendidikan) as sum_pendidikan FROM rekap WHERE kelas='$kelas' ORDER BY kelas");
    }

    $get_sum_all = mysqli_query($conn, "SELECT *,SUM(insidental) as sum_insidental, SUM(kesiswaan) as sum_kesiswaan, SUM(pendidikan) as sum_pendidikan FROM rekap");
    while($row = mysqli_fetch_array($get_sum_all)){
        $sum_spp_all = $row['sum_pendidikan'];
        $sum_insidental_all = $row['sum_insidental'];
        $sum_kesiswaan_all = $row['sum_kesiswaan'];
    }
    $sum_all = $sum_spp_all + $sum_insidental_all + $sum_kesiswaan_all;

} else {
    $all_kelas[] = $this_kelas;
    $get_sum_nominal = mysqli_query($conn, "SELECT *,SUM(insidental) as sum_insidental, SUM(kesiswaan) as sum_kesiswaan, SUM(pendidikan) as sum_pendidikan FROM rekap WHERE kelas='$this_kelas' ORDER BY nama_pd");
}
while($row = mysqli_fetch_array($get_sum_nominal))
{
    $sum_spp = $row['sum_pendidikan'];
    $sum_insidental = $row['sum_insidental'];
    $sum_kesiswaan = $row['sum_kesiswaan'];
}
$sum_total = $sum_spp + $sum_insidental + $sum_kesiswaan;

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
            /* @page{
                size: landscape;
            } */
            html, body {
                margin-top: 10px;
                width: 300mm;
                height: 140mm;
            }
        }
        .guru {
            border: 1px solid black;
        }
    </style>
    <?php 
    $p = 0;
    while ($p < count($all_kelas)){ ?>
    <div style="page-break-after:always;">
        <div id="print">
            <div class="text-center">
                <hs><strong>LAPORAN ADMINISTRASI KEUANGAN / <?= $all_kelas[$p] ?></strong></h5>
                <p><?= $this_date ?></p>
            </div>

            <table class="table table-bordered">
                <thead class="text-center">
                    <tr>
                    <th scope="col">Kelas</th>
                    <th scope="col">NIPD</th>
                    <th scope="col">Nama Peserta Didik</th>
                    <th scope="col">I</th>
                    <th scope="col">II</th>
                    <th scope="col">III</th>
                    <th scope="col">IV</th>
                    <th scope="col">V</th>
                    <th scope="col">VI</th>
                    <th scope="col">Insidental</th>
                    <th scope="col">Kesiswaan</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $sql = "SELECT * FROM rekap WHERE kelas='$all_kelas[$p]' ORDER BY nama_pd";
                    $result = $conn->query($sql); 	
                    $i = 1;
                    $x = 0;
                    $y = 0;
                    while($data = $result->fetch_assoc()){ 
                    $count_pendidikan = $data['pendidikan']/150000;
                    $count = $count_pendidikan >= 6 ? 6 : $count_pendidikan;
                    $j = 1;?>
                    <tr>
                        <td class="text-start"><?= $data['kelas']; ?></td>
                        <td class="text-start"><?= $data['nis']; ?></td>
                        <td class="text-start"><?= $data['nama_pd']; ?></td>
                        <?php while($j <= $count) { ?>
                            <td class="text-end"><?= number_format(150000) ?></td>
                        <?php $j++; }
                            if(($j > $count) && ($count < 6)){ 
                                $k = 6 - $count;
                                while ($k > 0) {?>
                                    <td class="text-end">0</td>
                                <?php $k--;?>
                            <?php $y += 1; }} ?>
                        <td class="text-end"><?= number_format($data['insidental']); ?></td>
                        <td class="text-end"><?= number_format($data['kesiswaan']); ?></td>
                        <?php $i++; $x += 1; ?>
                    </tr>
                    <?php } ?>
                    <tr>
                        <?php $td = 0; while ($td < 3) {?>
                            <td style='border:none;'></td>
                        <?php $td++; } ?>
                        <?php 
                            $tot = 3*($i - 1) - $y; 
                            $sum_tot = $tot * 150000;
                        ?>
                        <td colspan="6" class="text-center"><strong><?= number_format($sum_spp) ?></strong></td>
                        <td class="text-end"><strong><?= number_format($sum_insidental) ?></strong></td>
                        <td class="text-end"><strong><?= number_format($sum_kesiswaan) ?></strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <?php if($p == (count($all_kelas)-1)) { ?>
            <?php if($this_kelas == "Semua") {?>
                <div class="total">
                    <h5>Rekap Total :</h5>
                    <table class="table table-borderless" style="width: 50%">
                    <tbody>
                        <tr>
                            <th class="text-start">Dana Pendidikan : </th>
                            <td class="text-end"><?= "Rp. " . number_format($sum_spp_all); ?></td>
                        </tr>
                        <tr>
                            <th class="text-start">Dana Insidental : </th>
                            <td class="text-end"><?= "Rp. " . number_format($sum_insidental_all); ?></td>
                        </tr>
                        <tr>
                            <th class="text-start">Dana Kesiswaan : </th>
                            <td class="text-end"><?= "Rp. " . number_format($sum_kesiswaan_all); ?></td>
                        </tr>
                    </tbody>
                </table>
                <hr style="height:2px; width:55%">
                <table class="table table-borderless" style="width: 50%">
                    <tr>
                        <th class="text-start"> <h5>Total : </h5></th>
                        <td class="text-end"><h5><?= "Rp. " . number_format($sum_all); ?></h5></td>
                    </tr>
                </table>
                </div>
            <?php } else { ?>
                <div class="total">
                    <h5>Rekap Total :</h5>
                    <table class="table table-borderless" style="width: 50%">
                    <tbody>
                        <tr>
                            <th class="text-start">Dana Pendidikan : </th>
                            <td class="text-end"><?= "Rp. " . number_format($sum_spp); ?></td>
                        </tr>
                        <tr>
                            <th class="text-start">Dana Insidental : </th>
                            <td class="text-end"><?= "Rp. " . number_format($sum_insidental); ?></td>
                        </tr>
                        <tr>
                            <th class="text-start">Dana Kesiswaan : </th>
                            <td class="text-end"><?= "Rp. " . number_format($sum_kesiswaan); ?></td>
                        </tr>
                    </tbody>
                    </table>
                    <hr style="height:2px; width:55%">
                    <table class="table table-borderless" style="width: 50%">
                        <tr>
                            <th class="text-start"><h5>Total : </h5></th>
                            <td class="text-end"><h5><?= "Rp. " . number_format($sum_total); ?></h5></td>
                        </tr>
                    </table>
                </div>
            <?php } ?>
        <?php } ?>
    </div>
    <?php $p++; } ?>
    <script>
        var url_string = document.URL;
        var url = new URL(url_string);
        var kelas = url.searchParams.get("kelas");
        window.print();
        window.onafterprint = function(){
            location.href = "laporan.php?kelas="+kelas;
        }
    </script>
    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>