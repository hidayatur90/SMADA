<?php
require_once("db_config.php");

$search = $_GET["search"];

$sql = "SELECT * FROM detail_seragam
            WHERE 
        nis LIKE '%{$search}%' OR nama_siswa LIKE '%{$search}%'";

$result = $conn->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
    array_push($data, $row);
}
header("Content-Type: aplication/json");
echo json_encode($data);

