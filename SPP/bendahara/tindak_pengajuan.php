<?php 
require_once('../db/db_config.php');
session_start();
$role = $_SESSION['role'];

if(isset($_POST['disetujui']))
{	
	$id = $_POST['idPengajuan'];
	$status = "Disetujui";
    $result = mysqli_query($conn, "UPDATE pengajuan SET status='$status' WHERE id=$id");
    header("Location: tindak_pengajuan.php");
} else if (isset($_POST['ditolak'])) {
	$id = $_POST['idPengajuan'];
	$status = "Ditolak";
    $result = mysqli_query($conn, "UPDATE pengajuan SET status='$status' WHERE id=$id");
    header("Location: tindak_pengajuan.php");
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
    <title>Status Pengajuan</title>
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
        <?php if($role == "waka") {?>
            <a href="dash_waka.php" class="btn btn-secondary mb-2"><i class="bi bi-arrow-left me-2"></i>Kembali</a>
        <?php } else if ($role == "bendahara") {?>
            <a href="../bendahara/dash_bendahara.php" class="btn btn-secondary mb-2"><i class="bi bi-arrow-left me-2"></i>Kembali</a>
        <?php } ?>
        <div class="row">
            <div class="col-xl-12">
                <div class="card mb-4">
                    <div class="card-header">
                       <strong>Data Pengajuan Peminjaman</strong>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                <th scope="col">No.</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Oleh</th>
                                <th scope="col">Nominal</th>
                                <th scope="col">Keterangan</th>
                                <th scope="col">Status</th>
                                <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $sql = "SELECT * FROM pengajuan ORDER BY id DESC";	
                                $result = $conn->query($sql); 	
                                $i = 1;
                                while($data = $result->fetch_assoc()){ ?>
                                <form method="post" action="tindak_pengajuan.php">
                                    <tr>
                                        <th><?= $i; ?></th>
                                        <input type="number" name="idPengajuan" id="idPengajuan" value="<?=$data['id']?>" hidden>
                                        <td><?= $data['tanggal']; ?></td>
                                        <td><?= $data['nama']; ?></td>
                                        <td><?= $data['nominal']; ?></td>
                                        <td><?= $data['keterangan']; ?></td>
                                        <td><?= $data['status']; ?></td>
                                        <?php if(($data['status']=="Ditolak") || ($data['status']=="Disetujui")) { ?>
                                            <td>
                                                <input type="submit" name="disetujui" class="btn btn-success" value="Disetujui" onclick="return  confirm('Yakin ingin menyetujui pengajuan ini?')"disabled>
                                                <input type="submit" name="ditolak" class="btn btn-danger" value="Ditolak" onclick="return  confirm('Yakin ingin menolak pengajuan ini?')" disabled>
                                            </td>
                                        <?php } else { ?>
                                            <td>
                                                <input type="submit" name="disetujui" class="btn btn-success" value="Disetujui" onclick="return  confirm('Yakin ingin menyetujui pengajuan ini?')">
                                                <input type="submit" name="ditolak" class="btn btn-danger" value="Ditolak" onclick="return  confirm('Yakin ingin menolak pengajuan ini?')">
                                            </td>
                                        <?php } ?>
                                        <!-- <td>
                                            <button class="idPengajuan btn btn-primary mx-3" data-bs-toggle="modal" data-bs-target="#modalPersetujuan" data-id="<?= $data['id']; ?>" data-nama="<?= $data['nama']; ?>">Aksi</button>
                                        </td> -->
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
    <!-- Modal -->
    <!-- <div class="modal fade" id="modalPersetujuan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Pilih Tindakan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="card-body">
                <form method="post" action="tindak_pengajuan.php">
                    <input type="text" name="idPeminjaman" id="idPeminjaman" value="" hidden/>
                    <input type="text" name="nama" id="nama" value=""/>
                    <div class="row">
                        <div class="col-6">
                            <input type="submit" name="submit" id="submit" class="create btn btn-danger w-100" value="Ditolak">
                        </div>
                        <div class="col-6">
                            <input type="submit" name="submit" id="submit" class="create btn btn-success w-100" value="Disetujui">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div> -->

    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script 
        src="https://code.jquery.com/jquery-3.6.0.slim.js"  integrity="sha256-HwWONEZrpuoh951cQD1ov2HUK5zA5DwJ1DNUXaM6FsY="
        crossorigin="anonymous">
    </script>
    <!-- <script>
        $(document).on("click", ".idPengajuan", function () {
        var idPeminjaman = $(this).data('id');
        var nama = $(this).data('nama');
        $(".modal-body #idPeminjaman").val( idPeminjaman );
        $(".modal-body #nama").val( nama );
    });
    </script> -->
</body>
</html>