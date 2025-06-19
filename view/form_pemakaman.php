<?php
session_start();
if (!isset($_SESSION['user_id'])) header('Location: login.php');
?>
<!DOCTYPE html>
<html>
<head><title>Form Bantuan Biaya Pemakaman</title></head>
<body>
    <h2>Form Input Bantuan Biaya Pemakaman</h2>
    <form method="post" action="../controller/proses_pemakaman.php">
        NIK: <input type="text" name="nik" required><br>
        Status Meninggal:
        <select name="status_meninggal" required>
            <option value="Karyawan">Karyawan</option>
            <option value="Istri">Istri</option>
            <option value="Suami">Suami</option>
            <option value="Anak">Anak</option>
            <option value="Ayah">Ayah</option>
            <option value="Ibu">Ibu</option>
        </select><br>
        Nama Meninggal: <input type="text" name="nama_meninggal" required><br>
        Tanggal Meninggal: <input type="date" name="tgl_meninggal" required><br>
        No SPD: <input type="text" name="no_spd" required><br>
        Tanggal Pengajuan: <input type="date" name="tgl_pengajuan" required><br>
        Nominal Pengajuan (max 15.000.000 atau 1x upah): <input type="number" name="nominal_pengajuan" max="15000000" required><br>
        <button type="submit">Simpan</button>
    </form>
    <a href="dashboard.php">Kembali ke Dashboard</a>
</body>
</html>
