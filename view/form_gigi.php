<?php
session_start();
if (!isset($_SESSION['user_id'])) header('Location: login.php');
?>
<!DOCTYPE html>
<html>
<head><title>Form Reimburse Medical Gigi</title></head>
<body>
    <h2>Form Input Reimburse Gigi</h2>
    <form method="post" action="../controller/proses_gigi.php">
        NIK: <input type="text" name="nik" required><br>
        No SPD: <input type="text" name="no_spd" required><br>
        No Kwitansi: <input type="text" name="no_kwitansi" required><br>
        Tgl Kwitansi: <input type="date" name="tgl_kwitansi" required><br>
        Tgl Pengajuan: <input type="date" name="tgl_pengajuan" required><br>
        Jenis Perawatan Gigi:
        <select name="jenis_perawatan_gigi" required>
            <option value="Tambal">Tambal Gigi</option>
            <option value="Saluran_Akar">Perawatan Saluran Akar</option>
            <option value="Scaling">Scaling (Karang Gigi)</option>
        </select><br>
        Nominal Pengajuan: <input type="number" name="nominal_pengajuan" required><br>
        Persentase Ditanggung: <input type="number" name="persentase_tanggung" min="1" max="100" required><br>
        Nama Rumah Sakit: <input type="text" name="nama_rumah_sakit"><br>
        <button type="submit">Simpan</button>
    </form>
    <a href="dashboard.php">Kembali ke Dashboard</a>
</body>
</html>
