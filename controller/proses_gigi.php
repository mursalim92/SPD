<?php
session_start();
include '../config/db.php';

if (isset($_POST['nik'])) {
    $nik = $_POST['nik'];
    $no_spd = $_POST['no_spd'];
    $no_kwitansi = $_POST['no_kwitansi'];
    $tgl_kwitansi = $_POST['tgl_kwitansi'];
    $tgl_pengajuan = $_POST['tgl_pengajuan'];
    $jenis_perawatan_gigi = $_POST['jenis_perawatan_gigi'];
    $nominal_pengajuan = $_POST['nominal_pengajuan'];
    $persen = $_POST['persentase_tanggung'];
    $jumlah_diganti = $nominal_pengajuan * ($persen / 100);
    $nama_rumah_sakit = $_POST['nama_rumah_sakit'];
    $dibuat_oleh = $_SESSION['user_id'];
    $created_at = date('Y-m-d H:i:s');

    // (Validasi plafon per level bisa diterapkan di sini, lihat penjelasan bawah!)
    $sql = "INSERT INTO reimburse_gigi
        (nik, no_spd, no_kwitansi, tgl_kwitansi, tgl_pengajuan, jenis_perawatan_gigi, nominal_pengajuan, persentase_tanggung, jumlah_diganti, nama_rumah_sakit, dibuat_oleh, created_at)
        VALUES
        ('$nik','$no_spd','$no_kwitansi','$tgl_kwitansi','$tgl_pengajuan','$jenis_perawatan_gigi','$nominal_pengajuan','$persen','$jumlah_diganti','$nama_rumah_sakit','$dibuat_oleh','$created_at')";
    $conn->query($sql);

    header('Location: ../view/list_gigi.php');
    exit;
}

// Soft delete
if (isset($_GET['hapus_id'])) {
    $id = $_GET['hapus_id'];
    $deleted_at = date('Y-m-d H:i:s');
    $deleted_by = $_SESSION['user_id'];
    $sql = "UPDATE reimburse_gigi SET deleted_at='$deleted_at', deleted_by='$deleted_by' WHERE id='$id'";
    $conn->query($sql);
    header('Location: ../view/list_gigi.php');
    exit;
}
?>
