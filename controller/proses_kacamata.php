<?php
session_start();
include '../config/db.php';

if (isset($_POST['nik'])) {
    $nik = $_POST['nik'];
    $no_spd = $_POST['no_spd'];
    $no_kwitansi = $_POST['no_kwitansi'];
    $tgl_kwitansi = $_POST['tgl_kwitansi'];
    $tgl_pengajuan = $_POST['tgl_pengajuan'];
    $harga_frame_kwitansi = $_POST['harga_frame_kwitansi'];
    $harga_lensa_kwitansi = $_POST['harga_lensa_kwitansi'];
    $nama_optik = $_POST['nama_optik'];
    $dibuat_oleh = $_SESSION['user_id'];
    $created_at = date('Y-m-d H:i:s');

    // [Contoh Validasi Plafon: silakan aktifkan kode ini sesuai kebutuhan]
    // Lookup level karyawan
    $sql_karyawan = "SELECT level FROM master_karyawan WHERE nik='$nik'";
    $res_karyawan = $conn->query($sql_karyawan);
    $row_karyawan = $res_karyawan->fetch_assoc();
    $level = $row_karyawan ? strtolower($row_karyawan['level']) : '';

    // Atur plafon per level
    $plafon_frame = 0; $plafon_lensa = 0;
    if ($level == 'direktur') {
        $plafon_frame = 99999999; // on bill (no limit)
        $plafon_lensa = 99999999;
    } else if ($level == 'manager') {
        $plafon_frame = 2500000; $plafon_lensa = 1200000;
    } else if ($level == 'superintendent') {
        $plafon_frame = 1500000; $plafon_lensa = 1000000;
    } else if ($level == 'supervisor') {
        $plafon_frame = 1500000; $plafon_lensa = 1000000;
    } else if ($level == 'officer' || $level == 'foreman') {
        $plafon_frame = 1000000; $plafon_lensa = 600000;
    } else {
        $plafon_frame = 800000; $plafon_lensa = 400000;
    }

    // Hitung harga frame/lensa yang diganti (max plafon)
    $harga_frame_ditanggung = min($harga_frame_kwitansi, $plafon_frame);
    $harga_lensa_ditanggung = min($harga_lensa_kwitansi, $plafon_lensa);
    $jumlah_diganti = $harga_frame_ditanggung + $harga_lensa_ditanggung;

    $sql = "INSERT INTO reimburse_kacamata
        (nik, no_spd, no_kwitansi, tgl_kwitansi, tgl_pengajuan,
         harga_frame_kwitansi, harga_lensa_kwitansi, harga_frame_ditanggung, harga_lensa_ditanggung, jumlah_diganti,
         nama_optik, dibuat_oleh, created_at)
        VALUES
        ('$nik','$no_spd','$no_kwitansi','$tgl_kwitansi','$tgl_pengajuan',
         '$harga_frame_kwitansi','$harga_lensa_kwitansi','$harga_frame_ditanggung','$harga_lensa_ditanggung','$jumlah_diganti',
         '$nama_optik','$dibuat_oleh','$created_at')";
    $conn->query($sql);

    header('Location: ../view/list_kacamata.php');
    exit;
}

// Proses soft delete
if (isset($_GET['hapus_id'])) {
    $id = $_GET['hapus_id'];
    $deleted_at = date('Y-m-d H:i:s');
    $deleted_by = $_SESSION['user_id'];
    $sql = "UPDATE reimburse_kacamata SET deleted_at='$deleted_at', deleted_by='$deleted_by' WHERE id='$id'";
    $conn->query($sql);
    header('Location: ../view/list_kacamata.php');
    exit;
}
?>
