<?php
session_start();
if (!isset($_SESSION['user_id'])) header('Location: login.php');
?>
<!DOCTYPE html>
<html>
<head><title>Form Sumbangan Pernikahan</title></head>
<body>
    <h2>Form Input Sumbangan Pernikahan</h2>
    <form method="post" action="../controller/proses_pernikahan.php">
        NIK: <input type="text" name="nik" required><br>
        Nama Tanggungan (Suami/Istri): <input type="text" name="nama_tanggungan" required><br>
        Tanggal Pernikahan: <input type="date" name="tgl_pernikahan" required><br>
        No SPD: <input type="text" name="no_spd" required><br>
        Tanggal Pengajuan: <input type="date" name="tgl_pengajuan" required><br>
        Nominal Pengajuan (max 15.000.000): <input type="number" name="nominal_pengajuan" max="15000000" required><br>
        <button type="submit">Simpan</button>
    </form>
    <a href="dashboard.php">Kembali ke Dashboard</a>
</body>
</html>
