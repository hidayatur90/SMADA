<?php 

require_once('db_config.php');

session_start();
$nama = $_SESSION['username'];
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
}
$date = date('Y-m-d');

$this_class = $_GET['kelas'];
$all_class = [];
$get_date = mysqli_query($conn, "SELECT DISTINCT(kelas) as kelas FROM detail_pembayaran");
while($row = mysqli_fetch_array($get_date))
{
    $all_class[] = $row['kelas'];
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
        <!-- <form action="detail_seragam.php" method="GET">
            <div class="input-group my-3 col-12 col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-10">
                <input type="text" name="cari" class="form-control ms-3" placeholder="Cari NISN atau Nama">
                <input class="btn btn-primary" type="submit" value="Cari">
            </div>
        </form> -->
        <?php 
            // if(isset($_GET['cari'])){
            //     $cari = $_GET['cari'];
            // }
        ?>
        <div class="row">
            <div class="col-xl-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <strong>Data Pembayaran SPP</strong>
                    </div>
                    <div class="card-body">
                        <label for="kelas">Kelas : </label>
                        <select class="form-select w-25" id="kelas" name="kelas">
                            <option selected hidden><?= $this_class; ?></option>
                            <option value="Semua">Semua</option>
                            <?php foreach($all_class as $class) { ?>
                                <option value="<?= $class; ?>"><?= $class; ?></option>
                            <?php }; ?>
                        </select>
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                <th scope="col">No.</th>
                                <th scope="col">NIPD</th>
                                <th scope="col">Nama Siswa</th>
                                <th scope="col">Kelas</th>
                                <th scope="col">Pendidikan</th>
                                <th scope="col">Isidental</th>
                                <th scope="col">Kesiswaan</th>
                                <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                if ($this_class == 'Semua'){
                                    $sql = "SELECT * FROM detail_pembayaran";		
                                    $result = $conn->query($sql);		
                                } else {
                                    $sql = "SELECT * FROM detail_pembayaran WHERE kelas = '$this_class'";		
                                    $result = $conn->query($sql);		
                                }
                                $i = 1;
                                while($data = $result->fetch_assoc()){ ?>
                                <tr>
                                <form action="print.php" method="POST" id="form-catch">
                                    <th><?= $i; ?></th>
                                    <td><?= $data['NIPD']; ?></td>
                                    <td><?= $data['nama']; ?></td>
                                    <td><?= $data['kelas']; ?></td>
                                    <td><?= "Rp. " . number_format($data['spp'],2,',','.'); ?></td>
                                    <td><?= "Rp. " . number_format($data['isidental'],2,',','.'); ?></td>
                                    <td><?= "Rp. " . number_format($data['kesiswaan'],2,',','.'); ?></td>
                                    <!-- Cetak -->
                                    <td>
                                        <a href="detail_siswa.php?id=<?=$data['id']?>" class="btn btn-warning mx-2">Detail</a>
                                        <a href="print.php?" class="btn btn-success mx-2">Cetak</a>
                                    </td>
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
        kelas.addEventListener("input", function(){
            var strUser = this.value;
            var nextURL = 'http://localhost:8080/phphida/SMADA/SPP?kelas=' + strUser;
            window.location.replace(nextURL);
        });
    </script>
</body>
</html>