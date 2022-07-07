<?php 
require_once('../db/db_config.php');

if(isset($_POST['disetujui']))
{	
	$id = $_POST['id'];
	$status = "Disetujui";
    $result = mysqli_query($conn, "UPDATE pengajuan SET status=$status WHERE id=$id");
    header("Location: tindak_pengajuan.php");
} else if (isset($_POST['ditolak'])) {
	$id = $_POST['id'];
	$status = "Ditolak";
    $result = mysqli_query($conn, "UPDATE pengajuan SET status=$status WHERE id=$id");
    header("Location: tindak_pengajuan.php");
}
?>