<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laundry Jogja</title>
    <!-- Link ke Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <!-- Pastikan file styles.css Anda sudah benar path-nya -->
    <link rel="stylesheet" href="css/styles.css">
</head>

<style>
    .logo {
        max-width: none;
        margin-left: 80px;
        display: flex;
        align-items: center;
    }

    .logo img {
        height: 150px;
        width: auto;
        display: block;
    }

    .hero-image {
        width: 100%;
        max-width: 500px;
        text-align: center;
    }

    @media (max-width: 768px) {
        .logo img {
            height: 60px;
            /* Kecilkan logo di layar lebih kecil */
        }
    }
</style>

<body>
    <!-- Header -->
    <header>
        <div class="container header-container">
            <div class="logo">
                <img src="images/logo4.png" alt="Logo Website">
            </div>
            <nav>
                <ul class="nav-links">
                    <li><a href="#beranda">Beranda</a></li>
                    <li><a href="#tentang">Tentang</a></li>
                    <li><a href="#layanan">Layanan</a></li>
                    <li><a href="#tanggapan">Tanggapan</a></li>
                    <!-- Menu Logout di kanan -->
                    <li><a href="logout.php" style="margin-left: 20px;">Logout</a></li>
                </ul>
            </nav>
    </header>

    <!-- Hero Section -->
    <section class="hero" id="beranda">
        <div class="container hero-container">
            <div class="hero-text">
                <h1>Kilau Sempurna Setiap Hari</h1>
                <h2>Baju Bersih, Mood Happy</h2>
                <p>Instant Glowing untuk Pakaian Bebas Noda dan Bau</p>
                <a href="reservasi.php" class="btn">RESERVASI DISINI!</a>
            </div>
            <div class="hero-image">
                <img src="images/tampilan1.png" alt="Hero Image">
            </div>
        </div>
    </section>

    <!-- Tentang Kami -->
    <section class="about" id="tentang">
        <div class="container about-container">
            <h2>Tentang Kami</h2>
            <div class="about-content">
                <img src="images/laundry.jpg" alt="Tentang Kami" class="about-image">
                <p>
                    Laundry Jogja adalah layanan laundry modern yang siap membantu Anda menjaga kebersihan
                    dan kenyamanan pakaian setiap hari. Dengan peralatan cuci terkini, tenaga profesional, serta layanan
                    cepat dan berkualitas, kami memastikan setiap cucian Anda kembali dalam kondisi bersih, wangi, dan
                    rapi.</p>

                </p>
            </div>
        </div>
    </section>

    <!-- Layanan -->
    <section class="services" id="layanan">
        <div class="container services-container">
            <h2>Layanan Kami</h2>
            <div class="services-grid">
                <div class="service-item">
                    <img src="images/baju.jpg" alt="Layanan 1" class="service-image">
                    <h3>Paket Pakaian</h3>
                    <p>
                        Layanan pencucian pakaian dengan metode modern yang memastikan pakaian bersih maksimal.
                        Dengan teknologi pencucian terkini, pakaian Anda akan bebas dari noda membandel
                        dan tetap lembut seperti baru.

                    </p>
                </div>
                <div class="service-item">
                    <img src="images/sepatu.jpg" alt="Layanan 2" class="service-image">
                    <h3>Paket Sepatu</h3>
                    <p>
                        Layanan khusus untuk membersihkan sepatu sneakers dari kotoran dan noda.
                        Menggunakan peralatan dan bahan khusus, sepatu Anda akan kembali bersih dan tampak seperti baru,
                        tanpa merusak bahan aslinya.</p>

                    </p>
                </div>
                <div class="service-item">
                    <img src="images/celana.jpg" alt="Layanan 3" class="service-image">
                    <h3>Paket Denim</h3>
                    <p>
                        Layanan pencucian dan perawatan khusus untuk bahan denim seperti celana dan jaket jeans.
                        Proses ini menjaga warna asli, mengurangi kerusakan serat, dan membuat denim Anda tetap
                        awet serta nyaman dipakai.</p>

                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Tanggapan -->
    <section class="contact" id="tanggapan">
        <div class="container contact-container">
            <!-- Kotak Kosong untuk Notifikasi -->
            <div class="notification-box">
                <!-- Notifikasi -->
                <?php if (isset($_GET['msg'])): ?>
                    <?php if ($_GET['msg'] === 'tanggapan_sukses'): ?>
                        <div class="notification notification-success">
                            Tanggapan berhasil dikirim!
                            <span class="close-btn">&times;</span>
                        </div>
                    <?php elseif ($_GET['msg'] === 'tanggapan_gagal'): ?>
                        <div class="notification notification-error">
                            Tanggapan gagal dikirim!
                            <span class="close-btn">&times;</span>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>

            <form action="tanggapan.php" method="POST">
                <!-- Field Nama -->
                <div class="form-group">
                    <label for="nama">Nama:</label>
                    <input type="text" id="nama" name="nama" required>
                </div>
                <!-- Field Email -->
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <!-- Field Pesan -->
                <div class="form-group">
                    <label for="pesan">Pesan:</label>
                    <textarea id="pesan" name="pesan" rows="5" required></textarea>
                </div>
                <button type="submit" class="btn">Kirim</button>
            </form>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container footer-container">
            <p>&copy; 2020 Laundry Jogja</p>
        </div>
    </footer>

    <!-- JavaScript untuk Menghilangkan Notifikasi secara Otomatis dan Hapus Parameter msg -->
    <script>
        window.addEventListener('load', () => {
            const notifications = document.querySelectorAll('.notification');
            notifications.forEach(notification => {
                // Tambahkan kelas show untuk animasi masuk
                setTimeout(() => {
                    notification.classList.add('notification-show');
                }, 100); // Delay kecil untuk memastikan transition berjalan

                // Atur waktu sebelum notifikasi mulai menghilang
                setTimeout(() => {
                    notification.classList.add('notification-hide');
                    // Setelah animasi keluar selesai, sembunyikan elemen
                    notification.addEventListener('transitionend', () => {
                        notification.style.display = 'none';
                    });
                }, 5000); // 5 detik

                // Tambahkan event listener untuk tombol tutup
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

            // Hapus parameter msg dari URL
            const url = new URL(window.location.href);
            if (url.searchParams.has('msg')) {
                url.searchParams.delete('msg'); // Hapus parameter msg
                window.history.replaceState(null, '', url.toString()); // Update URL tanpa refresh
            }
        });
    </script>
</body>

</html>