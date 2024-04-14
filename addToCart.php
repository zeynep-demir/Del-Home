<?php
session_start();
$email = $_SESSION["email"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $conn = new mysqli("localhost", "root", "", "yemeksepetiDB");
    $orderId = $_POST["order_id"];
    $orderName = $_POST["order_name"];
    $orderQuantity = $_POST["quantity"];
    $orderPrice = $_POST["price"];
    $orderCategory = $_POST["order_category"];
    echo $orderName;
    $checkQuery = "SELECT * FROM cartTable WHERE orderId='$orderId'";
    $result = $conn->query($checkQuery);


if ($result->num_rows > 0) {
    $found = false;
    while ($row = $result->fetch_assoc()) {
        if ($row['ordererEmail'] == $email) {
            $found = true;
            $currentQuantity = $row["orderQuantity"];
            $newQuantity = $currentQuantity + $orderQuantity;

            $updateQuery = "UPDATE cartTable SET orderQuantity='$newQuantity' WHERE orderId='$orderId' and ordererEmail='$email'";
            
            if ($conn->query($updateQuery) === TRUE) {
                echo "Quantity updated successfully";
                if ($row['orderCategory'] == "Dessert") {
                    header("Location: desserts.php");
                } else {
                    header("Location: maincourse.php");
                }
            } else {
                echo "Error updating quantity: " . $conn->error;
            }
        }
    }

    if (!$found) {
        $insertQuery = "INSERT INTO cartTable (ordererEmail,orderId, orderName,orderCategory, orderQuantity, orderPrice) VALUES ('$email','$orderId','$orderName','$orderCategory','$orderQuantity', '$orderPrice')";

        if ($conn->query($insertQuery) === TRUE) {
            echo "Registration successful";
            if ($row['orderCategory'] == "Dessert") {
                header("Location: desserts.php");
            } else {
                header("Location: maincourse.php");
            }
        } else {
            echo "Error inserting data: " . $conn->error;
        }
    }
} else {
    $insertQuery = "INSERT INTO cartTable (ordererEmail,orderId, orderName,orderCategory, orderQuantity, orderPrice) VALUES ('$email','$orderId','$orderName','$orderCategory','$orderQuantity', '$orderPrice')";

    if ($conn->query($insertQuery) === TRUE) {
        echo "Registration successful";
        if ($row['orderCategory'] == "Dessert") {
            header("Location: desserts.php");
        } else {
            header("Location: maincourse.php");
        }
    } else {
        echo "Error inserting data: " . $conn->error;
    }
}



    $conn->close();
}
?>
