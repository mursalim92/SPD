<?php
session_start();
include '../config/db.php';
if (!isset($_SESSION['user_id'])) header('Location: login.php');

// Data aktif
$sql = "SELECT * FROM sumbangan_pernikahan WHERE deleted_at IS NULL";
$result = $conn->query($sql);

echo "<h3>Data Sumbangan Pernikahan Aktif</h3><table border=1>
<tr>
<th>NIK</th><th>Nama Pasangan</th><th>Tgl Pernikahan</th><th>No SPD</th><th>Tgl Pengajuan</th><th>Nominal</th><th>Action</th>
</tr>";
while($row = $result->fetch_assoc()) {
    echo "<tr>
    <td>{$row['nik']}</td>
    <td>{$row['nama_tanggungan']}</td>
    <td>{$row['tgl_pernikahan']}</td>
    <td>{$row['no_spd']}</td>
    <td>{$row['tgl_pengajuan']}</td>
    <td>{$row['nominal_pengajuan']}</td>
    <td><a href='../controller/proses_pernikahan.php?hapus_id={$row['id']}' onclick=\"return confirm('Hapus?')\">Hapus</a></td>
    </tr>";
}
echo "</table>";

// Data terhapus
$sql2 = "SELECT r.*, u.username AS deleted_by FROM sumbangan_pernikahan r LEFT JOIN user u ON r.deleted_by = u.user_id WHERE r.deleted_at IS NOT NULL";
$result2 = $conn->query($sql2);

echo "<h3>Data Pernikahan Terhapus</h3><table border=1>
<tr>
<th>NIK</th><th>Nama Pasangan</th><th>Tgl Pernikahan</th><th>No SPD</th><th>Tgl Pengajuan</th><th>Nominal</th><th>Dihapus Oleh</th><th>Waktu Hapus</th>
</tr>";
while($row = $result2->fetch_assoc()) {
    echo "<tr>
    <td>{$row['nik']}</td>
    <td>{$row['nama_tanggungan']}</td>
    <td>{$row['tgl_pernikahan']}</td>
    <td>{$row['no_spd']}</td>
    <td>{$row['tgl_pengajuan']}</td>
    <td>{$row['nominal_pengajuan']}</td>
    <td>{$row['deleted_by']}</td>
    <td>{$row['deleted_at']}</td>
    </tr>";
}
echo "</table>";

echo '<a href="dashboard.php">Kembali ke Dashboard</a>';
?>
