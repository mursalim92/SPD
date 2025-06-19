<?php 
session_start(); 
if (!isset($_SESSION['user_id'])) { 
    header('Location: login.php'); 
    exit(); // Selalu tambahkan exit() setelah header redirect 
} 
?> 
<!DOCTYPE html> 
<html lang="id"> 
<head> 
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Form Rawat Jalan</title> 
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css"> 
    <style> 
        :root { 
            --primary-color: #2196F3; 
            --primary-hover: #1976D2; 
            --secondary-color: #757575; 
            --secondary-hover: #616161; 
            --background-color: #F5F5F5; 
            --surface-color: #FFFFFF; 
            --text-primary: #212121; 
            --text-secondary: #757575; 
            --border-color: #E0E0E0; 
            --shadow: 0 4px 12px rgba(0,0,0,0.1); 
            --border-radius: 8px; 
            --spacing-unit: 16px; 
        } 

        body { 
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif; 
            background-color: var(--background-color); 
            margin: 0; 
            padding: calc(var(--spacing-unit) * 2); /* Memberi ruang di tepi layar */
            min-height: 100vh; 
            display: flex; 
            flex-direction: column; 
            align-items: center; 
            box-sizing: border-box;
        } 

        .form-container { 
            background: var(--surface-color); 
            padding: calc(var(--spacing-unit) * 2); 
            border-radius: var(--border-radius); 
            box-shadow: var(--shadow); 
            width: 95%; /* Menggunakan persentase agar lebih fleksibel */
            max-width: 1400px; /* Batas lebar maksimum di layar sangat besar */
            margin: var(--spacing-unit) 0; 
        } 

        h2 { 
            color: var(--text-primary); 
            text-align: center; 
            margin-top: 0;
            margin-bottom: calc(var(--spacing-unit) * 2); 
            font-size: 1.75rem; 
            font-weight: 600; 
        } 

        /* --- PERUBAHAN UTAMA: MENGGUNAKAN CSS GRID UNTUK LAYOUT --- */
        form {
            display: grid;
            grid-template-columns: 1fr 1fr; /* Membuat 2 kolom dengan lebar sama */
            gap: var(--spacing-unit) calc(var(--spacing-unit) * 2); /* Jarak vertikal dan horizontal antar input */
        }

        .form-group { 
            margin-bottom: 0; /* Margin tidak diperlukan lagi karena sudah diatur oleh 'gap' */
        } 
        
        /* Kelas utilitas untuk elemen yang ingin memanjang 2 kolom */
        .full-width {
            grid-column: 1 / -1; /* Membentang dari garis kolom pertama hingga terakhir */
        }

        .form-group label { 
            display: block; 
            margin-bottom: calc(var(--spacing-unit) * 0.5); 
            color: var(--text-primary); 
            font-weight: 500; 
            font-size: 0.95rem; 
        } 

        .form-group input, 
        .form-group select { 
            width: 100%; 
            padding: calc(var(--spacing-unit) * 0.75); 
            border: 1px solid var(--border-color); 
            border-radius: calc(var(--border-radius) * 0.5); 
            font-size: 1rem; 
            transition: all 0.2s ease; 
            background-color: var(--surface-color); 
            color: var(--text-primary); 
            box-sizing: border-box; 
        } 

        .form-group input:focus, 
        .form-group select:focus { 
            border-color: var(--primary-color); 
            box-shadow: 0 0 0 3px rgba(33, 150, 243, 0.2); 
            outline: none; 
        } 

        .form-group input[readonly] { 
            background-color: #E9ECEF; /* Warna abu-abu yang lebih jelas untuk readonly */
            cursor: not-allowed; 
            opacity: 0.8; 
        } 

        .form-group select { 
            appearance: none; 
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24'%3E%3Cpath fill='%23757575' d='M7 10l5 5 5-5z'/%3E%3C/svg%3E"); 
            background-repeat: no-repeat; 
            background-position: right 12px center; 
            padding-right: 40px; 
        } 

        .btn { 
            background-color: var(--primary-color); 
            color: white; 
            padding: calc(var(--spacing-unit) * 0.85) var(--spacing-unit); 
            border: none; 
            border-radius: calc(var(--border-radius) * 0.5); 
            font-size: 1rem; 
            font-weight: 600; /* Font lebih tebal */
            cursor: pointer; 
            width: 100%; 
            transition: background-color 0.2s ease, transform 0.1s ease; 
            text-transform: uppercase; 
            letter-spacing: 0.8px; 
        } 

        .btn:hover { 
            background-color: var(--primary-hover); 
        }
        .btn:active {
            transform: scale(0.99); /* Efek tombol ditekan */
        }

        .btn-secondary { 
            display: inline-block; 
            text-align: center; 
            text-decoration: none; 
            background-color: var(--secondary-color); 
            color: white; 
            padding: calc(var(--spacing-unit) * 0.75) var(--spacing-unit); 
            border-radius: calc(var(--border-radius) * 0.5); 
            margin-top: calc(var(--spacing-unit) * 1.5); /* Jarak lebih besar dari form */
            font-weight: 500; 
            transition: background-color 0.2s ease;
            width: auto;
            min-width: 200px;
        } 

        .btn-secondary:hover { 
            background-color: var(--secondary-hover); 
        } 

        /* --- KUNCI RESPONSIVE: Mengembalikan ke 1 kolom di layar kecil --- */
        @media (max-width: 992px) { 
            form {
                grid-template-columns: 1fr; /* Ubah kembali ke 1 kolom */
                gap: var(--spacing-unit); /* Cukup 1 nilai gap untuk 1 kolom */
            }
        }

        @media (max-width: 768px) { 
            body {
                padding: var(--spacing-unit);
            }
            .form-container { 
                width: 100%;
                padding: var(--spacing-unit); 
            } 
        } 
    </style> 
