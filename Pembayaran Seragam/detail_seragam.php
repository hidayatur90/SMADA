<?php 

require_once('db_config.php');

session_start();
 
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
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
    <title>Cetak Seragam</title>
</head>
<body>
    <div class="container mt-3">
        <form action="" method="POST">
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </form>
        <form action="detail_seragam.php" method="GET">
            <div class="input-group my-3 col-12 col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-10">
                <input type="text" name="cari" class="form-control ms-3" placeholder="Cari NISN atau Nama">
                <input class="btn btn-primary" type="submit" value="Cari">
            </div>
        </form>
        <?php 
            if(isset($_GET['cari'])){
                $cari = $_GET['cari'];
            }
        ?>
        <table class="table table-light table-bordered text-center">
            <thead>
                <tr>
                <th scope="col">No.</th>
                <th scope="col">NISN</th>
                <th scope="col">Nama Siswa</th>
                <th scope="col">Jenis Kelamin</th>
                <th scope="col">Berjilbab</th>
                <th scope="col">Total Bayar</th>
                <th scope="col">Status</th>
                <th scope="col">Cetak</th>
                </tr>
            </thead>
            <tbody>
            <?php 
                if(isset($_GET['cari'])){
                    $cari = $_GET['cari'];
                    $sql = "SELECT * FROM detail_seragam WHERE nama_siswa LIKE '%".$cari."%' OR nis LIKE '%".$cari."%'";		
                    $result = $conn->query($sql);		
                }else{
                    $sql = "SELECT * FROM detail_seragam";	
                    $result = $conn->query($sql); 	
                }
                $i = 1;
                while($data = $result->fetch_assoc()){ ?>
                <tr>
                <form action="print.php" method="POST" id="form-catch">
                    <th><?= $i; ?></th>
                    <td><?= $data['nis']; ?></td>
                    <td><?= $data['nama_siswa']; ?></td>
                    <td><?= $data['jenis_kelamin']; ?></td>
                    <?php if($data['jenis_kelamin'] == 'Pria') : ?>
                        <td>
                        <div class="mb-3 form-check" style="  display: flex; justify-content: center;">
                            <input type="checkbox" disabled="disabled" class="form-check-input" id="jilbab" style="width: 20px; height: 20px;">
                        </div>
                        </td>
                        <td><?= $data['uang_kesiswaan']; ?></td>
                    <?php else : ?>
                        <td>
                            <div class="mb-3 form-check" style="  display: flex; justify-content: center;">
                                <input type="checkbox" class="form-check-input" name='jilbab[]' value="Ya" style="width: 20px; height: 20px;">
                            </div>
                        </td>
                        <td><?= $data['uang_kesiswaan']; ?></td>
                    <?php endif; ?>
                    <?php if($data['status'] == 'Lunas') : ?>
                        <td><?= $data['status']; ?></td>
                        <td>
                            <button href="print.php?id=<?=$data['id_siswa']?>" class="btn btn-success mx-2" disabled>Cetak</button>
                        </td>
                    <?php else : ?>
                        <td><?= $data['status']; ?></td>
                        <td>
                            <!-- <input class="btn btn-success mx-2" type="submit" onclick="location.href='print.php?id=<?=$data['id_siswa']?>';"> -->
                            <a href="print.php?id=<?=$data['id_siswa']?>" class="btn btn-success mx-2" onclick="document.getElementById('form-catch').submit()">Cetak</a>
                        </td>
                    <?php endif; ?>
                    <?php $i++; ?>
                </tr>
                </form>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>