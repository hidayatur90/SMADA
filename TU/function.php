<?php
$conn = mysqli_connect("localhost", "root", "", "db_bukutamu");
$result = mysqli_query($conn, "SELECT * FROM rekap");

function query($query) {
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ( $row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}   

function tambah($data) {
	global $conn;
	$jam = date("H");
	$jam = $jam + 6;
	$waktu = date("Y/m/d $jam:i:s");
	$nama = htmlspecialchars($_POST["nama"]);
	$asal = htmlspecialchars($_POST["asal"]);
	$keperluan = htmlspecialchars($_POST["keperluan"]);
	
	$query = "INSERT INTO rekap
			VALUES ('','$waktu','$nama', '$asal', '$keperluan')";

	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);
} ?>