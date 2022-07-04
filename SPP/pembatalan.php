<?php 

require_once('db_config.php');

$date = date('Y-m-d');

session_start();
$nama_asli = $_SESSION['nama_asli'];

if(isset($_POST['submit'])) {
    $get_data_siswa = mysqli_query($conn, "SELECT * FROM keuangan WHERE nipd=$nipd_siswa GROUP BY namapd");
    while($row = mysqli_fetch_array($get_data_siswa))
    {
        $nama = $row['namapd'];
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

    require_once("db_config.php");
            
    $result = mysqli_query($conn, "INSERT INTO keuangan(tanggal,nipd,namapd,kelas,insidental,kesiswaan,pendidikan,penerima) VALUES('$tanggal','$nipd','$namapd','$kelas',$insidental,$kesiswaan,$pendidikan,'$penerima')");
    echo "
    <script>
        alert('Data Berhasil ditambahkan');
        document.location.href = 'bukti_pembayaran.php?nipd=". $nipd ."';
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
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Pembayaran SPP</title>
</head>
<body>
    <div class="container mt-3">
        <a href="main.php" class="btn btn-secondary mb-2">Kembali</a>
        <form action="pembatalan.php" method="GET">
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
                            <thead>
                                <tr>
                                <th scope="col">Tanggal</th>
                                <th scope="col">NIPD</th>
                                <th scope="col">Nama Siswa</th>
                                <th scope="col">Kelas</th>
                                <th scope="col">Insidental</th>
                                <th scope="col">Kesiswaan</th>
                                <th scope="col">Pendidikan</th>
                                <th scope="col">Batalkan</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                if(isset($_GET['cari'])){
                                    $cari = $_GET['cari'];
                                    $sql = "SELECT * FROM keuangan WHERE (penerima='$nama_asli' AND tanggal='$date') AND nipd=$cari ORDER BY id DESC";		
                                    $result = $conn->query($sql);		
                                }else{
                                    $sql = "SELECT * FROM keuangan WHERE penerima='$nama_asli' AND tanggal='$date' ORDER BY id DESC";	
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
                                    <td>
                                        <a href="delete.php?id=<?=$data['id']?>" class="btn btn-danger mx-3" onclick="return confirm('Yakin ingin menghapus data ini?')">Batalkan</a>
                                    </td>
                                    <?php $i++; ?>
                                </tr>
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
    <script 
        src="https://code.jquery.com/jquery-3.6.0.slim.js"  integrity="sha256-HwWONEZrpuoh951cQD1ov2HUK5zA5DwJ1DNUXaM6FsY="
        crossorigin="anonymous">
    </script>
</body>
</html>