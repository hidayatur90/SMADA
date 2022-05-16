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
                        <strong>
                            Rekap Pembayaran Seragam
                        </strong>    
                    </div>
                    <div class="card-body">
                        <?php 
                            $sql = "SELECT * FROM users WHERE id_user=$id_user";
                            $result = $conn->query($sql); 	
                            $i = 1;
                            while($data = $result->fetch_assoc()){ ?>
                            <tr>
                            <form action="print_rekap.php" method="POST" id="form-catch">
                                <table class="table table-borderless">
                                    <tr>
                                        <th>Nama Penerima</th>
                                        <td>: <?= $data['nama']; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal </th>
                                        <td>: <?= date('d - m - Y');?></td>
                                    </tr>
                                    <tr style="padding: 5px;">
                                        <th>Jenis Seragam :</th>
                                    </tr>
                                    <tr>
                                        <td>1. Berjilbab</td>
                                        <td>: <?= $total_jilbab; ?></td>
                                    </tr>
                                    <tr>
                                        <td>2. Tidak Berjilbab</td>
                                        <td>: <?= $total_no_jilbab; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Total Terima : </th>
                                        <td>: Rp. <?= $total_terima; ?></td>
                                    </tr>
                                </table>
                                <?php $i++; ?>
                            </tr>
                            </form>
                        </tbody>
                        
                        <a href="print_rekap.php?id=<?=$data['id_user']?>" class="btn btn-success mx-2 w-100" onclick="document.getElementById('form-catch').submit()">Cetak Rekap</a>
                        <?php } ?>
                    </div>
                </div>    
            </div>
        </div>
    </div>
    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>