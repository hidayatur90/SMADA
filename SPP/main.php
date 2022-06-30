<?php 

require_once('db_config.php');

session_start();
$nama = $_SESSION['username'];
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
}
$date = date('d-m-Y');

$nipd_siswa = $_GET['cari'];
if ($nipd_siswa == ""){
    $get_last_nominal = mysqli_query($conn, "SELECT spp as spp FROM detail_pembayaran");
    while($row = mysqli_fetch_array($get_last_nominal))
    {
        $last_nominal = $row['spp'];
    }
    $get_month = mysqli_query($conn, "SELECT bulan as bulan FROM detail_pembayaran");
    while($row = mysqli_fetch_array($get_month))
    {
        $month_2 = $row['bulan'];
    }
} else {
    $get_last_nominal = mysqli_query($conn, "SELECT spp as spp FROM detail_pembayaran WHERE NIPD=$nipd_siswa");
    while($row = mysqli_fetch_array($get_last_nominal))
    {
        $last_nominal = $row['spp'];
    }
    $get_month = mysqli_query($conn, "SELECT bulan as bulan FROM detail_pembayaran WHERE NIPD=$nipd_siswa");
    while($row = mysqli_fetch_array($get_month))
    {
        $month_2 = $row['bulan'];
    }
}

if(isset($_POST['submit'])) {
    $month = $_POST['month'];
    $nominal = $_POST['nominal'];
    $new_month = $month_2 . ',' . $month;
    require_once("db_config.php");
    $query = "UPDATE detail_pembayaran
            SET spp = $last_nominal+$nominal, bulan = '$new_month' 
            WHERE NIPD = $nipd_siswa;";
    $result = mysqli_query($conn, $query);
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Pembayaran SPP</title>
</head>
<body>
    <div class="container mt-3">
        <form action="" method="POST">
            <a href="logout.php" class="btn btn-danger mb-2">Logout</a>
        </form>
        <form action="main.php" method="GET">
            <div class="input-group my-3 col-12 col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-10">
                <input type="number" name="cari" class="form-control ms-3" placeholder="Cari NIPD Siswa">
                <input class="btn btn-primary" type="submit" value="Cari">
            </div>
        </form>
        <?php 
            if(isset($_GET['cari'])){
                $cari = $_GET['cari'];
            }
        ?>
        <div class="row">
            <div class="col-xl-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <strong>Data Pembayaran SPP</strong>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered text-center">
                            <tbody>
                                <?php 
                                if(isset($_GET['cari'])){
                                    $cari = $_GET['cari'];
                                    if ($cari == ""){ ?>
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
                                    <?php } else {
                                        $sql = "SELECT * FROM detail_pembayaran WHERE NIPD = $cari";		
                                        $result = $conn->query($sql);
                                    $i = 1;
                                    if (mysqli_num_rows($result) > 0){ 
                                    while($data = $result->fetch_assoc()){ ?>
                                    <table class="table table-borderless" style="width:25%">
                                        <div class="float-end">
                                            <button class="btn btn-success me-3 w-100 " data-bs-toggle="modal" data-bs-target="#rekapModal">Bayar</button>
                                        </div>
                                        <tr>
                                            <th>NIPD</th>
                                            <td>: <?= $data['NIPD']; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Nama Siswa</th>
                                            <td>: <?= $data['nama']; ?></td>
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
                                                <td><?= "Rp. " . number_format($data['spp'],2,',','.'); ?></td>
                                            </tr>
                                            <tr>
                                                <th>Insidental</th>
                                                <td><?= "Rp. " . number_format($data['isidental'],2,',','.'); ?></td>
                                            </tr>
                                            <tr>
                                                <th>Kesiswaan</th>
                                                <td><?= "Rp. " . number_format($data['kesiswaan'],2,',','.'); ?></td>
                                            </tr>
                                            <?php $i++; ?>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                    <?php } else { ?>
                                        <div class="text-center">
                                            <h3>Data Siswa Tidak ditemukan.</h3>
                                        </div>
                                    <?php } ?>
                                <?php }} ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="rekapModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Tambah Pembayaran</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="card-body">
                <p><strong>Tanggal : </strong><?= $date; ?></p>
                <form method="post" action="detail_siswa.php?id='<?= $nipd_siswa ?>'">
                    <input type="text" name="alredy_month" id="alredy_month" value="<?= $month_2 ?>" hidden>
                    <!-- Pendidikan -->
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="pendidikan" name="pendidikan">
                                <label class="form-check-label" for="pendidikan">
                                    <strong>Dana Pendidikan</strong> 
                                </label>
                                <!-- Nominal -->
                                <input type="number" class="form-control" min="0" name="nominal" id="nominal_pendidikan" onblur="findTotal()" placeholder="Nominal" autocomplete="off" required disabled oninvalid="this.setCustomValidity('Jumlah Nominal harus angka')" oninput="this.setCustomValidity('')"/>
                            </div>
                        </div>
                        <!-- Jumlah -->
                        <div class="col-6 mt-4">
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
                                <input type="number" class="form-control" min="0" name="nominal" id="nominal_insidental" onblur="findTotal()" placeholder="Nominal" autocomplete="off" required disabled oninvalid="this.setCustomValidity('Jumlah Nominal harus angka')" oninput="this.setCustomValidity('')"/>
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
                                <input type="number" class="form-control" min="0" name="nominal" id="nominal_kesiswaan" onblur="findTotal()" placeholder="Nominal" autocomplete="off" required disabled oninvalid="this.setCustomValidity('Jumlah Nominal harus angka')" oninput="this.setCustomValidity('')"/>
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
                            <input type="number" class="form-control" min="0" name="nominal_total" id="nominal_total" placeholder="Nominal" autocomplete="off" required disabled oninvalid="this.setCustomValidity('Jumlah Nominal harus angka')" oninput="this.setCustomValidity('')"/>
                        </div>
                    </div>

                    <div class="row mb-3 justify-content-end my-2">
                        <div class="col-sm-8 col-md-9 col-xl-12" style="text-align:end;">
                            <input type="submit" name="submit" class="create btn btn-success mx-3" value="Tambah">
                        </div>
                    </div>
                </form>

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
        
        month_spp.addEventListener("input", function(){
            nom_spp.value = this.value * 60000;
            nom_total.value = nom_spp.value;
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
                } 
            });
        });

        var alredy_month = document.getElementById("alredy_month");
        var list_month = alredy_month.value.split(",");
                                    
        $(document).ready(function(){
            var i;
            for (i = 0; i < list_month.length; i++) {
                $('select[name="month"]').on('change',function(){
                var $this = $(this);  
                $('select[name="month"]').find('option[value="'+ list_month[i] +'"]').prop('hidden', true);
                });
                $('select[name="month"]').trigger('change');
            }
        });
    </script>
</body>
</html>