<?php
session_start();
if (!isset($_SESSION['user_id'])) header('Location: login.php');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Import Data Karyawan</title>
</head>
<body>
    <h2>Import Data Master Karyawan (Excel)</h2>
    <form action="../controller/proses_import_karyawan.php" method="post" enctype="multipart/form-data">
        Pilih file Excel (.xlsx): <input type="file" name="file_excel" accept=".xls,.xlsx" required>
        <button type="submit" name="import">Import</button>
    </form>
    <br>
    <a href="dashboard.php">Kembali ke Dashboard</a>
    <br><br>
    <b>Format kolom minimal di Excel:</b> <br>
    NIK | Nama | Jabatan | Level | Tgl Masuk Kerja (YYYY-MM-DD) | Upah<br>
    <small>Baris pertama dianggap header, data mulai baris kedua</small>
</body>
</html>
