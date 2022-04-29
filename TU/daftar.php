<?php
require 'function.php';

$tamu = query("SELECT * FROM rekap");
?>

<!DOCTYPE html>
<html>
<head>
	<title>Rekap Tamu</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="header"> 
	    <h1>Selamat Datang</h1> 
	    <p>Di <span>SMAN 2 BONDOWOSO</span>, berikut daftar tamu SMADA.</p> 
	    <img src="img/Logo-smada.png">
	</div> 

	<div class="topnav"> 
	    <a href="index.php">Home</a> 
	</div>
	
	<div class="row">
		<div class="column">
			<h1>Daftar Tamu SMADA</h1>
		    <table id="tamu">
		        <tr>
		            <th>No.</th>
		            <th>Waktu Kunjungan</th>
		            <th>Nama</th>
		            <th>Asal</th>
		            <th>Keperluan</th>
		        </tr>
		        <?php $i = 1; ?>
		        <?php foreach($tamu as $tm) : ?>
		        <tr>
		            <td><?php echo $i; ?></td>
		            <td><?php echo $tm["waktu"];?></td>
		            <td><?php echo $tm["nama"];?></td>
		            <td><?php echo $tm["asal"]; ?></td>
		            <td><?php echo $tm["keperluan"]; ?></td>
		        </tr>
		        <?php $i++ ;?> 
		        <?php endforeach; ?>
		    </table>
		</div>
		
	</div>
	
</body>
</html>