<?php 
session_start(); 
if (!isset($_SESSION['user_id'])) { 
    header('Location: view/dahsboard.php'); 
    exit(); // Selalu tambahkan exit() setelah header redirect 
} 
?> 


