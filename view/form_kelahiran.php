<?php
session_start();
if (!isset($_SESSION['user_id'])) header('Location: login.php');
?>
<!DOCTYPE html>
<html>
<head><title>Form Sumbangan Kelahiran</title></head>
<body>
    <h2>Form Input Sumbangan Kelahiran</h2>
    <form method="post" action="../controller/proses_kelahiran.php">
        NIK: <input type="text" name="nik" required><br>
        Nama Tanggungan (Istri): <input type="text" name="nama_tanggungan" required><br>
        Nama Anak: <input type="text" name="nama_anak" required><br>
        Anak Ke: <input type="number" name="anak_ke" required><br>
        Nomor Akta Kelahiran: <input type="text" name="no_akta" required><br>
        Tanggal Melahirkan: <input type="date" name="tgl_melahirkan" required><br>
        No SPD: <input type="text" name="no_spd" required><br>
        Tanggal Nota/Kwitansi: <input type="date" name="tgl_kwitansi" required><br>
        Tanggal Pengajuan: <input type="date" name="tgl_pengajuan" required><br>
        Nominal Pengajuan (Rp. 5.000.000): <input type="number" name="nominal_pengajuan" value="5000000" required readonly><br>
        Nama RS/Klinik Gigi: <input type="text" name="nama_rs" required><br>
        <button type="submit">Simpan</button>
    </form>
    <a href="dashboard.php">Kembali ke Dashboard</a>
</body>
</html>
