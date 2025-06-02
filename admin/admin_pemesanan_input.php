<?php

require_once 'db.class.php';
$database = new Database();
$conn = $database->getConnection();

// Ambil data jika edit
$order = null;
if (isset($_GET['id'])) {
    $orderId = $_GET['id'];
    $sql = "SELECT * FROM reservasi WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $orderId);
    $stmt->execute();
    $order = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Proses submit form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['order_id'] ?? null;
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $status = $_POST['status'];
    $alamat = $_POST['alamat'];
    $no_telepon = $_POST['no_telepon'];

    if ($id) {
        // Update
        $sql = "UPDATE reservasi SET nama = :nama, email = :email, status = :status, alamat = :alamat, no_telepon = :no_telepon WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':nama' => $nama,
            ':email' => $email,
            ':status' => $status,
            ':alamat' => $alamat,
            ':no_telepon' => $no_telepon,
            ':id' => $id
        ]);
    } else {
        // Insert
        $sql = "INSERT INTO reservasi (nama, email, status, alamat, no_telepon) VALUES (:nama, :email, :status, :alamat, :no_telepon)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':nama' => $nama,
            ':email' => $email,
            ':status' => $status,
            ':alamat' => $alamat,
            ':no_telepon' => $no_telepon
        ]);
    }
    header("Location: admin_pemesanan.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $order ? 'Edit Order' : 'Add New Order'; ?> - Laundry Jogja</title>
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 1200px;
            margin: auto;
            padding: 20px;
        }
        header {
            background-color: #00BFFF;
            padding: 10px 0;
            text-align: center;
            color: #fff;
        }
        h2 {
            color: #00BFFF;
            text-align: center;
            margin-bottom: 30px;
        }
        .form-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            font-weight: bold;
            display: block;
            margin-bottom: 10px;
            color: #333;
        }
        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        .form-group input:focus,
        .form-group select:focus {
            border-color: #00BFFF;
            outline: none;
        }
        .form-group button {
            width: 100%;
            padding: 15px;
            background-color: #00BFFF;
            border: none;
            color: white;
            border-radius: 5px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .form-group button:hover {
            background-color: #00A1C2;
        }
        .back-btn {
            display: inline-block;
            margin-top: 20px;
            background-color: #ccc;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }
        .back-btn:hover {
            background-color: #00BFFF;
        }
        footer {
            background-color: #00BFFF;
            padding: 10px;
            text-align: center;
            color: #fff;
            margin-top: 40px;
        }
        @media (max-width: 768px) {
            .form-container {
                padding: 20px;
            }
        }
    </style>
</head>

<body>

    <header>
        <h1>Laundry Jogja - Admin Panel</h1>
    </header>

    <div class="container">
        <h2><?php echo $order ? 'Edit Order' : 'Add New Order'; ?></h2>

        <div class="form-container">
            <form method="POST" action="">
                <?php if ($order): ?>
                    <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order['id']); ?>">
                <?php endif; ?>

                <div class="form-group">
                    <label for="nama">Customer Name:</label>
                    <input type="text" id="nama" name="nama" value="<?php echo $order ? htmlspecialchars($order['nama']) : ''; ?>" required>
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo $order ? htmlspecialchars($order['email']) : ''; ?>" required>
                </div>

                <div class="form-group">
                    <label for="alamat">Alamat:</label>
                    <input type="text" id="alamat" name="alamat" value="<?php echo $order ? htmlspecialchars($order['alamat']) : ''; ?>" required>
                </div>

                <div class="form-group">
                    <label for="no_telepon">No. Telepon:</label>
                    <input type="text" id="no_telepon" name="no_telepon" value="<?php echo $order ? htmlspecialchars($order['no_telepon']) : ''; ?>" required>
                </div>

                <div class="form-group">
                    <label for="status">Order Status:</label>
                    <select id="status" name="status" required>
                        <option value="Pending" <?php if ($order && $order['status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                        <option value="Completed" <?php if ($order && $order['status'] == 'Completed') echo 'selected'; ?>>Completed</option>
                        <option value="In Progress" <?php if ($order && $order['status'] == 'In Progress') echo 'selected'; ?>>In Progress</option>
                    </select>
                </div>

                <div class="form-group">
                    <button type="submit"><?php echo $order ? 'Update Order' : 'Add Order'; ?></button>
                </div>
            </form>

            <a href="admin_pemesanan.php" class="back-btn">Back to Orders</a>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 Laundry Jogja | Admin Panel</p>
    </footer>

</body>
</html>