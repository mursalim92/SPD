<?php
session_start();
include '../config/db.php'; // Pastikan path ini benar

// --- CATATAN PENTING KEAMANAN ---
// Menggunakan MD5 untuk hashing password sangat tidak aman dan tidak direkomendasikan.
// Sebaiknya, gunakan password_hash() saat registrasi dan password_verify() saat login.
// 
// Contoh saat registrasi:
// $password = 'password_pengguna';
// $hashed_password = password_hash($password, PASSWORD_DEFAULT);
// Simpan $hashed_password di database.
//
// Contoh verifikasi saat login:
// $password_input = $_POST['password'];
// $hashed_password_from_db = $row['password_hash']; // Ambil dari database
// if (password_verify($password_input, $hashed_password_from_db)) {
//     // Password cocok
// } else {
//     // Password tidak cocok
// }
//
// Untuk contoh ini, saya akan tetap menggunakan MD5 sesuai kode asli,
// namun sangat disarankan untuk beralih ke metode yang lebih aman.

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['username']) || empty($_POST['password'])) {
        $error = "Nama pengguna dan kata sandi tidak boleh kosong!";
    } else {
        $username = $conn->real_escape_string($_POST['username']);
        $password = md5($_POST['password']); // Tetap menggunakan md5 sesuai kode asli, tapi tidak aman.

        // Ganti nama kolom 'password_hash' jika di database Anda berbeda
        $sql = "SELECT user_id, username, role FROM user WHERE username='$username' AND password_hash='$password'";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['role'] = $row['role'];
            $_SESSION['username'] = $row['username'];
            header('Location: dashboard.php');
            exit;
        } else {
            $error = "Nama pengguna atau kata sandi salah!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Reimburse</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

        :root {
            --primary-color: #4a90e2;
            --light-grey: #f4f4f4;
            --dark-grey: #333;
            --error-color: #e74c3c;
            --success-color: #2ecc71;
            --white-color: #ffffff;
            --border-radius: 8px;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light-grey);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background-color: var(--white-color);
            padding: 40px;
            border-radius: var(--border-radius);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            box-sizing: border-box;
            text-align: center;
        }

        .login-container h2 {
            color: var(--dark-grey);
            margin-bottom: 10px;
        }

        .login-container p {
            color: #777;
            margin-bottom: 30px;
        }

        .input-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .input-group label {
            display: block;
            margin-bottom: 8px;
            color: var(--dark-grey);
            font-weight: 600;
        }

        .input-group input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: var(--border-radius);
            box-sizing: border-box;
            transition: border-color 0.3s;
        }

        .input-group input:focus {
            outline: none;
            border-color: var(--primary-color);
        }

        .btn-submit {
            width: 100%;
            padding: 12px;
            background-color: var(--primary-color);
            border: none;
            color: var(--white-color);
            font-size: 16px;
            font-weight: 600;
            border-radius: var(--border-radius);
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-submit:hover {
            background-color: #357abd;
        }

        .error-message {
            background-color: #fdd;
            color: var(--error-color);
            padding: 10px;
            border-radius: var(--border-radius);
            margin-bottom: 20px;
            border: 1px solid var(--error-color);
            text-align: center;
            display: <?php echo !empty($error) ? 'block' : 'none'; ?>;
        }

        /* Responsive Design */
        @media (max-width: 480px) {
            .login-container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Selamat Datang</h2>
        <p>Silakan masuk untuk melanjutkan</p>

        <div class="error-message">
            <?php echo $error; ?>
        </div>
        
        <form method="POST" action="login.php" novalidate>
            <div class="input-group">
                <label for="username">Nama Pengguna</label>
                <input id="username" name="username" type="text" required>
            </div>
            <div class="input-group">
                <label for="password">Kata Sandi</label>
                <input id="password" type="password" name="password" required>
            </div>
            <button type="submit" class="btn-submit">Masuk</button>
        </form>
    </div>
</body>
</html>