<?php

require_once 'db.class.php';
$database = new Database();
$conn = $database->getConnection();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM reservasi WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}

header("Location: admin_pemesanan.php");
exit;
?>