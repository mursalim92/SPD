<?php
session_start();
include '../config/db.php';

// EDIT DATA
if (isset($_POST['edit_rawatjalan'])) {
    $id = $_POST['edit_id'];
    $nik = $_POST['nik'];
    $nama = $_POST['nama'];
    $jabatan = $_POST['jabatan'];
    $no_spd = $_POST['no_spd'];
    $no_kwitansi = $_POST['no_kwitansi'];
    $nama_tanggung = $_POST['nama_tanggung'];
    $status_tanggung = $_POST['status_tanggung'];
    $tgl_kwitansi = $_POST['tgl_kwitansi'];
    $tgl_pengajuan = $_POST['tgl_pengajuan'];
    $nominal_pengajuan = $_POST['nominal_pengajuan'];
    $persen = $_POST['persentase_tanggung'];
    $jumlah_diganti = $nominal_pengajuan * ($persen / 100);
    $nama_rumah_sakit = $_POST['nama_rumah_sakit'];

    // Cek NIK di master_karyawan
    $cekNik = $conn->query("SELECT * FROM master_karyawan WHERE nik='$nik'");
    if ($cekNik->num_rows == 0) {
        echo "<script>alert('NIK tidak ditemukan di database karyawan!');window.location='../view/form_edit_rawatjalan.php?id=$id';</script>";
        exit;
    }

    if ($_SESSION['role'] == 'officer') {
        $cekAkses = $conn->query("SELECT * FROM reimburse_rawatjalan WHERE id='$id' AND dibuat_oleh='{$_SESSION['user_id']}'");
        if ($cekAkses->num_rows == 0) {
            echo "<script>alert('Anda tidak berhak mengedit data ini!');window.location='../view/list_rawatjalan.php';</script>";
            exit;
        }
    }

    $sql = "UPDATE reimburse_rawatjalan SET
        nik='$nik',
        nama='$nama',
        jabatan='$jabatan',
        no_spd='$no_spd',
        no_kwitansi='$no_kwitansi',
        nama_tanggung='$nama_tanggung',
        status_tanggung='$status_tanggung',
        tgl_kwitansi='$tgl_kwitansi',
        tgl_pengajuan='$tgl_pengajuan',
        nominal_pengajuan='$nominal_pengajuan',
        persentase_tanggung='$persen',
        jumlah_diganti='$jumlah_diganti',
        nama_rumah_sakit='$nama_rumah_sakit'
        WHERE id='$id'";
    $conn->query($sql);
    header('Location: ../view/list_rawatjalan.php');
    exit;
}

// INPUT BARU
if (isset($_POST['nik']) && !isset($_POST['edit_rawatjalan'])) {
    $nik = $_POST['nik'];
    $nama = $_POST['nama'];
    $jabatan = $_POST['jabatan'];
    $no_spd = $_POST['no_spd'];
    $no_kwitansi = $_POST['no_kwitansi'];
    $nama_tanggung = $_POST['nama_tanggung'];
    $status_tanggung = $_POST['status_tanggung'];
    $tgl_kwitansi = $_POST['tgl_kwitansi'];
    $tgl_pengajuan = $_POST['tgl_pengajuan'];
    $nominal_pengajuan = $_POST['nominal_pengajuan'];
    $persen = $_POST['persentase_tanggung'];
    $jumlah_diganti = $nominal_pengajuan * ($persen / 100);
    $nama_rumah_sakit = $_POST['nama_rumah_sakit'];
    $dibuat_oleh = $_SESSION['user_id'];
    $created_at = date('Y-m-d H:i:s');

    // Cek NIK di master_karyawan
    $cekNik = $conn->query("SELECT * FROM master_karyawan WHERE nik='$nik'");
    if ($cekNik->num_rows == 0) {
        echo "<script>alert('NIK tidak ditemukan di database karyawan!');window.location='../view/form_rawatjalan.php';</script>";
        exit;
    }

    $sql = "INSERT INTO reimburse_rawatjalan
        (nik, nama, jabatan, no_spd, no_kwitansi, nama_tanggung, status_tanggung, tgl_kwitansi, tgl_pengajuan, nominal_pengajuan, persentase_tanggung, jumlah_diganti, nama_rumah_sakit, dibuat_oleh, created_at)
        VALUES
        ('$nik','$nama','$jabatan','$no_spd','$no_kwitansi','$nama_tanggung','$status_tanggung','$tgl_kwitansi','$tgl_pengajuan','$nominal_pengajuan','$persen','$jumlah_diganti','$nama_rumah_sakit','$dibuat_oleh','$created_at')";
    $conn->query($sql);

    header('Location: ../view/list_rawatjalan.php');
    exit;
}

// SOFT DELETE
if (isset($_GET['hapus_id'])) {
    $id = $_GET['hapus_id'];
    if ($_SESSION['role'] == 'officer') {
        $cekAkses = $conn->query("SELECT * FROM reimburse_rawatjalan WHERE id='$id' AND dibuat_oleh='{$_SESSION['user_id']}'");
        if ($cekAkses->num_rows == 0) {
            echo "<script>alert('Anda tidak berhak menghapus data ini!');window.location='../view/list_rawatjalan.php';</script>";
            exit;
        }
    }
    $deleted_at = date('Y-m-d H:i:s');
    $deleted_by = $_SESSION['user_id'];
    $sql = "UPDATE reimburse_rawatjalan SET deleted_at='$deleted_at', deleted_by='$deleted_by' WHERE id='$id'";
    $conn->query($sql);
    header('Location: ../view/list_rawatjalan.php');
    exit;
}

// Redirect jika tidak ada aksi
header('Location: ../view/list_rawatjalan.php');
exit;
?>
