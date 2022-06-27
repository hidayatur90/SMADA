<?php 

require_once('db_config.php');

$id_siswa = $_GET['id'];
$get_last_nominal = mysqli_query($conn, "SELECT spp as spp FROM detail_pembayaran WHERE id=$id_siswa");
while($row = mysqli_fetch_array($get_last_nominal))
{
    $last_nominal = $row['spp'];
}
$get_month = mysqli_query($conn, "SELECT bulan as bulan FROM detail_pembayaran WHERE id=$id_siswa");
while($row = mysqli_fetch_array($get_month))
{
    $month_2 = $row['bulan'];
}

if(isset($_POST['submit'])) {
    $month = $_POST['month'];
    $nominal = $_POST['nominal'];
    $new_month = $month_2 . ',' . $month;
    require_once("db_config.php");
    $query = "UPDATE detail_pembayaran
            SET spp = $last_nominal+$nominal, bulan = '$new_month' 
            WHERE id = $id_siswa;";
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
    <title>Nama Siswa</title>
</head>
<body>
    <div class="container mt-3">
        <div class="row">
            <div class="col-xl-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <strong>Data Siswa</strong>
                    </div>
                    <div class="card-body">
                        <div class="float-end">
                            <a href="create.php" class="btn btn-warning">
                                <i class="bi bi-plus-circle-fill white"></i>
                                Rekap
                            </a>
                        </div>
                        <?php 
                            $sql = "SELECT * FROM detail_pembayaran WHERE id = '$id_siswa'";		
                            $result = $conn->query($sql);		
                            $i = 1;
                            while($data = $result->fetch_assoc()){ ?>

                        <table class="table table-borderless" style="width:25%">
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
                        <p><strong>Data Pembayaran</strong></p>
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Sisa</th>
                                    <th scope="col">Detail</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>Pendidikan</th>
                                    <td><?= "Rp. " . number_format($data['spp'],2,',','.'); ?></td>
                                    <td>
                                        <button class="btn btn-success mx-2" data-bs-toggle="modal" data-bs-target="#rekapModal">Bayar</button>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Insidental</th>
                                    <td><?= "Rp. " . number_format($data['isidental'],2,',','.'); ?></td>
                                    <td><a href="print.php?" class="btn btn-success mx-2">Bayar</a></td>
                                </tr>
                                <tr>
                                    <th>Kesiswaan</th>
                                    <td><?= "Rp. " . number_format($data['kesiswaan'],2,',','.'); ?></td>
                                    <td><a href="print.php?" class="btn btn-success mx-2">Bayar</a></td>
                                </tr>
                                <?php $i++; ?>
                                </form>
                                <?php } ?>
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
            <h5 class="modal-title" id="exampleModalLabel">Uang Pendidikan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="card-body">
                <form method="post" action="detail_siswa.php?id='<?= $id_siswa ?>'">
                    <input type="text" name="alredy_month" id="alredy_month" value="<?= $month_2 ?>" hidden>
                    <!-- Month -->
                    <div class="row mb-3">
                        <label for="month" class="col-form-label col-sm-4 col-md-3 col-xl-2"><strong>Bulan</strong></label>
                        <div class="col-sm-8 col-md-9 col-xl-10">
                        <select class="form-control" type="text" name="month" id="month" required>
                            <option value="0" hidden>Pilih</option>
                            <option value="1"><input type="checkbox">Januari</option>
                            <option value="2">Februari</option>
                            <option value="3">Maret</option>
                            <option value="4">April</option>
                            <option value="5">Mei</option>
                            <option value="6">Juni</option>
                            <option value="7">Juli</option>
                            <option value="8">Agustus</option>
                            <option value="9">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>
                        </div>
                    </div>
                    <!-- Nominal -->
                    <div class="row mb-3">
                        <label for="nominal" class="col-form-label col-sm-4 col-md-3 col-xl-2"><strong>Nominal</strong></label>
                        <div class="col-sm-8 col-md-9 col-xl-10">
                            <input type="number" class="form-control" min="0" name="nominal" id="nominal" placeholder="Nominal" autocomplete="off" required oninvalid="this.setCustomValidity('Jumlah Nominal harus angka')" oninput="this.setCustomValidity('')"/>
                        </div>
                    </div>
                    <div class="row mb-3 justify-content-end mx-3 my-4">
                        <div class="col-sm-8 col-md-9 col-xl-10" style="text-align:end;">
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
        var expanded = false;
        function showCheckboxes() {
            var checkboxes = document.getElementById("checkboxes");
            if (!expanded) {
                checkboxes.style.display = "block";
                expanded = true;
            } else {
                checkboxes.style.display = "none";
                expanded = false;
            }
        }

        var alredy_month = document.getElementById("alredy_month");
        var list_month = alredy_month.value.split(",");

        $(document).ready(function(){
            var i;
            for (i = 0; i < list_month.length; i++) {
                $('select[name="month"]').on('change',function(){
                var $this = $(this);  
                $('select[name="month"]').find('option[value="'+ list_month[i] +'"]').prop('disabled', true);
                });
                $('select[name="month"]').trigger('change');
            }
        });
        // console.log(list_month[]);
        $('form #month').prop('readonly', true);
        kelas.addEventListener("input", function(){
            var strUser = this.value;
            var nextURL = 'http://localhost:8080/phphida/SMADA/SPP?kelas=' + strUser;
            window.location.replace(nextURL);
        });
    </script>
</body>
</html>