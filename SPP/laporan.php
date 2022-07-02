<?php 

require_once('db_config.php');
$start_date = $_GET['start'];
$end_date = $_GET['end'];

if ($start_date == "" || $end_date == ""){
    $get_sum_nominal = mysqli_query($conn, "SELECT SUM(pendidikan) as sum_spp, SUM(insidental) as sum_insidental, SUM(kesiswaan) as sum_kesiswaan, COUNT(DISTINCT(namapd)) as count_siswa FROM keuangan");
} else {
    $get_sum_nominal = mysqli_query($conn, "SELECT SUM(pendidikan) as sum_spp, SUM(insidental) as sum_insidental, SUM(kesiswaan) as sum_kesiswaan, COUNT(DISTINCT(namapd)) as count_siswa FROM keuangan WHERE tanggal BETWEEN '$start_date' AND '$end_date'");
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Laporan Pembayaran</title>
</head>
<body>
    <style>
        .fixed_header{
            table-layout: fixed;
            border-collapse: collapse;
        }

        .fixed_header tbody{
            display:block;
            width: 100%;
            overflow: auto;
            /* overflow: hidden; */
            height: 300px;
        }

        .fixed_header thead tr {
            display: block; 
        }

        .fixed_header th, .fixed_header td {
            padding: 5px;
            width: 200px;
        }
    </style>
    <div class="container mt-3">
        <a href="main.php" class="btn btn-secondary mb-2">Kembali</a>
        <div class="row">
            <div class="col-3 mb-2">
                <label for="kelas"><strong>Tanggal : </strong></label>
                <input type="date" name="start_date" id="start_date" value="<?= $start_date ?>">
            </div>
            <div class="col-3 mb-2">
                <label for="kelas"><strong>Sampai : </strong></label>
                <input type="date" name="end_date" id="end_date" value="<?= $end_date ?>">
            </div>
            <div class="col-6 mb-2 text-end">
                <label for="kelas">Jumlah peserta didik yang melakukan pembayaran : <strong><?= $count_siswa ?></strong></label>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card mb-4">
                    <?php if ($end_date == ""){ ?>
                        <div class="card-header">
                            Laporan Pembayaran Keseluruhan
                        </div>
                    <?php } else { ?>
                        <div class="card-header">
                            Laporan Pembayaran Tanggal <strong><?= $start_date ?></strong> sampai <strong><?= $end_date ?></strong>
                        </div>
                    <?php } ?>
                    <div class="card-body">
                        <table class="fixed_header table table-bordered text-center">
                            <thead>
                                <tr>
                                <th scope="col">Tanggal</th>
                                <th scope="col">NIPD</th>
                                <th scope="col">Nama Siswa</th>
                                <th scope="col">Kelas</th>
                                <th scope="col">Insidental</th>
                                <th scope="col">Kesiswaan</th>
                                <th scope="col">Pendidikan</th>
                                <th scope="col">Penerima</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                if(($_GET['end']) != ""){
                                    $sql = "SELECT * FROM keuangan WHERE tanggal BETWEEN '$start_date' AND '$end_date' ORDER BY id DESC";		
                                    $result = $conn->query($sql);
                                    if (mysqli_num_rows($result) == 0) { ?>
                                        <div class="text-center">
                                            <h3>Tidak ada data.</h3>
                                        </div>
                                    <?php }	
                                }else{
                                    $sql = "SELECT * FROM keuangan ORDER BY id DESC LIMIT 50";	
                                    $result = $conn->query($sql); 	
                                }
                                $i = 1;
                                while($data = $result->fetch_assoc()){ ?>
                                <tr>
                                    <td><?= $data['tanggal']; ?></td>
                                    <td><?= $data['nipd']; ?></td>
                                    <td><?= $data['namapd']; ?></td>
                                    <td><?= $data['kelas']; ?></td>
                                    <td><?= $data['insidental']; ?></td>
                                    <td><?= $data['kesiswaan']; ?></td>
                                    <td><?= $data['pendidikan']; ?></td>
                                    <td><?= $data['penerima']; ?></td>
                                    <?php $i++; ?>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>

                        <div class="rekap">
                            <div class="row">
                                <div class="col-6">
                                    <table class="table table-borderless" style="width: 80%">
                                        <tbody>
                                            <tr>
                                                <th class="text-start">Jumlah SPP : </th>
                                                <td class="text-end"><?= "Rp. " . number_format($sum_spp,2,',','.'); ?></td>
                                            </tr>
                                            <tr>
                                                <th class="text-start">Jumlah Insidental : </th>
                                                <td class="text-end"><?= "Rp. " . number_format($sum_insidental,2,',','.'); ?></td>
                                            </tr>
                                            <tr>
                                                <th class="text-start">Jumlah Kesiswaan : </th>
                                                <td class="text-end"><?= "Rp. " . number_format($sum_kesiswaan,2,',','.'); ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <hr style="height:2px; width:85%">
                                    <table class="table table-borderless" style="width: 80%">
                                        <tr>
                                            <th class="text-start"> <h5>Total : </h5></th>
                                            <td class="text-end"><h5><?= "Rp. " . number_format($sum_total,2,',','.'); ?></h5></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <strong>Total Terbilang</strong>
                                        </div>
                                        <div class="card-body">
                                            <?= $terbilang?>
                                        </div>
                                    </div>
                                    <div class="download mt-3 text-end">
                                        <a class="btn btn-success" href="">Cetak</a>
                                    </div>
                                </div>
                            </div>
                        </div>
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
    <script>
        var start_date = document.getElementById('start_date');
        var end_date = document.getElementById('end_date');

        end_date.addEventListener("input", function(){
            var strUser = this.value;
            var nextURL = 'http://localhost:8080/phphida/SMADA/SPP/rekap.php?start=' + start_date.value + '&end=' + strUser;
            window.location.replace(nextURL);
        });
        
    </script>
</body>
</html>