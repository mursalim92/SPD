<?php
session_start();
include '../config/db.php';

if (isset($_POST['nik'])) {
    $nik = $_POST['nik'];
    $status_meninggal = $_POST['status_meninggal'];
    $nama_meninggal = $_POST['nama_meninggal'];
    $tgl_meninggal = $_POST['tgl_meninggal'];
    $no_spd = $_POST['no_spd'];
    $tgl_pengajuan = $_POST['tgl_pengajuan'];
    $nominal_pengajuan = $_POST['nominal_pengajuan'];
    $dibuat_oleh = $_SESSION['user_id'];
    $created_at = date('Y-m-d H:i:s');

    // Validasi: masa aktif 90 hari dari tanggal kematian
    $diff = (strtotime($tgl_pengajuan) - strtotime($tgl_meninggal)) / (60 * 60 * 24);
    if ($diff > 90) {
        echo "<script>alert('Pengajuan lebih dari 90 hari dari tanggal kematian!');window.location='../view/form_pemakaman.php';</script>";
        exit;
    }

    // Validasi: minimal usia kerja 1 hari dari TMK ke tanggal kematian
    $q_tmk = "SELECT tgl_masuk_kerja FROM master_karyawan WHERE nik='$nik'";
    $r_tmk = $conn->query($q_tmk);
    $tmk = $r_tmk->fetch_assoc()['tgl_masuk_kerja'];
    $selisih_hari = (strtotime($tgl_meninggal) - strtotime($tmk)) / (60*60*24);
    if ($selisih_hari < 1) {
        echo "<script>alert('Minimal usia kerja karyawan 1 hari dari TMK ke tanggal kematian!');window.location='../view/form_pemakaman.php';</script>";
        exit;
    }

    // Validasi: claim untuk Ayah/Ibu hanya boleh 1x masing-masing
    if ($status_meninggal == 'Ayah' || $status_meninggal == 'Ibu') {
        $sql_check = "SELECT COUNT(*) as cnt FROM bantuan_pemakaman WHERE nik='$nik' AND status_meninggal='$status_meninggal' AND deleted_at IS NULL";
        $result_check = $conn->query($sql_check);
        $row_check = $result_check->fetch_assoc();
        if ($row_check['cnt'] >= 1) {
            echo "<script>alert('Claim pemakaman untuk $status_meninggal hanya boleh 1x!');window.location='../view/form_pemakaman.php';</script>";
            exit;
        }
    }

    // Validasi: nominal maksimal 15jt atau 1x upah (untuk selain karyawan)
    $max_nominal = 15000000;
    if ($status_meninggal != 'Karyawan') {
        $sql_upah = "SELECT upah FROM master_karyawan WHERE nik='$nik'";
        $res_upah = $conn->query($sql_upah);
        $upah = $res_upah->fetch_assoc()['upah'];
        if ($upah > 0) $max_nominal = min($max_nominal, $upah);
    }
    if ($nominal_pengajuan > $max_nominal) $nominal_pengajuan = $max_nominal;

    $sql = "INSERT INTO bantuan_pemakaman
        (nik, status_meninggal, nama_meninggal, tgl_meninggal, no_spd, tgl_pengajuan, nominal_pengajuan, dibuat_oleh, created_at)
        VALUES
        ('$nik','$status_meninggal','$nama_meninggal','$tgl_meninggal','$no_spd','$tgl_pengajuan','$nominal_pengajuan','$dibuat_oleh','$created_at')";
    $conn->query($sql);

    header('Location: ../view/list_pemakaman.php');
    exit;
}

// Soft delete
if (isset($_GET['hapus_id'])) {
    $id = $_GET['hapus_id'];
    $deleted_at = date('Y-m-d H:i:s');
    $deleted_by = $_SESSION['user_id'];
    $sql = "UPDATE bantuan_pemakaman SET deleted_at='$deleted_at', deleted_by='$deleted_by' WHERE id='$id'";
    $conn->query($sql);
    header('Location: ../view/list_pemakaman.php');
    exit;
}
?>
