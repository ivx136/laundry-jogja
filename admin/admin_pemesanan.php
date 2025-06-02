<?php
session_start();

require_once 'db.class.php';
$database = new Database();
$conn = $database->getConnection();

// Ambil daftar pesanan
$sql = "SELECT * FROM reservasi";
$stmt = $conn->prepare($sql);
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders - Laundry Jogja</title>
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
        .table-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        th, td {
            padding: 14px 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #00BFFF;
            color: #fff;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .action-btn {
            background-color: #00BFFF;
            color: #fff;
            padding: 7px 16px;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            font-size: 15px;
            margin-right: 5px;
            transition: background-color 0.3s;
        }
        .action-btn:hover {
            background-color: #00A1C2;
        }
        .delete-btn {
            background-color: #e74c3c;
        }
        .delete-btn:hover {
            background-color: #c0392b;
        }
        .add-btn {
            display: inline-block;
            margin-bottom: 20px;
            background-color: #00BFFF;
            color: #fff;
            padding: 12px 24px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        .add-btn:hover {
            background-color: #00A1C2;
        }
        footer {
            background-color: #00BFFF;
            padding: 10px;
            text-align: center;
            color: #fff;
            margin-top: 40px;
        }
        @media (max-width: 768px) {
            .table-container {
                padding: 15px;
            }
            th, td {
                padding: 10px 5px;
            }
        }
    </style>
</head>
<body>

    <header>
        <h1>Laundry Jogja - Admin Panel</h1>
    </header>

    <div class="container">
        <h2>Manage Orders</h2>
        <a href="admin_pemesanan_input.php" class="add-btn">+ Add New Order</a>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($orders) > 0): ?>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($order['id']); ?></td>
                                <td><?php echo htmlspecialchars($order['nama']); ?></td>
                                <td><?php echo htmlspecialchars($order['email']); ?></td>
                                <td><?php echo htmlspecialchars($order['status']); ?></td>
                                <td>
                                    <a href="admin_pemesanan_input.php?id=<?php echo $order['id']; ?>" class="action-btn">Edit</a>
                                    <a href="delete_order.php?id=<?php echo $order['id']; ?>" class="action-btn delete-btn" onclick="return confirm('Are you sure you want to delete this order?')">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" style="text-align:center;">No orders found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 Laundry Jogja | Admin Panel</p>
    </footer>

</body>
</html>