<?php
session_start();
include '../config/db.php';
if (!isset($_SESSION['user_id'])) header('Location: login.php');

// Ambil id dari URL
$id = isset($_GET['id']) ? $_GET['id'] : 0;
$id = intval($id);

if ($_SESSION['role'] == 'officer') {
    $sql = "SELECT * FROM reimburse_rawatjalan WHERE id='$id' AND dibuat_oleh='{$_SESSION['user_id']}' AND deleted_at IS NULL";
} else {
    $sql = "SELECT * FROM reimburse_rawatjalan WHERE id='$id' AND deleted_at IS NULL";
}

$result = $conn->query($sql);
$row = $result->fetch_assoc();
if (!$row) {
    echo "<p style='color:red'>Data tidak ditemukan atau Anda tidak berhak mengedit data ini!</p>";
    echo "<a href='list_rawatjalan.php'>Kembali ke List</a>";
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Rawat Jalan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .form-container {
            max-width: 800px;
            margin: 30px auto;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 8px;
            background-color: #fff;
        }
        .form-title {
            color: #2c3e50;
            margin-bottom: 30px;
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .btn-container {
            margin-top: 25px;
            display: flex;
            gap: 10px;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container form-container">
        <h2 class="form-title">Edit Data Rawat Jalan</h2>
        <form method="post" action="../controller/proses_rawatjalan.php">
            <input type="hidden" name="edit_id" value="<?= htmlspecialchars($row['id']) ?>">
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">NIK</label>
                        <input type="text" class="form-control" name="nik" id="nik" value="<?= htmlspecialchars($row['nik']) ?>" required autocomplete="off">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Nama</label>
                        <input type="text" class="form-control" name="nama" id="nama" value="<?= htmlspecialchars($row['nama']) ?>" readonly required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Jabatan</label>
                        <input type="text" class="form-control" name="jabatan" id="jabatan" value="<?= htmlspecialchars($row['jabatan']) ?>" readonly required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">No SPD</label>
                        <input type="text" class="form-control" name="no_spd" value="<?= htmlspecialchars($row['no_spd']) ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">No Kwitansi</label>
                        <input type="text" class="form-control" name="no_kwitansi" value="<?= htmlspecialchars($row['no_kwitansi']) ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Nama Tanggungan</label>
                        <input type="text" class="form-control" name="nama_tanggung" value="<?= htmlspecialchars($row['nama_tanggung'])?>" required>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Status Tanggungan</label>
                        <select class="form-select" name="status_tanggung" required>
                            <option value="Karyawan" <?= $row['status_tanggung'] == 'Karyawan' ? 'selected' : '' ?>>Karyawan</option>
                            <option value="Istri/Suami" <?= $row['status_tanggung'] == 'Istri/Suami' ? 'selected' : '' ?>>Istri/Suami</option>
                            <option value="Anak" <?= $row['status_tanggung'] == 'Anak' ? 'selected' : '' ?>>Anak</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Jumlah Diganti</label>
                        <input type="number" class="form-control" name="jumlah_diganti" value="<?= htmlspecialchars($row['jumlah_diganti'])?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Tanggal Kwitansi</label>
                        <input type="date" class="form-control" name="tgl_kwitansi" value="<?= htmlspecialchars($row['tgl_kwitansi']) ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Tanggal Pengajuan</label>
                        <input type="date" class="form-control" name="tgl_pengajuan" value="<?= htmlspecialchars($row['tgl_pengajuan']) ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Nominal Pengajuan</label>
                        <input type="number" class="form-control" name="nominal_pengajuan" value="<?= htmlspecialchars($row['nominal_pengajuan']) ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Persentase Ditanggung (%)</label>
                        <input type="number" class="form-control" name="persentase_tanggung" value="<?= htmlspecialchars($row['persentase_tanggung']) ?>" min="1" max="100" required>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Nama Rumah Sakit</label>
                <input type="text" class="form-control" name="nama_rumah_sakit" value="<?= htmlspecialchars($row['nama_rumah_sakit']) ?>">
            </div>

            <div class="btn-container">
                <button type="submit" name="edit_rawatjalan" class="btn btn-primary">Update</button>
                <a href="list_rawatjalan.php" class="btn btn-secondary">Kembali ke List</a>
            </div>
        </form>
    </div>
</body>
</html>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $('#nik').on('input', function() {
        var nik = $(this).val();
        if (nik.length > 0) {
            $.get('../controller/lookup_karyawan.php', { nik: nik }, function(res) {
                try {
                    var data = JSON.parse(res);
                    $('#nama').val(data.nama);
                    $('#jabatan').val(data.jabatan);
                } catch (e) {
                    $('#nama').val('');
                    $('#jabatan').val('');
                }
            });
        } else {
            $('#nama').val('');
            $('#jabatan').val('');
        }
    });
    </script>
</body>
</html>
