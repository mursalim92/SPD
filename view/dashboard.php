<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); 
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome untuk ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .sidebar {
            min-height: 100vh;
            background-color: #f8f9fa;
            padding-top: 20px;
        }
        .sidebar .nav-link {
            color: #333;
            margin-bottom: 5px;
            border-radius: 5px;
        }
        .sidebar .nav-link:hover {
            background-color: #e9ecef;
        }
        .sidebar .nav-link.active {
            background-color: #0d6efd;
            color: white;
        }
        .main-content {
            padding-top: 20px;
        }
        .card {
            margin-bottom: 20px;
            transition: transform 0.2s;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .welcome-header {
            background-color: #0d6efd;
            color: white;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 d-md-block sidebar collapse bg-light">
                <div class="position-sticky pt-3">
                    <div class="text-center mb-4">
                        <h4>REIMBURSEMENT</h4>
                    </div>
                    
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <h6 class="sidebar-heading px-3 mt-4 mb-1 text-muted">Rawat Jalan</h6>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="form_rawatjalan.php">
                                <i class="fas fa-file-alt me-2"></i>Form Rawat Jalan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="list_rawatjalan.php">
                                <i class="fas fa-list me-2"></i>List Rawat Jalan
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <h6 class="sidebar-heading px-3 mt-4 mb-1 text-muted">Gigi</h6>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="form_gigi.php">
                                <i class="fas fa-tooth me-2"></i>Form Gigi
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="list_gigi.php">
                                <i class="fas fa-list me-2"></i>List Gigi
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <h6 class="sidebar-heading px-3 mt-4 mb-1 text-muted">Kacamata</h6>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="form_kacamata.php">
                                <i class="fas fa-glasses me-2"></i>Form Kacamata
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="list_kacamata.php">
                                <i class="fas fa-list me-2"></i>List Kacamata
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <h6 class="sidebar-heading px-3 mt-4 mb-1 text-muted">Uang Makan</h6>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="form_uangmakan.php">
                                <i class="fas fa-utensils me-2"></i>Form Uang Makan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="list_uangmakan.php">
                                <i class="fas fa-list me-2"></i>List Uang Makan
                            </a>
                        </li>
                    </ul>
                    
                    <ul class="nav flex-column mb-4">
                        <li class="nav-item">
                            <h6 class="sidebar-heading px-3 mt-4 mb-1 text-muted">Sumbangan</h6>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="form_kelahiran.php">
                                <i class="fas fa-baby me-2"></i>Sumbangan Kelahiran
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="list_kelahiran.php">
                                <i class="fas fa-list me-2"></i>List Kelahiran
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="form_pernikahan.php">
                                <i class="fas fa-ring me-2"></i>Sumbangan Pernikahan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="list_pernikahan.php">
                                <i class="fas fa-list me-2"></i>List Pernikahan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="form_pemakaman.php">
                                <i class="fas fa-cross me-2"></i>Bantuan Pemakaman
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="list_pemakaman.php">
                                <i class="fas fa-list me-2"></i>List Pemakaman
                            </a>
                        </li>
                    </ul>
                    
                    <div class="border-top mt-auto p-3">
                        <a href="../logout.php" class="btn btn-danger w-100">
                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 ms-sm-auto px-md-4 main-content">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Dashboard</h1>
                </div>
                
                <div class="welcome-header">
                    <h3>Selamat datang, <?= htmlspecialchars($_SESSION['username']); ?></h3>
                    <p class="mb-0">Silakan pilih menu di sidebar untuk memulai</p>
                </div>
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="card text-white bg-primary">
                            <div class="card-body">
                                <h5 class="card-title">Rawat Jalan</h5>
                                <p class="card-text">Kelola data rawat jalan</p>
                                <a href="form_rawatjalan.php" class="btn btn-light">Form</a>
                                <a href="list_rawatjalan.php" class="btn btn-light">List</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="card text-white bg-success">
                            <div class="card-body">
                                <h5 class="card-title">Gigi</h5>
                                <p class="card-text">Kelola data perawatan gigi</p>
                                <a href="form_gigi.php" class="btn btn-light">Form</a>
                                <a href="list_gigi.php" class="btn btn-light">List</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="card text-white bg-info">
                            <div class="card-body">
                                <h5 class="card-title">Kacamata</h5>
                                <p class="card-text">Kelola data kacamata</p>
                                <a href="form_kacamata.php" class="btn btn-light">Form</a>
                                <a href="list_kacamata.php" class="btn btn-light">List</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="card text-white bg-warning">
                            <div class="card-body">
                                <h5 class="card-title">Uang Makan</h5>
                                <p class="card-text">Kelola uang makan direksi</p>
                                <a href="form_uangmakan.php" class="btn btn-light">Form</a>
                                <a href="list_uangmakan.php" class="btn btn-light">List</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="card text-white bg-secondary">
                            <div class="card-body">
                                <h5 class="card-title">Sumbangan</h5>
                                <p class="card-text">Kelola sumbangan kelahiran & pernikahan</p>
                                <a href="form_kelahiran.php" class="btn btn-light">Kelahiran</a>
                                <a href="form_pernikahan.php" class="btn btn-light">Pernikahan</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="card text-white bg-dark">
                            <div class="card-body">
                                <h5 class="card-title">Pemakaman</h5>
                                <p class="card-text">Kelola bantuan pemakaman</p>
                                <a href="form_pemakaman.php" class="btn btn-light">Form</a>
                                <a href="list_pemakaman.php" class="btn btn-light">List</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>