<?php 

require_once('db_config.php');

session_start();
 
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
}

$sql = "SELECT * FROM detail_seragam";
$result = $conn->query($sql); 

$datas = array();
while ($row = $result->fetch_assoc()){
    $datas[] = $row;
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
        <div class="input-group my-3 col-12 col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-10">
            <input type="text" class="form-control ms-3" placeholder="Cari NISN atau Nama" id="search">
        </div>

        <table class="table table-light table-bordered text-center">
            <thead>
                <tr>
                <th scope="col">No.</th>
                <th scope="col">NISN</th>
                <th scope="col">Nama Siswa</th>
                <th scope="col">Detail</th>
                </tr>
            </thead>
            <tbody id="data">
                <?php 
                $i = 1;
                if (count($datas) > 0) :
                    foreach ($datas as $data) : ?>
                <tr>
                    <th><?= $i; ?></th>
                    <td><?= $data['nis']; ?></td>
                    <td><?= $data['nama_siswa']; ?></td>
                    <td>
                        <a href="detail_siswa.php?id=<?=$data['id_siswa']?>" class="btn btn-primary mx-2">Detail</a>
                    </td>
                    <?php $i++; ?>
                </tr>
                <?php endforeach; ?>
                <?php else : ?>
                    <td>Tidak ada data</td> 
                    <td>Tidak ada data</td> 
                    <td>Tidak ada data</td> 
                    <td>Tidak ada data</td> 
                <?php endif; ?> 
            </tbody>
        </table>
    </div>
    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!-- pooper js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <!-- <script src="searchName.js"></script> -->
</body>
</html>

<script>
    var search = document.getElementById("search");

    search.addEventListener("keyup", function () {
    $("#data").html("");
    $.get("./dataSearch.php?search=" + search.value,  function (response) {
        if (response.length == 0) {
            $("#data").html("<tr><td>" + "-" + "</td>" + "<td>" + "NISN tidak ditemukan" + "</td>" + "<td>" + "Nama tidak ditemukan" + "</td>" + "<td>" + "-" + "</td></tr>");
        } else {
            for (var i = 0; i < response.length; i++) {
            $("#data").append("<tr><td>" + (i+1) + "</td>" + "<td>" + response[i]["nis"] + "</td>" + "<td>" + response[i]["nama_siswa"] + "</td>" + "<td><a href='detail_siswa.php?id="+ response[i]["id_siswa"] + "' class='btn btn-primary mx-2'>Detail</a>" + "</td></tr>");
        }
        }});
    }); 
</script>