<?php 

require_once('../db/db_config.php');

$date = date('d-m-Y');

$nipd_siswa = $_GET['cari'];

if(isset($_POST['submit'])) {
    session_start();
    $nama_asli = $_SESSION['nama_asli'];

    $get_data_siswa = mysqli_query($conn, "SELECT * FROM datapd WHERE nis=$nipd_siswa GROUP BY nama_pd");
    while($row = mysqli_fetch_array($get_data_siswa))
    {
        $nama = $row['nama_pd'];
        $kelas = $row['kelas'];
    }
    $tanggal = date('Y-m-d');
    $nipd = $nipd_siswa;
    $namapd = $nama;
    $kelas = $kelas;
    $insidental = $_POST['nominal_insidental'] ?: 0;
    $kesiswaan = $_POST['nominal_kesiswaan'] ?: 0;
    $pendidikan = $_POST['nominal_pendidikan'] ?: 0;
    $penerima = $nama_asli;
            
    $result = mysqli_query($conn, "INSERT INTO keuangan(tanggal,nipd,namapd,kelas,insidental,kesiswaan,pendidikan,penerima) VALUES('$tanggal','$nipd','$namapd','$kelas',$insidental,$kesiswaan,$pendidikan,'$penerima')");

    $get_data_rekap = mysqli_query($conn, "SELECT * FROM rekap WHERE nis=$nipd_siswa");
    while($row = mysqli_fetch_array($get_data_rekap))
    {
        $insidental_2 = $row['insidental'];
        $kesiswaan_2 = $row['kesiswaan'];
        $pendidikan_2 = $row['pendidikan'];
    }
    $insidental_rekap = $insidental_2 + $insidental;
    $kesiswaan_rekap = $kesiswaan_2 + $kesiswaan;
    $pendidikan_rekap = $pendidikan_2 + $pendidikan;
    $result = mysqli_query($conn, "UPDATE rekap SET insidental=$insidental_rekap,kesiswaan=$kesiswaan_rekap,pendidikan=$pendidikan_rekap WHERE nis=$nipd");
    
    if(($insidental != 0) || ($kesiswaan != 0)) {
        $get_cicilan = mysqli_query($conn, "SELECT cicilan_insidental, cicilan_kesiswaan FROM insidental WHERE nipd=$nipd_siswa");
        while($row = mysqli_fetch_array($get_cicilan))
        {
            $cicilan_insidental = $row['cicilan_insidental'];
            $cicilan_insidental = strlen($cicilan_insidental) > 0 ? $row['cicilan_insidental'].",".(string)$insidental : (string)$insidental;
            $result = mysqli_query($conn, "UPDATE insidental SET nipd=$nipd,nama='$namapd',kelas='$kelas',cicilan_insidental='$cicilan_insidental' WHERE nipd=$nipd_siswa");

            $cicilan_kesiswaan = $row['cicilan_kesiswaan'];
            $cicilan_kesiswaan = strlen($cicilan_kesiswaan) > 0 ? $row['cicilan_kesiswaan'].",".(string)$kesiswaan : (string)$kesiswaan;
            $result = mysqli_query($conn, "UPDATE insidental SET nipd=$nipd,nama='$namapd',kelas='$kelas',cicilan_kesiswaan='$cicilan_kesiswaan' WHERE nipd=$nipd_siswa");
        }
    }

    echo "
    <script>
        if (confirm('Data berhasil ditambahkan, Cetak bukti?')) {
            document.location.href = 'bukti_pembayaran.php?nipd=". $nipd ."';
        }
    </script>";
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
    <title>Pembayaran SPP</title>
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
        <a href="main.php" class="btn btn-secondary mb-2"><i class="bi bi-arrow-left me-2"></i>Kembali</a>
        <form action="detail_pembayaran.php" method="GET">
            <div class="input-group my-3 col-12 col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-10">
                <input type="number" name="cari" class="form-control" placeholder="Cari NIPD Siswa">
                <input class="btn btn-primary" type="submit" value="Cari">
            </div>
        </form>
        <?php 
            if(isset($_GET['cari'])){
                $cari = $_GET['cari'];
            }
        ?>
        <?php 
        if(isset($_GET['cari'])){
            $cari = $_GET['cari'];
            if ($cari == ""){ ?>
                <div class="row">
                    <div class="col-12">
                        <div class="card mb-4">
                            <div class="card-header">
                                <strong>Data Pembayaran SPP</strong>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered text-center">
                                    <tbody>
                                        <table class="table table-borderless" style="width:25%">
                                            <tr>
                                                <th>NIPD</th>
                                                <td>: - </td>
                                            </tr>
                                            <tr>
                                                <th>Nama Siswa</th>
                                                <td>: - </td>
                                            </tr>
                                            <tr>
                                                <th>Kelas </th>
                                                <td>: - </td>
                                            </tr>
                                        </table>
                                        <p><strong>Rekap Pembayaran yang telah masuk </strong></p>
                                        <table class="table table-bordered text-center">
                                            <tbody>
                                                <tr>
                                                    <th>Pendidikan</th>
                                                    <td>-</td>
                                                </tr>
                                                <tr>
                                                    <th>Insidental</th>
                                                    <td>-</td>
                                                </tr>
                                                <tr>
                                                    <th>Kesiswaan</th>
                                                    <td>-</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } else {
                    $sql = "SELECT *, SUM(pendidikan) as pendidikan, SUM(insidental) as insidental, SUM(kesiswaan) as kesiswaan FROM rekap WHERE nis = $cari GROUP BY nama_pd";		
                    $result = $conn->query($sql);
                    $i = 1;
                    if (mysqli_num_rows($result) > 0){ 
                    while($data = $result->fetch_assoc()){ ?>
                    <div class="row">
                        <div class="col-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <strong>Data Pembayaran SPP</strong>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered text-center">
                                        <table class="table table-borderless" style="width:80%">
                                            <tr>
                                                <th>NIPD</th>
                                                <td>: <?= $data['nis']; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Nama Siswa</th>
                                                <td>: <?= $data['nama_pd']; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Kelas </th>
                                                <td>: <?= $data['kelas'];?></td>
                                            </tr>
                                        </table>
                                        <p><strong>Rekap Pembayaran yang telah masuk </strong></p>
                                        <table class="table table-bordered text-center">
                                            <tbody>
                                                <tr>
                                                    <th>Pendidikan</th>
                                                    <td><?= "Rp. " . number_format($data['pendidikan'],2,',','.'); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Insidental</th>
                                                    <td><?= "Rp. " . number_format($data['insidental'],2,',','.'); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Kesiswaan</th>
                                                    <td><?= "Rp. " . number_format($data['kesiswaan'],2,',','.'); ?></td>
                                                </tr>
                                                <?php $i++; ?>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <strong>Data Pembayaran SPP</strong>
                                </div>
                            <div class="card-body">
                                <p><strong>Tanggal : </strong><?= $date; ?></p>
                                <form method="post" action="detail_pembayaran.php?cari=<?= $nipd_siswa ?>">
                                    <!-- Pendidikan -->
                                    <div class="row mb-3">
                                        <div class="col-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="pendidikan" name="pendidikan">
                                                <label class="form-check-label" for="pendidikan">
                                                    <strong>Dana Pendidikan</strong> 
                                                </label>
                                                <!-- Nominal -->
                                                <input type="number" class="form-control" min="0" name="nominal" id="nominal_pendidikan" onblur="findTotal()" placeholder="Nominal" autocomplete="off" required disabled oninvalid="this.setCustomValidity('Wajib diisi')" oninput="this.setCustomValidity('')"/>
                                                <input type="number" class="form-control" min="0" name="nominal_pendidikan" id="nominal_1" onblur="findTotal()" value="0" required hidden/>
                                            </div>
                                        </div>
                                        <!-- Jumlah -->
                                        <div class="col-6">
                                            <label class="form-check-label" for="jumlah_spp">
                                                <strong>Jumlah</strong> 
                                            </label>
                                            <input type="number" class="form-control" min="0" max="12" name="jumlah_spp" id="jumlah_spp" placeholder="Jumlah" autocomplete="off" required disabled oninvalid="this.setCustomValidity('Jumlah harus angka')" oninput="this.setCustomValidity('')"/>
                                        </div>
                                    </div>
                                    <!-- Insidental -->
                                    <div class="row mb-3">
                                        <div class="col">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="insidental" name="insidental">
                                                <label class="form-check-label" for="insidental">
                                                    <strong>Insidental</strong> 
                                                </label>
                                                <!-- Nominal -->
                                                <input type="number" class="form-control" min="0" name="nominal" id="nominal_insidental" onblur="findTotal()" placeholder="Nominal" autocomplete="off" required disabled oninvalid="this.setCustomValidity('Wajib diisi')" oninput="this.setCustomValidity('')"/>
                                                <input type="number" class="form-control" min="0" name="nominal_insidental" id="nominal_2" onblur="findTotal()" value="0" required hidden/>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Dana Kegiatan Kesiswaan -->
                                    <div class="row mb-3">
                                        <div class="col">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="kesiswaan" name="kesiswaan">
                                                <label class="form-check-label" for="kesiswaan">
                                                    <strong>Dana Kegiatan Kesiswaan</strong> 
                                                </label>
                                                <!-- Nominal -->
                                                <input type="number" class="form-control" min="0" name="nominal" id="nominal_kesiswaan" onblur="findTotal()" placeholder="Nominal" autocomplete="off" required disabled oninvalid="this.setCustomValidity('Wajib diisi')" oninput="this.setCustomValidity('')"/>
                                                <input type="number" class="form-control" min="0" name="nominal_kesiswaan" id="nominal_3" onblur="findTotal()" value="0" required hidden/>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Total -->
                                    <div class="row mb-3">
                                        <div class="col">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                <strong>Total</strong> 
                                            </label>
                                            <!-- Nominal -->
                                            <input type="number" class="form-control" min="0" name="nominal_total" id="nominal_total" placeholder="Nominal" autocomplete="off" value="0" required disabled oninvalid="this.setCustomValidity('Wajib diisi')" oninput="this.setCustomValidity('')"/>
                                        </div>
                                    </div>

                                    <div class="row mb-3 justify-content-end my-2">
                                        <div class="col-sm-8 col-md-9 col-xl-12" style="text-align:end;">
                                            <input type="submit" name="submit" id="submit" class="create btn btn-success mx-3" disabled value="Tambah">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>        
                        <?php } else { ?>
                            <div class="text-center">
                                <h3>Data Siswa Tidak ditemukan.</h3>
                            </div>
                        <?php } ?>
                <?php }} ?>
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
        var month_spp = document.getElementById("jumlah_spp");
        var nom_spp = document.getElementById("nominal_pendidikan");
        var nom_insidental = document.getElementById("nominal_insidental");
        var nom_kesiswaan = document.getElementById("nominal_kesiswaan");
        var nom_total = document.getElementById("nominal_total");
        var btn_submit = document.getElementById("submit");

        var nom_spp_2 = document.getElementById('nominal_1');
        var nom_insidental_2 = document.getElementById('nominal_2');
        var nom_kesiswaan_2 = document.getElementById('nominal_3');

        month_spp.addEventListener("input", function(){
            nom_spp.value = this.value * 150000;
            nom_spp_2.value = this.value * 150000;
            nom_total.value = nom_spp.value;
            if(this.value == 0){
                btn_submit.setAttribute("disabled", "true");
            } else if(this.value > 0) {
                btn_submit.removeAttribute("disabled");
            }
        });

        nom_insidental.addEventListener("input", function(){
            nom_insidental_2.value = this.value;
            if(this.value == 0){
                btn_submit.setAttribute("disabled", "true");
            } else if(this.value > 0) {
                btn_submit.removeAttribute("disabled");
            }
        });

        nom_kesiswaan.addEventListener("input", function(){
            nom_kesiswaan_2.value = this.value;
            if(this.value == 0){
                btn_submit.setAttribute("disabled", "true");
            } else if(this.value > 0) {
                btn_submit.removeAttribute("disabled");
            }
        });

        function findTotal(){
            var arr = document.getElementsByName('nominal');
            var tot=0;
            for(var i=0;i<arr.length;i++){
                if(parseInt(arr[i].value))
                    tot += parseInt(arr[i].value);
            }
            nom_total.value = tot;
        }
        
        $(function() {
            $('[id="pendidikan"]').change(function() {
                if ($(this).is(':checked')) {
                    month_spp.removeAttribute("disabled");
                } else {
                    $(nom_total).prop('value', nom_total.value - nom_spp.value);
                    $(month_spp).prop('disabled', true);
                    $(month_spp).prop('value', " ");
                    $(nom_spp).prop('value', " ");
                    $(nom_spp_2).prop('value', 0);
                } 
            });
        });
        $(function() {
            $('[id="insidental"]').change(function() {
                if ($(this).is(':checked')) {
                    nom_insidental.removeAttribute("disabled");
                } else {
                    $(nom_total).prop('value', nom_total.value - nom_insidental.value);
                    $(nom_insidental).prop('disabled', true);
                    $(nom_insidental).prop('value', " ");
                    $(nom_insidental_2).prop('value', 0);
                } 
            });
        });
        $(function() {
            $('[id="kesiswaan"]').change(function() {
                if ($(this).is(':checked')) {
                    nom_kesiswaan.removeAttribute("disabled");
                } else {
                    $(nom_total).prop('value', nom_total.value - nom_kesiswaan.value);
                    $(nom_kesiswaan).prop('disabled', true);
                    $(nom_kesiswaan).prop('value', " ");
                    $(nom_kesiswaan_2).prop('value', 0);
                } 
            });
        });
    </script>
</body>
</html>