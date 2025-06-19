<?php
session_start();
if (!isset($_SESSION['user_id'])) header('Location: login.php');
?>
<!DOCTYPE html>
<html>
<head><title>Form Reimburse Kacamata</title></head>
<body>
    <h2>Form Input Reimburse Kacamata</h2>
    <form method="post" action="../controller/proses_kacamata.php">
        NIK: <input type="text" name="nik" required><br>
        No SPD: <input type="text" name="no_spd" required><br>
        No Kwitansi: <input type="text" name="no_kwitansi" required><br>
        Tgl Kwitansi: <input type="date" name="tgl_kwitansi" required><br>
        Tgl Pengajuan: <input type="date" name="tgl_pengajuan" required><br>
        Harga Frame di Kwitansi: <input type="number" name="harga_frame_kwitansi" required><br>
        Harga Lensa di Kwitansi: <input type="number" name="harga_lensa_kwitansi" required><br>
        Nama Optik: <input type="text" name="nama_optik"><br>
        <button type="submit">Simpan</button>
    </form>
    <a href="dashboard.php">Kembali ke Dashboard</a>
</body>
</html>
