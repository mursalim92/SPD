<?php
session_start();
include '../config/db.php';
if (!isset($_SESSION['user_id'])) header('Location: login.php');

// Data aktif
$sql = "SELECT * FROM sumbangan_kelahiran WHERE deleted_at IS NULL";
$result = $conn->query($sql);

echo "<h3>Data Sumbangan Kelahiran Aktif</h3><table border=1>
<tr>
<th>NIK</th><th>Nama Istri</th><th>Nama Anak</th><th>Anak Ke</th><th>No Akta</th><th>Tgl Melahirkan</th><th>No SPD</th><th>Nominal</th><th>Action</th>
</tr>";
while($row = $result->fetch_assoc()) {
    echo "<tr>
    <td>{$row['nik']}</td>
    <td>{$row['nama_tanggungan']}</td>
    <td>{$row['nama_anak']}</td>
    <td>{$row['anak_ke']}</td>
    <td>{$row['no_akta']}</td>
    <td>{$row['tgl_melahirkan']}</td>
    <td>{$row['no_spd']}</td>
    <td>{$row['nominal_pengajuan']}</td>
    <td><a href='../controller/proses_kelahiran.php?hapus_id={$row['id']}' onclick=\"return confirm('Hapus?')\">Hapus</a></td>
    </tr>";
}
echo "</table>";

// Data terhapus
$sql2 = "SELECT r.*, u.username AS deleted_by FROM sumbangan_kelahiran r LEFT JOIN user u ON r.deleted_by = u.user_id WHERE r.deleted_at IS NOT NULL";
$result2 = $conn->query($sql2);

echo "<h3>Data Sumbangan Kelahiran Terhapus</h3><table border=1>
<tr>
<th>NIK</th><th>Nama Istri</th><th>Nama Anak</th><th>Anak Ke</th><th>No Akta</th><th>Tgl Melahirkan</th><th>No SPD</th><th>Nominal</th><th>Dihapus Oleh</th><th>Waktu Hapus</th>
</tr>";
while($row = $result2->fetch_assoc()) {
    echo "<tr>
    <td>{$row['nik']}</td>
    <td>{$row['nama_tanggungan']}</td>
    <td>{$row['nama_anak']}</td>
    <td>{$row['anak_ke']}</td>
    <td>{$row['no_akta']}</td>
    <td>{$row['tgl_melahirkan']}</td>
    <td>{$row['no_spd']}</td>
    <td>{$row['nominal_pengajuan']}</td>
    <td>{$row['deleted_by']}</td>
    <td>{$row['deleted_at']}</td>
    </tr>";
}
echo "</table>";

echo '<a href="dashboard.php">Kembali ke Dashboard</a>';
?>
