<?php
include '../config/db.php';
$data = [];
$res = $conn->query("SELECT nik, nama FROM master_karyawan");
while ($row = $res->fetch_assoc()) {
    // Format: NIK (Nama)
    $data[] = $row['nik'] . ' (' . $row['nama'] . ')';
}
echo json_encode($data);
?>
