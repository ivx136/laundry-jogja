<?php

require_once 'db.class.php';
$database = new Database();
$conn = $database->getConnection();

$user = null;
if (isset($_GET['id'])) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->execute([':id' => $_GET['id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['user_id'] ?? null;
    $username = $_POST['username'];
    $role = $_POST['role'];
    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    }

    if ($id) {
        // Update
        if (!empty($_POST['password'])) {
            $stmt = $conn->prepare("UPDATE users SET username=:username, password=:password, role=:role WHERE id=:id");
            $stmt->execute([
                ':username' => $username,
                ':password' => $password,
                ':role' => $role,
                ':id' => $id
            ]);
        } else {
            $stmt = $conn->prepare("UPDATE users SET username=:username, role=:role WHERE id=:id");
            $stmt->execute([
                ':username' => $username,
                ':role' => $role,
                ':id' => $id
            ]);
        }
    } else {
        // Insert
        $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (:username, :password, :role)");
        $stmt->execute([
            ':username' => $username,
            ':password' => $password,
            ':role' => $role
        ]);
    }
    header("Location: admin_user.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $user ? 'Edit' : 'Tambah' ?> User/Admin</title>
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 420px;
            margin: 50px auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 12px rgba(0,0,0,0.08);
            padding: 32px 28px 24px 28px;
        }
        h2 {
            color: #00BFFF;
            text-align: center;
            margin-bottom: 28px;
        }
        .form-group {
            margin-bottom: 18px;
        }
        label {
            font-weight: 500;
            color: #333;
            display: block;
            margin-bottom: 7px;
        }
        input[type="text"], input[type="password"], select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
            background: #f9f9f9;
            transition: border-color 0.2s;
        }
        input[type="text"]:focus, input[type="password"]:focus, select:focus {
            border-color: #00BFFF;
            outline: none;
        }
        .info {
            font-size: 13px;
            color: #888;
            margin-top: 3px;
        }
        button[type="submit"] {
            width: 100%;
            padding: 13px;
            background: #00BFFF;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
            transition: background 0.2s;
        }
        button[type="submit"]:hover {
            background: #0090c7;
        }
        .back-btn {
            display: block;
            text-align: center;
            margin-top: 18px;
            color: #00BFFF;
            text-decoration: none;
            font-size: 15px;
            font-weight: 500;
        }
        .back-btn:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2><?= $user ? 'Edit' : 'Tambah' ?> User/Admin</h2>
        <form method="POST">
            <?php if ($user): ?>
                <input type="hidden" name="user_id" value="<?= htmlspecialchars($user['id']) ?>">
            <?php endif; ?>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" value="<?= $user ? htmlspecialchars($user['username']) : '' ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Password <?= $user ? '<span class="info">(Kosongkan jika tidak ingin ganti password)</span>' : '' ?></label>
                <input type="password" id="password" name="password" <?= $user ? '' : 'required' ?>>
            </div>
            <div class="form-group">
                <label for="role">Role</label>
                <select id="role" name="role" required>
                    <option value="admin" <?= $user && $user['role']=='admin' ? 'selected' : '' ?>>Admin</option>
                    <option value="user" <?= $user && $user['role']=='user' ? 'selected' : '' ?>>User</option>
                </select>
            </div>
            <button type="submit"><?= $user ? 'Update' : 'Tambah' ?></button>
        </form>
        <a href="admin_user.php" class="back-btn">Kembali</a>
    </div>
</body>
</html>