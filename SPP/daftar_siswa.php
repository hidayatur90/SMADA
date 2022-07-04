<?php 

require_once('db_config.php');
$this_kelas = $_GET['kelas'];
// $cari = $_GET['cari'];

session_start();
$role = $_SESSION['role'];

$all_kelas = [];
$get_date = mysqli_query($conn, "SELECT DISTINCT(kelas) as kelas FROM datapd");
while($row = mysqli_fetch_array($get_date))
{
    $all_kelas[] = $row['kelas'];
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
        <?php if($role == "petugas") {?>
            <a href="main.php" class="btn btn-secondary mb-2">Kembali</a>
        <?php } else if ($role == "kepsek") {?>
            <a href="tinjau.php" class="btn btn-secondary mb-2">Kembali</a>
        <?php } ?>
        <div class="row">
            <div class="col-6 mb-2">
                <label for="kelas"><strong>Kelas : </strong></label>
                <select class="form-select w-25" id="kelas" name="kelas">
                    <option selected hidden><?= $this_kelas; ?></option>
                    <option value="Semua">Semua</option>
                    <?php foreach($all_kelas as $kelas) { ?>
                        <option value="<?= $kelas; ?>"><?= $kelas; ?></option>
                    <?php }; ?>
                </select>
            </div>
            <!-- <div class="col-6 mt-2">
                <form method="GET">
                    <div class="input-group my-3 col-12 col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-10">
                        <input type="text" name="cari" id="cari" class="form-control ms-3" placeholder="Cari NISN atau Nama">
                        <input class="btn btn-primary" id="btn_cari" type="submit" value="Cari">
                    </div>
                </form>
            </div> -->
        </div>
        <?php 
            if(isset($_GET['cari'])){
                $cari = $_GET['cari'];
            }
        ?>
        <div class="row">
            <div class="col-xl-12">
                <div class="card mb-4">
                    <div class="card-header">
                        Data Siswa
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                <th scope="col">No.</th>
                                <th scope="col">NIS</th>
                                <th scope="col">Nama Siswa</th>
                                <th scope="col">Kelas</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                if(isset($_GET['cari'])){
                                    $cari = $_GET['cari'];
                                    $sql = "SELECT * FROM datapd WHERE nama_pd LIKE '%".$cari."%' OR nis LIKE '%".$cari."%' AND kelas='$this_kelas'";		
                                    $result = $conn->query($sql);		
                                }else{
                                    $sql = "SELECT * FROM datapd WHERE kelas='$this_kelas'";	
                                    $result = $conn->query($sql); 	
                                }
                                $i = 1;
                                while($data = $result->fetch_assoc()){ ?>
                                <tr>
                                    <th><?= $i; ?></th>
                                    <td><?= $data['nis']; ?></td>
                                    <td><?= $data['nama_pd']; ?></td>
                                    <td><?= $data['kelas']; ?></td>
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
    <script>
        var kelas = document.getElementById('kelas');
        var cari = document.getElementById('cari');

        kelas.addEventListener("input", function(){
            var strUser = this.value;
            var nextURL = 'http://localhost:8080/phphida/SMADA/SPP/daftar_siswa.php?kelas=' + strUser;
            window.location.replace(nextURL);
        });
        
        // cari.addEventListener("input", function(){
        //     var strUser = this.value;
        //     document.getElementById('btn_cari').onclick = function() {
        //         var nextURL = 'http://localhost:8080/phphida/SMADA/SPP/daftar_siswa.php?kelas=' + kelas.value + '&cari=' + strUser;
        //         window.location.replace(nextURL);
        //     };
        // });
    </script>
</body>
</html>