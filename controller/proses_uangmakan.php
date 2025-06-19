<?php
session_start();
include '../config/db.php';

if (isset($_POST['nik'])) {
    $nik = $_POST['nik'];
    $no_spd = $_POST['no_spd'];
    $tgl_kwitansi = $_POST['tgl_kwitansi'];
    $tgl_pengajuan = $_POST['tgl_pengajuan'];
    $nominal_pengajuan = $_POST['nominal_pengajuan'];
    $persen = $_POST['persentase_tanggung'];
    $jumlah_diganti = $nominal_pengajuan * ($persen / 100);
    $dibuat_oleh = $_SESSION['user_id'];
    $created_at = date('Y-m-d H:i:s');

    $sql = "INSERT INTO uang_makan_direksi
        (nik, no_spd, tgl_kwitansi, tgl_pengajuan, nominal_pengajuan, persentase_tanggung, jumlah_diganti, dibuat_oleh, created_at)
        VALUES
        ('$nik','$no_spd','$tgl_kwitansi','$tgl_pengajuan','$nominal_pengajuan','$persen','$jumlah_diganti','$dibuat_oleh','$created_at')";
    $conn->query($sql);

    header('Location: ../view/list_uangmakan.php');
    exit;
}

// Proses soft delete
if (isset($_GET['hapus_id'])) {
    $id = $_GET['hapus_id'];
    $deleted_at = date('Y-m-d H:i:s');
    $deleted_by = $_SESSION['user_id'];
    $sql = "UPDATE uang_makan_direksi SET deleted_at='$deleted_at', deleted_by='$deleted_by' WHERE id='$id'";
    $conn->query($sql);
    header('Location: ../view/list_uangmakan.php');
    exit;
}
?>
