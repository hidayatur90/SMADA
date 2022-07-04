<?php
require_once("db_config.php");
 
$id = $_GET['id'];
session_start();
$nama_asli = $_SESSION['nama_asli'];

$get_data_siswa = mysqli_query($conn, "SELECT * FROM keuangan WHERE id=$id");
while($row = mysqli_fetch_array($get_data_siswa))
{
    $nis = $row['nipd'];
    $nama = $row['namapd'];
    $kelas = $row['kelas'];
    $insidental = $row['insidental'];
    $kesiswaan = $row['kesiswaan'];
    $pendidikan = $row['pendidikan'];
}
$tanggal = date('Y-m-d');
$namapd = $nama.' / '.$kelas;
$penerima = $nama_asli;
$sum_total = $insidental + $kesiswaan + $pendidikan;
$alasan = "Kesalahan input";
$result = mysqli_query($conn, "INSERT INTO pembatalan(tanggal,nis,namapd,nominal,alasan,petugas) VALUES('$tanggal','$nis','$namapd',$sum_total,'$alasan','$penerima')");

$get_data_rekap = mysqli_query($conn, "SELECT * FROM rekap WHERE nis=$nis");
while($row = mysqli_fetch_array($get_data_rekap))
{
    $insidental_2 = $row['insidental'];
    $kesiswaan_2 = $row['kesiswaan'];
    $pendidikan_2 = $row['pendidikan'];
}
$insidental_rekap = $insidental_2 - $insidental;
$kesiswaan_rekap = $kesiswaan_2 - $kesiswaan;
$pendidikan_rekap = $pendidikan_2 - $pendidikan;
$result = mysqli_query($conn, "UPDATE rekap SET insidental=$insidental_rekap,kesiswaan=$kesiswaan_rekap,pendidikan=$pendidikan_rekap WHERE nis=$nis");

$result = mysqli_query($conn, "DELETE FROM keuangan WHERE id=$id");
?>
<script>
    alert('Berhasil');
    location.href = "pembatalan.php";
</script>