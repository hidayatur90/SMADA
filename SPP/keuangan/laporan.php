<?php 

require_once('../db/db_config.php');

session_start();
$role = $_SESSION['role'];

$this_kelas = $_GET['kelas'];

$all_kelas = [];
$get_kelas = mysqli_query($conn, "SELECT DISTINCT(kelas) as kelas FROM rekap ORDER BY kelas");
while($row = mysqli_fetch_array($get_kelas))
{
    $all_kelas[] = $row['kelas'];
}
if ($this_kelas == "Semua"){
    $get_sum_nominal = mysqli_query($conn, "SELECT *,SUM(insidental) as sum_insidental, SUM(kesiswaan) as sum_kesiswaan, SUM(pendidikan) as sum_pendidikan FROM rekap");
} else {
    $get_sum_nominal = mysqli_query($conn, "SELECT *,SUM(insidental) as sum_insidental, SUM(kesiswaan) as sum_kesiswaan, SUM(pendidikan) as sum_pendidikan FROM rekap WHERE kelas='$this_kelas' ORDER BY nama_pd");
}
while($row = mysqli_fetch_array($get_sum_nominal))
{
    $sum_spp = $row['sum_pendidikan'];
    $sum_insidental = $row['sum_insidental'];
    $sum_kesiswaan = $row['sum_kesiswaan'];
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
    <title>Laporan Keuangan</title>
    <style>
        body{
            background-color: #F4F4FF;
            background-repeat: no-repeat;
            background-size: 100% 125%;
            font-family: "Arial", Times, sans-serif;
        }
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
</head>
<body>
    <div class="container mt-3">
        <?php if($role == "petugas") {?>
            <a href="main.php" class="btn btn-secondary mb-2"><i class="bi bi-arrow-left me-2"></i>Kembali</a>
        <?php } else if ($role == "kepsek") {?>
            <a href="../kepsek/tinjau.php" class="btn btn-secondary mb-2"><i class="bi bi-arrow-left me-2"></i>Kembali</a>
        <?php } ?>
        <div class="row">
            <div class="col-6 mb-2">
                <label for="kelas"><strong>Kelas : </strong></label>
                <select class="form-select w-25" id="kelas" name="kelas">
                    <option value="Semua">Semua</option>
                    <option selected hidden><?= $this_kelas; ?></option>
                    <?php foreach($all_kelas as $kelas) { ?>
                        <option value="<?= $kelas; ?>"><?= $kelas; ?></option>
                    <?php }; ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card mb-4">
                    <?php if ($kelas == "Semua"){ ?>
                        <div class="card-header">
                            Laporan Administrasi Keuangan (Keseluruhan)
                        </div>
                    <?php } else { ?>
                        <div class="card-header">
                            Laporan Administrasi Keuangan <strong><?= $this_kelas ?></strong>
                        </div>
                    <?php } ?>
                    <div class="card-body">
                        <table class="fixed_header table table-bordered text-center">
                            <thead>
                                <tr>
                                <th scope="col">NIPD</th>
                                <th scope="col">Nama Siswa</th>
                                <th scope="col">Kelas</th>
                                <th scope="col">Insidental</th>
                                <th scope="col">Kesiswaan</th>
                                <th scope="col">Pendidikan</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                if(($_GET['kelas']) != "Semua"){
                                    $sql = "SELECT * FROM rekap WHERE kelas='$this_kelas' ORDER BY nama_pd ASC";		
                                    $result = $conn->query($sql);
                                    if (mysqli_num_rows($result) == 0) { ?>
                                        <div class="text-center">
                                            <h3>Tidak ada data.</h3>
                                        </div>
                                    <?php }	
                                }else{
                                    $sql = "SELECT * FROM rekap ORDER BY nama_pd ASC";	
                                    $result = $conn->query($sql); 	
                                }
                                $i = 1;
                                while($data = $result->fetch_assoc()){ ?>
                                <tr>
                                    <td><?= $data['nis']; ?></td>
                                    <td><?= $data['nama_pd']; ?></td>
                                    <td><?= $data['kelas']; ?></td>
                                    <td><?= $data['insidental']; ?></td>
                                    <td><?= $data['kesiswaan']; ?></td>
                                    <td><?= $data['pendidikan']; ?></td>
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
                                                <td class="text-end"><?= "Rp. " . number_format($sum_spp); ?></td>
                                            </tr>
                                            <tr>
                                                <th class="text-start">Jumlah Insidental : </th>
                                                <td class="text-end"><?= "Rp. " . number_format($sum_insidental); ?></td>
                                            </tr>
                                            <tr>
                                                <th class="text-start">Jumlah Kesiswaan : </th>
                                                <td class="text-end"><?= "Rp. " . number_format($sum_kesiswaan); ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <hr style="height:2px; width:85%">
                                    <table class="table table-borderless" style="width: 80%">
                                        <tr>
                                            <th class="text-start"> <h5>Total : </h5></th>
                                            <td class="text-end"><h5><?= "Rp. " . number_format($sum_total); ?></h5></td>
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
                                        <a class="btn btn-warning" href="print_laporan.php?kelas=<?=$this_kelas?>">Cetak Insidental</a>
                                        <a class="btn btn-warning" href="print_laporan.php?kelas=<?=$this_kelas?>">Cetak Kesiswaan</a>
                                        <a class="btn btn-success" href="print_laporan.php?kelas=<?=$this_kelas?>">Cetak Laporan</a>
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
        var kelas = document.getElementById('kelas');

        kelas.addEventListener("input", function(){
            var strUser = this.value;
            var nextURL = 'http://localhost:8080/phphida/SMADA/SPP/keuangan/laporan.php?kelas=' + strUser;
            window.location.replace(nextURL);
        });
        
    </script>
</body>
</html>