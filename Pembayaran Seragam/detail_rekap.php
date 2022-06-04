<?php

require_once('db_config.php');

session_start();
$username = $_SESSION['username'];

$select_nama_penerima = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
while($row = mysqli_fetch_array($select_nama_penerima))
{
	$id_user = $row['id_user'];
	$nama_user = $row['nama'];
}

$total_jilbab = 0;
$total_no_jilbab = 0;

$get_sum_jilbab = mysqli_query($conn, "SELECT jilbab FROM detail_seragam WHERE penerima='$nama_user'");
while($row = mysqli_fetch_array($get_sum_jilbab))
{
    if($row['jilbab'] == 'Ya'){
        $total_jilbab += 1;
    } else {
        $total_no_jilbab += 1;
    }
}

$get_total_terima = mysqli_query($conn, "SELECT SUM(total_bayar) as total_terima FROM detail_seragam WHERE penerima='$nama_user'");
while($row = mysqli_fetch_array($get_total_terima))
{
    $total_terima = $row['total_terima'];
}

$all_date = [];
$get_date = mysqli_query($conn, "SELECT DISTINCT(tanggal) as tanggal FROM detail_seragam WHERE penerima='$nama_user'");
while($row = mysqli_fetch_array($get_date))
{
    $all_date[] = $row['tanggal'];
}

$this_date = $_GET['date'];

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Rekap <?= $username; ?></title>
</head>
<body>
    <div class="container mt-3">
        <div class="row">
            <div class="col-xl-12">
                <a href="detail_seragam.php" class="btn btn-warning mx-2 w-10 my-2">Kembali</a>
                <div class="card mb-4">
                    <div class="card-header">
                        <strong> Data Rekap <?= $nama_user; ?> </strong>
                    </div>
                    <div class="card-body">
                        <label for="tanggal">Tanggal : </label>
                        <select class="form-select w-25" id="tanggal" name="tanggal">
                            <option selected hidden><?= $this_date; ?></option>
                            <option value="Semua">Semua</option>
                            <?php foreach($all_date as $date) { ?>
                                <option value="<?= $date; ?>"><?= $date; ?></option>
                            <?php }; ?>
                        </select>
                        <table class="table table-bordered text-center mt-2">
                            <thead>
                                <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">No. Pendaftaran</th>
                                <th scope="col">Nama Siswa</th>
                                <th scope="col">Asal Sekolah</th>
                                <th scope="col">Jenis Kelamin</th>
                                <th scope="col">Berjilbab</th>
                                <th scope="col">Total Bayar</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                if ($this_date == 'Semua') {
                                    $sql = "SELECT * FROM detail_seragam WHERE penerima='$nama_user'";		
                                    $result = $conn->query($sql);		
                                } else {
                                    $sql = "SELECT * FROM detail_seragam WHERE penerima='$nama_user' AND tanggal='$this_date'";		
                                    $result = $conn->query($sql);		
                                }
                                $i = 1;
                                while($data = $result->fetch_assoc()){ ?>
                                <tr>
                                <form action="print.php" method="POST" id="form-catch">
                                    <th><?= $i; ?></th>
                                    <td><?= $data['tanggal']; ?></td>
                                    <td><?= $data['no_pendaftaran']; ?></td>
                                    <td><?= $data['nama_siswa']; ?></td>
                                    <td><?= $data['asal_sekolah']; ?></td>
                                    <td><?= $data['jenis_kelamin']; ?></td>
                                    <td><?= $data['jilbab']; ?></td>
                                    <td><?= "Rp " . number_format($data['total_bayar'],2,',','.'); ?></td>
                                    <?php $i++; ?>
                                </tr>
                                </form>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script>
        tanggal.addEventListener("input", function(){
            var strUser = this.value;
            var nextURL = 'http://localhost:8080/phphida/SMADA/Pembayaran%20Seragam/detail_rekap.php?date=' + strUser;
            window.location.replace(nextURL);
        });
    </script>
</body>
</html>

