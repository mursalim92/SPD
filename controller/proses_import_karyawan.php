<?php
session_start();
include '../config/db.php';

// Cek file upload
if (!isset($_FILES['file_excel']) || $_FILES['file_excel']['error'] != 0) {
    die("Upload file gagal!");
}

// Load library PhpSpreadsheet
require '../vendor/autoload.php'; // Pastikan path ini benar

use PhpOffice\PhpSpreadsheet\IOFactory;

// Baca file Excel
$fileTmp = $_FILES['file_excel']['tmp_name'];
$spreadsheet = IOFactory::load($fileTmp);
$sheet = $spreadsheet->getActiveSheet();
$data = $sheet->toArray();

$success = 0;
$fail = 0;

// Mulai dari baris ke-2 (asumsi baris 1 = header)
for ($i = 1; $i < count($data); $i++) {
    $nik = trim($data[$i][0]);
    $nama = trim($data[$i][1]);
    $jabatan = trim($data[$i][2]);
    $level = trim($data[$i][3]);
    $tgl_masuk_kerja = trim($data[$i][4]);
    $upah = trim($data[$i][5]);
    if ($nik == '') continue;

    // Cek duplikat NIK
    $cek = $conn->query("SELECT nik FROM master_karyawan WHERE nik='$nik'");
    if ($cek->num_rows == 0) {
        $sql = "INSERT INTO master_karyawan (nik, nama, jabatan, level, tgl_masuk_kerja, upah)
                VALUES ('$nik','$nama','$jabatan','$level','$tgl_masuk_kerja','$upah')";
        if ($conn->query($sql)) $success++; else $fail++;
    } else {
        // Update data jika NIK sudah ada (opsional)
        $sql = "UPDATE master_karyawan SET
                    nama='$nama', jabatan='$jabatan', level='$level', tgl_masuk_kerja='$tgl_masuk_kerja', upah='$upah'
                WHERE nik='$nik'";
        if ($conn->query($sql)) $success++; else $fail++;
    }
}

echo "<script>alert('Import selesai. Sukses: $success, Gagal: $fail');window.location='../view/import_karyawan.php';</script>";
exit;
?>
