<?php


session_start();
require_once 'db.class.php';
$database = new Database();
$conn = $database->getConnection();

// Ambil jumlah pesanan
$stmt = $conn->query("SELECT COUNT(*) FROM reservasi");
$total_pesanan = $stmt->fetchColumn();

// Ambil jumlah admin
$stmt = $conn->query("SELECT COUNT(*) FROM users WHERE role = 'admin'");
$total_admin = $stmt->fetchColumn();

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - Laundry Jogja</title>
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .container {
            max-width: 900px;
            margin: 40px auto;
            padding: 30px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.08);
            flex: 1 0 auto;
        }
        header {
            background-color: #00BFFF;
            padding: 10px 0;
            text-align: center;
            color: #fff;
        }
        .stats-grid {
            display: flex;
            gap: 30px;
            justify-content: center;
            margin-bottom: 35px;
        }
        .stat-card {
            background: #eaf6fb;
            border-radius: 8px;
            padding: 25px 40px;
            text-align: center;
            min-width: 180px;
            box-shadow: 0 2px 8px rgba(0,191,255,0.07);
        }
        .stat-card h3 {
            margin: 0 0 10px 0;
            color: #00BFFF;
            font-size: 18px;
        }
        .stat-card .stat-value {
            font-size: 32px;
            font-weight: bold;
            color: #222;
        }
        .menu-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            justify-content: center;
            margin-top: 30px;
        }
        .menu-card {
            background: #f8f8f8;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.07);
            padding: 30px 40px;
            text-align: center;
            min-width: 220px;
            transition: box-shadow 0.2s;
        }
        .menu-card:hover {
            box-shadow: 0 4px 16px rgba(0,191,255,0.15);
        }
        .menu-card a {
            display: block;
            color: #00BFFF;
            font-size: 22px;
            font-weight: bold;
            text-decoration: none;
            margin-bottom: 10px;
        }
        .menu-card p {
            color: #555;
            font-size: 15px;
        }
        footer {
            background-color: #00BFFF;
            padding: 10px;
            text-align: center;
            color: #fff;
            margin-top: 0;
            flex-shrink: 0;
        }
        html, body {
            height: 100%;
        }



        @media (max-width: 768px) {
            .container {
                padding: 10px;
            }
            .stats-grid, .menu-grid {
                flex-direction: column;
                gap: 15px;
            }
            .menu-card, .stat-card {
                min-width: unset;
                padding: 20px 10px;
            }
        }

    </style>
</head>
<body>
    <header>
        <h1>Laundry Jogja - Admin Dashboard</h1>
    </header>
    <div class="container">

        <!-- Statistik -->
        <div class="stats-grid">
            <div class="stat-card">
                <h3>Jumlah Pesanan</h3>
                <div class="stat-value"><?= $total_pesanan ?></div>
            </div>
            <div class="stat-card">
                <h3>Jumlah Admin</h3>
                <div class="stat-value"><?= $total_admin ?></div>
            </div>
        </div>

        <div class="menu-grid">
            <div class="menu-card">
                <a href="admin_pemesanan.php">Manajemen Pesanan</a>
                <p>Lihat, tambah, edit, dan hapus data pesanan laundry.</p>
            </div>
            <div class="menu-card">
                <a href="admin_user.php">Manajemen User/Admin</a>
                <p>Kelola akun user dan admin aplikasi.</p>
            </div>
            <!-- Tambahkan menu lain sesuai tabel Anda -->
        </div>
    </div>
    <footer>
        <p>&copy; 2025 Laundry Jogja | Admin Panel</p>
    </footer>
</body>
</html>