<?php

require_once 'db.class.php';
$database = new Database();
$conn = $database->getConnection();

// Hapus user
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM users WHERE id = :id");
    $stmt->execute([':id' => $id]);
    header("Location: admin_user.php");
    exit;
}

// Ambil semua user
$stmt = $conn->query("SELECT * FROM users");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen User - Laundry Jogja</title>
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 900px;
            margin: 40px auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.08);
            padding: 32px 28px 24px 28px;
        }
        h2 {
            color: #00BFFF;
            text-align: center;
            margin-bottom: 28px;
        }
        .add-btn {
            display: inline-block;
            background: #00BFFF;
            color: #fff;
            padding: 10px 22px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 18px;
            transition: background 0.2s;
        }
        .add-btn:hover {
            background: #0090c7;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 18px;
        }
        th, td {
            padding: 13px 10px;
            border-bottom: 1px solid #e0e0e0;
            text-align: left;
        }
        th {
            background: #00BFFF;
            color: #fff;
            font-weight: 500;
        }
        tr:hover {
            background: #f1f8fd;
        }
        .action-btn {
            background: #00BFFF;
            color: #fff;
            padding: 6px 16px;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            font-size: 15px;
            margin-right: 5px;
            transition: background 0.2s;
        }
        .action-btn:hover {
            background: #0090c7;
        }
        .delete-btn {
            background: #e74c3c;
        }
        .delete-btn:hover {
            background: #c0392b;
        }
        .back-btn {
            display: inline-block;
            background: #ccc;
            color: #333;
            padding: 8px 18px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 15px;
            margin-top: 10px;
            transition: background 0.2s;
        }
        .back-btn:hover {
            background: #00BFFF;
            color: #fff;
        }
        @media (max-width: 700px) {
            .container {
                padding: 10px;
            }
            th, td {
                padding: 8px 4px;
                font-size: 14px;
            }
            .add-btn, .back-btn {
                font-size: 14px;
                padding: 8px 12px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Manajemen User/Admin</h2>
        <a href="admin_user_input.php" class="add-btn">+ Tambah User/Admin</a>
        <table>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?= htmlspecialchars($user['id']) ?></td>
                <td><?= htmlspecialchars($user['username']) ?></td>
                <td><?= htmlspecialchars($user['role']) ?></td>
                <td>
                    <a href="admin_user_input.php?id=<?= $user['id'] ?>" class="action-btn">Edit</a>
                    <a href="admin_user.php?delete=<?= $user['id'] ?>" class="action-btn delete-btn" onclick="return confirm('Yakin hapus user ini?')">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <a href="admin_dashboard.php" class="back-btn">Kembali ke Dashboard</a>
    </div>
</body>
</html>