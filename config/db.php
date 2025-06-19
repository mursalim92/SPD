<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'db_claim';

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die('Database gagal: ' . $conn->connect_error);
}
?>
