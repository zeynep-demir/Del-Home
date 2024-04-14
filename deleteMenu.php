<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = new mysqli("localhost", "root", "", "yemeksepetiDB");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $menuId = $_POST['menuId'] ?? 0;

    $sql = "DELETE FROM menuTable WHERE menuId = $menuId";
    $result = $conn->query($sql);

    if ($result === false) {
        die("Query failed: " . $conn->error);
    }
    header("Location: admin.php");

    $conn->close();
}
?>
