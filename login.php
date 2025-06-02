<?php
session_start();

$error = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $kode_unik = trim($_POST['kode_unik']);  // Kolom untuk kode unik admin

    // Cek login untuk admin
    if ($username === 'admin' && $password === 'adminpassword' && $kode_unik === '555') {
        $_SESSION['admin_logged_in'] = true;  // Admin berhasil login
        header("Location: admin_pesanan.php");  // Redirect ke halaman admin
        exit();
    }

    // Koneksi ke database untuk login user biasa
    require_once 'db.class.php';
    $database = new Database();
    $conn = $database->getConnection();

    try {
        // Ambil data user dari tabel 'users'
        $sql = "SELECT * FROM users WHERE username = :username LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if (password_verify($password, $user['password'])) {
                $_SESSION['logged_in'] = true;
                $_SESSION['username'] = $user['username'];
                header("Location: index.php");  // Redirect ke halaman user
                exit();
            } else {
                $error = "Username atau password salah!";
            }
        } else {
            $error = "Username atau password salah!";
        }
    } catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laundry Jogja - Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
        }

        .login-container {
            max-width: 400px;
            margin: 80px auto;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .login-container h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #00BFFF;
            /* Changed to blue */
        }

        .login-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #00BFFF;
            /* Changed to blue */
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .btn-login {
            width: 100%;
            background-color: #00BFFF;
            /* Changed to blue */
            color: #fff;
            border: none;
            padding: 12px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }

        .btn-login:hover {
            background-color: #ADD8E6;
            /* Lighter blue */
            color: #333;
        }

        .error {
            color: red;
            margin-bottom: 15px;
            text-align: center;
        }

        .user-admin-options {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .user-admin-options label {
            flex: 1;
            text-align: center;
            padding: 10px;
            background-color: #00BFFF;
            /* Changed to blue */
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }

        .user-admin-options label:hover {
            background-color: #ADD8E6;
            /* Lighter blue */
        }

        p.register-link {
            margin-top: 10px;
            text-align: center;
        }
    </style>

</head>

<body>
    <div class="login-container">
        <h1>Login</h1>
        <h2>Laundry Jogja</h2>



        <?php if (!empty($error)): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <!-- Pilihan Admin atau User -->
            <div class="user-admin-options">
                <label for="user" id="user">User</label>
                <label for="admin" id="admin">Admin</label>
            </div>

            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" placeholder="Masukkan username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" placeholder="Masukkan password" required>
            </div>
            <!-- Kolom untuk kode unik admin -->
            <div class="form-group" id="kode_unik_group" style="display: none;">
                <label for="kode_unik">Kode Unik (Admin Only):</label>
                <input type="text" name="kode_unik" id="kode_unik">
            </div>

            <button type="submit" class="btn-login">Login</button>
        </form>

        <p class="register-link">
            Belum punya akun? <a href="register.php">Daftar di sini</a>.
        </p>
    </div>

    <script>
        const userLabel = document.getElementById('user');
        const adminLabel = document.getElementById('admin');
        const kodeUnikGroup = document.getElementById('kode_unik_group');

        userLabel.addEventListener('click', () => {
            kodeUnikGroup.style.display = 'none';
        });

        adminLabel.addEventListener('click', () => {
            kodeUnikGroup.style.display = 'block';
        });
    </script>
</body>

</html>