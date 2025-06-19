<?php
session_start();
include '../config/db.php';

if (isset($_POST['nik'])) {
    $nik = $_POST['nik'];
    $nama_tanggungan = $_POST['nama_tanggungan'];
    $nama_anak = $_POST['nama_anak'];
    $anak_ke = $_POST['anak_ke'];
    $no_akta = $_POST['no_akta'];
    $tgl_melahirkan = $_POST['tgl_melahirkan'];
    $no_spd = $_POST['no_spd'];
    $tgl_kwitansi = $_POST['tgl_kwitansi'];
    $tgl_pengajuan = $_POST['tgl_pengajuan'];
    $nominal_pengajuan = $_POST['nominal_pengajuan'];
    $nama_rs = $_POST['nama_rs'];
    $dibuat_oleh = $_SESSION['user_id'];
    $created_at = date('Y-m-d H:i:s');

    // Validasi: claim max 3x selama menjadi karyawan (bisa kembangkan query count di tahap berikut)
    $sql_check = "SELECT COUNT(*) as cnt FROM sumbangan_kelahiran WHERE nik='$nik' AND deleted_at IS NULL";
    $result_check = $conn->query($sql_check);
    $row_check = $result_check->fetch_assoc();
    if ($row_check['cnt'] >= 3) {
        echo "<script>alert('Claim kelahiran sudah mencapai batas maksimal 3x');window.location='../view/form_kelahiran.php';</script>";
        exit;
    }

    // Validasi: masa aktif 90 hari dari tgl melahirkan
    $diff = (strtotime($tgl_pengajuan) - strtotime($tgl_melahirkan)) / (60 * 60 * 24);
    if ($diff > 90) {
        echo "<script>alert('Pengajuan lebih dari 90 hari dari tanggal melahirkan!');window.location='../view/form_kelahiran.php';</script>";
        exit;
    }

    // Validasi: minimal usia kerja 3 bulan (dari TMK ke tanggal melahirkan)
    $q_tmk = "SELECT tgl_masuk_kerja FROM master_karyawan WHERE nik='$nik'";
    $r_tmk = $conn->query($q_tmk);
    $tmk = $r_tmk->fetch_assoc()['tgl_masuk_kerja'];
    $selisih_bulan = (strtotime($tgl_melahirkan) - strtotime($tmk)) / (30*24*60*60);
    if ($selisih_bulan < 3) {
        echo "<script>alert('Minimal usia kerja karyawan 3 bulan dari TMK ke tanggal melahirkan!');window.location='../view/form_kelahiran.php';</script>";
        exit;
    }

    $sql = "INSERT INTO sumbangan_kelahiran
        (nik, nama_tanggungan, nama_anak, anak_ke, no_akta, tgl_melahirkan, no_spd, tgl_kwitansi, tgl_pengajuan, nominal_pengajuan, nama_rs, dibuat_oleh, created_at)
        VALUES
        ('$nik','$nama_tanggungan','$nama_anak','$anak_ke','$no_akta','$tgl_melahirkan','$no_spd','$tgl_kwitansi','$tgl_pengajuan','$nominal_pengajuan','$nama_rs','$dibuat_oleh','$created_at')";
    $conn->query($sql);

    header('Location: ../view/list_kelahiran.php');
    exit;
}

// Soft delete
if (isset($_GET['hapus_id'])) {
    $id = $_GET['hapus_id'];
    $deleted_at = date('Y-m-d H:i:s');
    $deleted_by = $_SESSION['user_id'];
    $sql = "UPDATE sumbangan_kelahiran SET deleted_at='$deleted_at', deleted_by='$deleted_by' WHERE id='$id'";
    $conn->query($sql);
    header('Location: ../view/list_kelahiran.php');
    exit;
}
?>
