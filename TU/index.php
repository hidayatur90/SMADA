<?php 
require 'function.php';

if (isset($_POST["submit"])) {
    if (tambah($_POST) > 0) {
        echo "
        <script>
            alert('Data berhasil ditambahkan, Terima Kasih telah berkunjung di SMADA');
            document.location.href = 'index.php';
        </script>";
    } else {
        echo "
        <script>
            alert('Data gagal ditambahkan');
            document.location.href = 'index.php';
        </script>";
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Buku Tamu SMAN 2 BONDOWOSO</title>
    <link rel="stylesheet" href="style.css">
<head>
<body>
    <div class="header"> 
        <h1>Selamat Datang</h1> 
        <p>Di <span>SMAN 2 BONDOWOSO</span>, Silahkan tulis keperluan Anda!</p> 
        <img src="img/Logo-smada.png">
    </div> 

    <div class="topnav"> 
        <a href="index.php">Home</a> 
        <a href="daftar.php">Daftar Tamu</a>
    </div>

    <div class="row"> 
        <div class="column"> 
        <h2>Buku Tamu</h2> 
            <div> 
                <form action="index.php" method="post">
                    <label for="nama">Nama</label> 
                        <input type="text" name="nama" id="nama" placeholder="Nama Anda.." required="" oninvalid="this.setCustomValidity('Wajib mengisikan Nama Anda')" oninput="setCustomValidity('')"> 
                    <label for="asal">Asal</label> 
                        <input type="text" name="asal" id="asal" placeholder="Asal Anda.." required="" oninvalid="this.setCustomValidity('Wajib mengisikan Asal Anda')" oninput="setCustomValidity('')">
                    <label for="keperluan">Keperluan</label> 
                        <textarea name="keperluan" id="keperluan" placeholder="Tuliskan keperluan Anda.." required="" oninvalid="this.setCustomValidity('Wajib mengisikan Keperluan Anda')" oninput="setCustomValidity('')"></textarea> 
            
                    <input type="submit" name="submit" value="Submit">
                </form> 
            </div> 
    </div> 
</body> 
</html>