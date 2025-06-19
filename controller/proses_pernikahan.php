<?php
session_start();
include '../config/db.php';

if (isset($_POST['nik'])) {
    $nik = $_POST['nik'];
    $nama_tanggungan = $_POST['nama_tanggungan'];
    $tgl_pernikahan = $_POST['tgl_pernikahan'];
    $no_spd = $_POST['no_spd'];
    $tgl_pengajuan = $_POST['tgl_pengajuan'];
    $nominal_pengajuan = $_POST['nominal_pengajuan'];
    $dibuat_oleh = $_SESSION['user_id'];
    $created_at = date('Y-m-d H:i:s');

    // Validasi: claim hanya boleh 1x pernikahan selama jadi karyawan
    $sql_check = "SELECT COUNT(*) as cnt FROM sumbangan_pernikahan WHERE nik='$nik' AND deleted_at IS NULL";
    $result_check = $conn->query($sql_check);
    $row_check = $result_check->fetch_assoc();
    if ($row_check['cnt'] >= 1) {
        echo "<script>alert('Claim pernikahan hanya boleh 1x selama jadi karyawan!');window.location='../view/form_pernikahan.php';</script>";
        exit;
    }

    // Validasi: masa aktif 90 hari dari tanggal pernikahan
    $diff = (strtotime($tgl_pengajuan) - strtotime($tgl_pernikahan)) / (60 * 60 * 24);
    if ($diff > 90) {
        echo "<script>alert('Pengajuan lebih dari 90 hari dari tanggal pernikahan!');window.location='../view/form_pernikahan.php';</script>";
        exit;
    }

    // Validasi: minimal usia kerja 1 tahun dari TMK ke tanggal pernikahan
    $q_tmk = "SELECT tgl_masuk_kerja FROM master_karyawan WHERE nik='$nik'";
    $r_tmk = $conn->query($q_tmk);
    $tmk = $r_tmk->fetch_assoc()['tgl_masuk_kerja'];
    $selisih_tahun = (strtotime($tgl_pernikahan) - strtotime($tmk)) / (365*24*60*60);
    if ($selisih_tahun < 1) {
        echo "<script>alert('Minimal usia kerja karyawan 1 tahun dari TMK ke tanggal pernikahan!');window.location='../view/form_pernikahan.php';</script>";
        exit;
    }

    if ($nominal_pengajuan > 15000000) $nominal_pengajuan = 15000000;

    $sql = "INSERT INTO sumbangan_pernikahan
        (nik, nama_tanggungan, tgl_pernikahan, no_spd, tgl_pengajuan, nominal_pengajuan, dibuat_oleh, created_at)
        VALUES
        ('$nik','$nama_tanggungan','$tgl_pernikahan','$no_spd','$tgl_pengajuan','$nominal_pengajuan','$dibuat_oleh','$created_at')";
    $conn->query($sql);

    header('Location: ../view/list_pernikahan.php');
    exit;
}

// Soft delete
if (isset($_GET['hapus_id'])) {
    $id = $_GET['hapus_id'];
    $deleted_at = date('Y-m-d H:i:s');
    $deleted_by = $_SESSION['user_id'];
    $sql = "UPDATE sumbangan_pernikahan SET deleted_at='$deleted_at', deleted_by='$deleted_by' WHERE id='$id'";
    $conn->query($sql);
    header('Location: ../view/list_pernikahan.php');
    exit;
}
?>
