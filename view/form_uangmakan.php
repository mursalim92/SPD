<?php
session_start();
if (!isset($_SESSION['user_id'])) header('Location: login.php');
?>
<!DOCTYPE html>
<html>
<head><title>Form Uang Makan Direksi</title></head>
<body>
    <h2>Form Input Uang Makan Direksi</h2>
    <form method="post" action="../controller/proses_uangmakan.php">
        NIK: <input type="text" name="nik" required><br>
        No SPD: <input type="text" name="no_spd" required><br>
        Tgl Kwitansi: <input type="date" name="tgl_kwitansi" required><br>
        Tgl Pengajuan: <input type="date" name="tgl_pengajuan" required><br>
        Nominal Pengajuan: <input type="number" name="nominal_pengajuan" required><br>
        Persentase Ditanggung: <input type="number" name="persentase_tanggung" min="1" max="100" required><br>
        <button type="submit">Simpan</button>
    </form>
    <a href="dashboard.php">Kembali ke Dashboard</a>
</body>
</html>
