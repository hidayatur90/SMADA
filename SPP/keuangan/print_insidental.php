<?php

require_once('../db/db_config.php');

$this_kelas = $_GET['kelas'];
$this_date = date('d-M-Y');
$all_kelas = [];
$sum_insidental = [];
if ($this_kelas == "Semua"){
    $get_kelas = mysqli_query($conn, "SELECT DISTINCT(kelas) as kelas FROM rekap ORDER BY kelas");
    while($row = mysqli_fetch_array($get_kelas)) {
        $all_kelas[] = $row['kelas'];
    }
    foreach ($all_kelas as $kelas) {
        $get_sum_nominal = mysqli_query($conn, "SELECT *,SUM(insidental) as sum_insidental FROM rekap WHERE kelas='$kelas' ORDER BY kelas");
        while($row = mysqli_fetch_array($get_sum_nominal)) {
            $sum_insidental[] = $row['sum_insidental'];
        }
    }

} else {
    $all_kelas[] = $this_kelas;
    $get_sum_nominal = mysqli_query($conn, "SELECT SUM(insidental) as sum_insidental FROM rekap WHERE kelas='$this_kelas'");
    while($row = mysqli_fetch_array($get_sum_nominal)) {
        $sum_insidental[] = $row['sum_insidental'];
    }
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
    <title>Cetak Cicilan Insidental</title>
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
            size: A3;
            margin: 0;
        }
        @media print {
            @page{
                size: landscape;
            }
            html, body {
                margin-top: 10px;
                width: 420mm;
                height: 297mm;
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
                <hs><strong>LAPORAN CICILAN INSIDENTAL / <?= $this_kelas ?></strong></h5>
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
                    <th scope="col">VII</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $sql = "SELECT * FROM insidental WHERE kelas='$all_kelas[$p]' ORDER BY nama";
                    $result = $conn->query($sql); 	
                    $i = 1;
                    while($data = $result->fetch_assoc()){ 
                    $cicilan = explode(",", $data['cicilan_insidental']);
                    $cicilan_after = [];
                    for ($i=0; $i < count($cicilan); $i++) { 
                        if((($i%2) == 0 ) && $i != 0){
                            $cicilan_after[] = $cicilan[$i];
                        }
                    }
                    $count = $cicilan >= 7 ? 7 : $cicilan;
                    $k = 0;?>
                    <tr>
                        <td class="text-start"><?= $data['kelas']; ?></td>
                        <td class="text-start"><?= $data['nipd']; ?></td>
                        <td class="text-start"><?= $data['nama']; ?></td>
                        <?php foreach ($cicilan_after as $cicil) { $k++;?>
                            <td class="text-end"><?= number_format((int)$cicil) ?></td>
                        <?php } ?>
                            <?php $kk = 7 - $k;
                            while ($kk > 0) { ?>
                                <td class="text-end">0</td>
                            <?php $kk--; } ?>
                    </tr>
                    <?php } ?>
                    <tr>
                        <?php $td = 0; while ($td < 3) {?>
                            <td style='border:none;'></td>
                        <?php $td++; } ?>
                        <td colspan="7" class="text-center"><strong><?= number_format($sum_insidental[$p]) ?></strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
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