<?php
include '../config/db.php';

if (isset($_GET['nik'])) {
    $nik = $_GET['nik'];
    $result = $conn->query("SELECT nama, jabatan FROM master_karyawan WHERE nik='$nik'");
    if ($row = $result->fetch_assoc()) {
        echo json_encode(['nama' => $row['nama'], 'jabatan' => $row['jabatan']]);
    } else {
        echo json_encode(['nama' => '', 'jabatan' => '']);
    }
}
?>
