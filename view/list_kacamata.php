<?php
session_start();
include '../config/db.php';
if (!isset($_SESSION['user_id'])) header('Location: login.php');

// Data aktif
$sql = "SELECT * FROM reimburse_kacamata WHERE deleted_at IS NULL";
$result = $conn->query($sql);

echo "<h3>Data Reimburse Kacamata Aktif</h3><table border=1>
<tr>
<th>NIK</th><th>No SPD</th><th>No Kwitansi</th><th>Frame Kwitansi</th><th>Lensa Kwitansi</th><th>Frame Ditanggung</th><th>Lensa Ditanggung</th><th>Jumlah Diganti</th><th>Action</th>
</tr>";
while($row = $result->fetch_assoc()) {
    echo "<tr>
    <td>{$row['nik']}</td>
    <td>{$row['no_spd']}</td>
    <td>{$row['no_kwitansi']}</td>
    <td>{$row['harga_frame_kwitansi']}</td>
    <td>{$row['harga_lensa_kwitansi']}</td>
    <td>{$row['harga_frame_ditanggung']}</td>
    <td>{$row['harga_lensa_ditanggung']}</td>
    <td>{$row['jumlah_diganti']}</td>
    <td><a href='../controller/proses_kacamata.php?hapus_id={$row['id']}' onclick=\"return confirm('Hapus?')\">Hapus</a></td>
    </tr>";
}
echo "</table>";

// Data terhapus
$sql2 = "SELECT r.*, u.username AS deleted_by FROM reimburse_kacamata r LEFT JOIN user u ON r.deleted_by = u.user_id WHERE r.deleted_at IS NOT NULL";
$result2 = $conn->query($sql2);

echo "<h3>Data Kacamata Terhapus</h3><table border=1>
<tr>
<th>NIK</th><th>No SPD</th><th>No Kwitansi</th><th>Frame Kwitansi</th><th>Lensa Kwitansi</th><th>Frame Ditanggung</th><th>Lensa Ditanggung</th><th>Jumlah Diganti</th><th>Dihapus Oleh</th><th>Waktu Hapus</th>
</tr>";
while($row = $result2->fetch_assoc()) {
    echo "<tr>
    <td>{$row['nik']}</td>
    <td>{$row['no_spd']}</td>
    <td>{$row['no_kwitansi']}</td>
    <td>{$row['harga_frame_kwitansi']}</td>
    <td>{$row['harga_lensa_kwitansi']}</td>
    <td>{$row['harga_frame_ditanggung']}</td>
    <td>{$row['harga_lensa_ditanggung']}</td>
    <td>{$row['jumlah_diganti']}</td>
    <td>{$row['deleted_by']}</td>
    <td>{$row['deleted_at']}</td>
    </tr>";
}
echo "</table>";

echo '<a href="dashboard.php">Kembali ke Dashboard</a>';
?>
