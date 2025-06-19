<?php
session_start();
include '../config/db.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit(); // Selalu tambahkan exit setelah redirect
}

// Ambil parameter pencarian, pastikan aman dengan htmlspecialchars
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$search_param = "%" . $search . "%";

// Data aktif dengan pencarian
// Menggunakan prepared statements untuk keamanan
$sql = "SELECT * FROM reimburse_rawatjalan WHERE deleted_at IS NULL";
if ($search) {
    $sql .= " AND (nik LIKE ? OR no_spd LIKE ? OR nama_tanggung LIKE ? OR nama LIKE ?)";
}
$sql .= " ORDER BY created_at DESC"; // Urutkan berdasarkan data terbaru
$stmt = $conn->prepare($sql);
if ($search) {
    $stmt->bind_param("ssss", $search_param, $search_param, $search_param, $search_param);
}
$stmt->execute();
$result = $stmt->get_result();

// Data terhapus dengan pencarian
$sql2 = "SELECT r.*, u.username AS deleted_by_username 
         FROM reimburse_rawatjalan r 
         LEFT JOIN user u ON r.deleted_by = u.user_id 
         WHERE r.deleted_at IS NOT NULL";
if ($search) {
    $sql2 .= " AND (r.nik LIKE ? OR r.no_spd LIKE ? OR r.nama_tanggung LIKE ? OR u.username LIKE ?)";
}
$sql2 .= " ORDER BY r.deleted_at DESC"; // Urutkan berdasarkan waktu hapus terbaru
$stmt2 = $conn->prepare($sql2);
if ($search) {
    $stmt2->bind_param("ssss", $search_param, $search_param, $search_param, $search_param);
}
$stmt2->execute();
$result2 = $stmt2->get_result();

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Rawat Jalan</title>
    <style>
        :root {
            --primary-color: #2196F3;
            --primary-hover: #1976D2;
            --danger-color: #f44336;
            --danger-hover: #d32f2f;
            --secondary-color: #607D8B;
            --secondary-hover: #455A64;
            --background-color: #F5F5F5;
            --surface-color: #FFFFFF;
            --text-primary: #212121;
            --text-secondary: #757575;
            --border-color: #E0E0E0;
            --shadow: 0 4px 12px rgba(0,0,0,0.1);
            --border-radius: 8px;
        }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background-color: var(--background-color);
            color: var(--text-primary);
            margin: 0;
            padding: 24px;
        }

        .container {
            max-width: 1600px;
            margin: 0 auto;
            background-color: var(--surface-color);
            padding: 24px;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
        }

        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
            margin-bottom: 24px;
        }

        .header-section h2 {
            margin: 0;
            color: var(--text-primary);
            border-bottom: 3px solid var(--primary-color);
            padding-bottom: 8px;
        }

        .search-container {
            display: flex;
            gap: 8px;
        }

        .search-container input {
            padding: 10px 14px;
            width: 300px;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            font-size: 1rem;
            transition: all 0.2s ease;
        }

        .search-container input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(33, 150, 243, 0.2);
            outline: none;
        }

        .search-container button {
            padding: 10px 20px;
            background: var(--primary-color);
            border: none;
            color: white;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 500;
            transition: background-color 0.2s ease;
        }

        .search-container button:hover {
            background-color: var(--primary-hover);
        }

        /* KUNCI RESPONSIVE: Wrapper untuk membuat tabel bisa scroll horizontal */
        .table-wrapper {
            overflow-x: auto;
            margin-bottom: 24px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: var(--surface-color);
        }

        /* PERMINTAAN: Tinggi baris tidak besar & font disesuaikan */
        th, td {
            padding: 10px 14px; /* Padding lebih kecil dari sebelumnya */
            text-align: left;
            border-bottom: 1px solid var(--border-color);
            font-size: 0.9rem; /* Ukuran font sedikit lebih kecil */
            white-space: nowrap; /* Mencegah teks turun baris */
        }

        th {
            background-color: var(--primary-color);
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.85rem;
        }

        tr:hover {
            background-color: #f9f9f9;
        }

        tr:last-child td {
            border-bottom: none;
        }

        .btn {
            padding: 6px 12px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            margin: 2px 0;
            font-weight: 500;
            border: none;
            cursor: pointer;
            transition: filter 0.2s ease;
            font-size: 0.85rem;
            text-align: center;
        }
        .btn:hover {
            filter: brightness(1.1);
        }

        .btn-edit { background: var(--primary-color); color: white; }
        .btn-delete { background: var(--danger-color); color: white; }
        .btn-back { background: var(--secondary-color); color: white; float: right;}

        .action-cell {
            display: flex;
            gap: 8px;
        }

        h3 {
            font-size: 1.25rem;
            margin-top: 32px;
            margin-bottom: 16px;
            color: var(--text-secondary);
        }
        
        .table-deleted th {
             background-color: var(--secondary-color);
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header-section">
        <h2>Data Rawat Jalan Aktif</h2>
        <div class="search-container">
            <form method="GET" style="display: contents;">
                <input type="text" name="search" placeholder="Cari NIK, No SPD, Nama..." value="<?= htmlspecialchars($search) ?>">
                <button type="submit">Cari</button>
            </form>
        </div>
    </div>
    
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>NIK</th>
                    <th>Nama Karyawan</th>
                    <th>No SPD</th>
                    <th>Tanggal SPD</th>
                    <th>Nama Tertanggung</th>
                    <th>Status</th>
                    <th>Nominal</th>
                    <th>Jumlah Diganti</th>
                    <th>R.S/Klinik</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['nik']) ?></td>
                    <td><?= htmlspecialchars($row['nama']) ?></td>
                    <td><?= htmlspecialchars($row['no_spd']) ?></td>
                    <td><?= htmlspecialchars(date('d F Y', strtotime($row['tgl_pengajuan']))) ?></td>
                    <td><?= htmlspecialchars($row['nama_tanggung']) ?></td>
                    <td><?= htmlspecialchars($row['status_tanggung']) ?></td>
                    <td>Rp <?= number_format($row['nominal_pengajuan'], 0, ',', '.') ?></td>
                    <td>Rp <?= number_format($row['jumlah_diganti'], 0, ',', '.') ?></td>
                    <td><?= htmlspecialchars($row['nama_rumah_sakit']) ?></td>
                    <td class="action-cell">
                        <a href="form_edit_rawatjalan.php?id=<?= $row['id'] ?>" class="btn btn-edit">Edit</a>
                        <a href="../controller/proses_rawatjalan.php?hapus_id=<?= $row['id'] ?>" 
                           onclick="return confirm('Anda yakin ingin menghapus data ini?')" 
                           class="btn btn-delete">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; ?>
                 <?php if ($result->num_rows === 0): ?>
                    <tr>
                        <td colspan="11" style="text-align:center; padding: 20px; white-space: normal;">
                            Data tidak ditemukan.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <h3>Arsip Data Terhapus</h3>
    <div class="table-wrapper">
        <table class="table-deleted">
            <thead>
                <tr>
                    <th>NIK</th>
                    <th>Nama Karyawan</th>
                    <th>No SPD</th>
                    <th>Nama Tertanggung</th>
                    <th>Nominal</th>
                    <th>Jumlah Diganti</th>
                    <th>R.S/Klinik</th>
                    <th>Dihapus Oleh</th>
                    <th>Waktu Hapus</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result2->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['nik']) ?></td>
                    <td><?= htmlspecialchars($row['nama']) ?></td>
                    <td><?= htmlspecialchars($row['no_spd']) ?></td>
                    <td><?= htmlspecialchars($row['nama_tanggung']) ?></td>
                    <td>Rp <?= number_format($row['nominal_pengajuan'], 0, ',', '.') ?></td>
                    <td>Rp <?= number_format($row['jumlah_diganti'], 0, ',', '.') ?></td>
                    <td><?= htmlspecialchars($row['nama_rumah_sakit']) ?></td>
                    <td><?= htmlspecialchars($row['deleted_by_username']) ?></td>
                    <td><?= htmlspecialchars(date('d M Y, H:i', strtotime($row['deleted_at']))) ?></td>
                </tr>
                <?php endwhile; ?>
                <?php if ($result2->num_rows === 0): ?>
                    <tr>
                        <td colspan="9" style="text-align:center; padding: 20px; white-space: normal;">
                            Tidak ada data yang dihapus.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <a href="dashboard.php" class="btn btn-back">Kembali ke Dashboard</a>
</div>
</body>
</html>