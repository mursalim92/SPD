<?php
session_start();

// Jika sudah login, arahkan ke dashboard
if (isset($_SESSION['user_id'])) {
    header('Location: view/dashboard.php');
    exit;
}

// Jika belum login, arahkan ke form login
header('Location: view/login.php');
exit;
?>
