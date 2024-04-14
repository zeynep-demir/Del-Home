<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = new mysqli("localhost", "root", "", "yemeksepetiDB");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $orderId = $_POST['orderId'] ?? 0;

    $sql = "DELETE FROM cartTable WHERE orderId = $orderId";
    $result = $conn->query($sql);

    if ($result === false) {
        die("Query failed: " . $conn->error);
    }
    header("Location: cart.php");

    $conn->close();
}
?>
