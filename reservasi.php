<?php

session_start();
require_once 'db.class.php';

$db = new Database();
$conn = $db->getConnection();

$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama']);
    $no_telepon = trim($_POST['no_telepon']);
    $email = trim($_POST['email']);
    $alamat = trim($_POST['alamat']);

    if (empty($nama) || empty($no_telepon) || empty($email) || empty($alamat)) {
        header("Location: reservasi.php?msg=reservasi_gagal");
        exit();
    }

    try {
        $stmt = $conn->prepare("INSERT INTO reservasi (nama, no_telepon, email, alamat, status) VALUES (:nama, :no_telepon, :email, :alamat, :status)");
        $stmt->execute([
            ':nama' => $nama,
            ':no_telepon' => $no_telepon,
            ':email' => $email,
            ':alamat' => $alamat,
            ':status' => 'Pending'
        ]);
        header("Location: reservasi.php?msg=reservasi_sukses");
        exit();
    } catch (PDOException $e) {
        error_log($e->getMessage());
        header("Location: reservasi.php?msg=reservasi_gagal");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Form Reservasi - Laundry Jogja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        html, body { height: 100%; margin: 0; padding: 0; }
        body { display: flex; flex-direction: column; background-color: #f8f9fa; font-family: 'Roboto', sans-serif; }
        main { flex: 1; }
        header { background-color: #00BFFF; padding: 10px 0; }
        .header-container { display: flex; align-items: center; justify-content: center; max-width: 1200px; margin: 0 auto; padding: 0 15px; }
        .header-container .logo img { height: 50px; width: auto; }
        .form-container { max-width: 600px; margin: 40px auto; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1); padding: 30px; position: relative; }
        .title { text-align: center; margin-bottom: 1.5rem; color: #00BFFF; font-weight: bold; }
        .btn-pink { background-color: #00BFFF; border-color: #00BFFF; }
        .btn-pink:hover { background-color: #ADD8E6; border-color: #ADD8E6; }
        footer { background-color: #00BFFF; text-align: center; color: #fff; padding: 15px 0; }
        .footer-container { max-width: 1200px; margin: 0 auto; padding: 0 15px; }
        .notification { position: absolute; top: 600px; right: 150px; padding: 10px 20px; border-radius: 5px; font-size: 14px; box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15); z-index: 999; width: 300px; max-width: 400px; text-align: center; opacity: 0; transform: translateY(-20px); transition: opacity 0.5s ease, transform 0.5s ease; }
        .notification-success { background-color: #C8E6C9; color: #256029; }
        .notification-error { background-color: #F8D7DA; color: #721C24; }
        .notification-show { opacity: 1; transform: translateY(0); }
        .notification-hide { opacity: 0; transform: translateY(-20px); }
        @media (max-width: 768px) {
            .notification { width: 90%; left: 50%; right: auto; transform: translateX(-50%); }
        }
        .form-group { margin-bottom: 1rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; font-weight: 600; }
        .form-group input, .form-group textarea { width: 100%; padding: 0.5rem; border-radius: 4px; border: 1px solid #ced4da; }
        .btn { padding: 0.75rem; font-size: 1rem; cursor: pointer; }
    </style>
</head>

<body>
    <main>
        <div class="form-container">
            <h2 class="title">Form Reservasi</h2>
            <div class="notification-box">
                <?php
                if (isset($_GET['msg'])) {
                    switch ($_GET['msg']) {
                        case 'reservasi_sukses':
                            echo '<div class="notification notification-success">
                                  Reservasi berhasil dikirim!
                                  <span class="close-btn" style="cursor:pointer; float:right;">&times;</span>
                                </div>';
                            break;
                        case 'reservasi_gagal':
                            echo '<div class="notification notification-error">
                                  Reservasi gagal dikirim! Silakan coba lagi.
                                  <span class="close-btn" style="cursor:pointer; float:right;">&times;</span>
                                </div>';
                            break;
                    }
                }
                ?>
            </div>
            <form action="reservasi.php" method="POST">
                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" id="nama" name="nama" placeholder="Masukkan Nama Anda" required />
                </div>
                <div class="form-group">
                    <label for="no_telepon">No Telepon</label>
                    <input type="tel" id="no_telepon" name="no_telepon" placeholder="Masukkan No Telepon Anda" required />
                </div>
                <div class="form-group">
                    <label for="email">Alamat Email</label>
                    <input type="email" id="email" name="email" placeholder="Masukkan Email Anda" required />
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea id="alamat" name="alamat" rows="3" placeholder="Masukkan Alamat Anda" required></textarea>
                </div>
                <button type="submit" class="btn btn-pink w-100">
                    Kirim
                </button>
            </form>
        </div>
    </main>
    <footer>
        <div class="footer-container">
            <p>&copy; 2020 Laundry Jogja</p>
        </div>
    </footer>
    <script>
        window.addEventListener('load', () => {
            const notifications = document.querySelectorAll('.notification');
            notifications.forEach(notification => {
                setTimeout(() => {
                    notification.classList.add('notification-show');
                }, 100);
                setTimeout(() => {
                    notification.classList.add('notification-hide');
                    notification.addEventListener('transitionend', () => {
                        notification.style.display = 'none';
                    });
                }, 5000);
                const closeBtn = notification.querySelector('.close-btn');
                if (closeBtn) {
                    closeBtn.addEventListener('click', () => {
                        notification.classList.add('notification-hide');
                        notification.addEventListener('transitionend', () => {
                            notification.style.display = 'none';
                        });
                    });
                }
            });
        });
    </script>
</body>
</html>