</head> 
<body> 
    <div class="form-container"> 
        <h2>Form Input Rawat Jalan</h2> 
        <form method="post" action="../controller/proses_rawatjalan.php"> 
            <div class="form-group"> 
                <label for="nik">NIK</label> 
                <input type="text" id="nik" name="nik" required autocomplete="off" placeholder="Masukkan NIK lalu data akan terisi otomatis"> 
            </div> 
            <div class="form-group"> 
                <label for="nama">Nama</label> 
                <input type="text" id="nama" name="nama" readonly required> 
            </div> 
            
            <div class="form-group"> 
                <label for="jabatan">Jabatan</label> 
                <input type="text" id="jabatan" name="jabatan" readonly required> 
            </div> 
            <div class="form-group"> 
                <label for="no_spd">No SPD</label> 
                <input type="text" id="no_spd" name="no_spd" required placeholder="Masukkan No SPD"> 
            </div> 
            
            <div class="form-group"> 
                <label for="no_kwitansi">No Kwitansi</label> 
                <input type="text" id="no_kwitansi" name="no_kwitansi" required placeholder="Masukkan No Kwitansi"> 
            </div> 
            <div class="form-group"> 
                <label for="nama_tanggung">Nama Tertanggung</label> 
                <input type="text" id="nama_tanggung" name="nama_tanggung" required placeholder="Masukkan Nama Tertanggung"> 
            </div> 
            
            <div class="form-group"> 
                <label for="status_tanggung">Status Tanggungan</label> 
                <select id="status_tanggung" name="status_tanggung" required> 
                    <option value="">Pilih Status Tanggungan</option> 
                    <option value="Karyawan">KARYAWAN</option> 
                    <option value="Istri/Suami">ISTRI/SUAMI</option> 
                    <option value="Anak">ANAK</option> 
                </select> 
            </div> 
            <div class="form-group"> 
                <label for="tgl_kwitansi">Tanggal Kwitansi</label> 
                <input type="text" id="tgl_kwitansi" name="tgl_kwitansi" required autocomplete="off" placeholder="Pilih Tanggal"> 
            </div> 
            
            <div class="form-group"> 
                <label for="tgl_pengajuan">Tanggal Pengajuan</label> 
                <input type="text" id="tgl_pengajuan" name="tgl_pengajuan" required autocomplete="off" placeholder="Pilih Tanggal"> 
            </div> 
            <div class="form-group"> 
                <label for="nominal_pengajuan">Nominal Pengajuan (Rp)</label> 
                <input type="number" id="nominal_pengajuan" name="nominal_pengajuan" required placeholder="0"> 
            </div> 

            <div class="form-group"> 
                <label for="persentase_tanggung">Persentase Ditanggung (%)</label> 
                <input type="number" id="persentase_tanggung" name="persentase_tanggung" min="1" max="100" required placeholder="0"> 
            </div>
             <div></div>
            
            <div class="form-group full-width"> 
                <label for="nama_rumah_sakit">Nama Rumah Sakit</label> 
                <input type="text" id="nama_rumah_sakit" name="nama_rumah_sakit" placeholder="Masukkan Nama Rumah Sakit"> 
            </div> 
             
            <div class="full-width">
                <button type="submit" class="btn">Simpan Data</button> <br>
                <a href="dashboard.php" class="btn-secondary">Kembali ke Dashboard</a> 
            </div>
        </form> 
    </div> 

    

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script> 
    <script> 
    $(function() { 
        // --- FUNGSI DATEPICKER --- 
        // Mengubah input tanggal menjadi datepicker yang interaktif 
        $("#tgl_kwitansi, #tgl_pengajuan").datepicker({ 
            dateFormat: "yy-mm-dd", // Format tanggal yang dikirim ke database 
            changeMonth: true, 
            changeYear: true, 
            yearRange: "-5:+5" // Menampilkan 5 tahun ke belakang dan 5 tahun ke depan 
        }); 

        // --- FUNGSI AUTOCOMPLETE NIK --- 
        // Mengambil daftar NIK dari server dan menampilkannya sebagai saran 
        $.getJSON('../controller/list_nik.php', function(data) { 
            $("#nik").autocomplete({ 
                source: data, 
                minLength: 2, 
                select: function(event, ui) { 
                    // Saat NIK dipilih, pisahkan NIK dari nama 
                    var nikSelected = ui.item.value.split(' ')[0]; 
                    $("#nik").val(nikSelected); 
                    // Memicu event 'input' secara manual untuk menjalankan lookup 
                    $("#nik").trigger('input');  
                    return false; // Mencegah autocomplete mengisi input dengan value lengkap 
                } 
            }); 
        }); 

        // --- FUNGSI LOOKUP KARYAWAN --- 
        // Mencari data nama dan jabatan berdasarkan NIK yang diinput 
        $('#nik').on('input', function() { 
            var nikVal = $(this).val().split(' ')[0]; 
            if (nikVal.length >= 2) { // Jalankan lookup jika NIK cukup panjang 
                $.get('../controller/lookup_karyawan.php', { nik: nikVal }, function(res) { 
                    try { 
                        var data = JSON.parse(res); 
                        // Jika data ditemukan, isi field nama dan jabatan 
                        if (data && data.nama) { 
                            $('#nama').val(data.nama); 
                            $('#jabatan').val(data.jabatan); 
                        } else { 
                        // Jika NIK valid tapi data tidak ditemukan 
                            $('#nama').val('Data tidak ditemukan'); 
                            $('#jabatan').val('Data tidak ditemukan'); 
                        } 
                    } catch (e) { 
                        // Jika terjadi error atau NIK tidak valid, kosongkan field 
                        $('#nama').val(''); 
                        $('#jabatan').val(''); 
                    } 
                }); 
            } else { 
                // Kosongkan jika input NIK dihapus 
                $('#nama').val(''); 
                $('#jabatan').val(''); 
            } 
        }); 
    }); 
    </script> 
</body> 
</html>