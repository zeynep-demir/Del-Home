<?php
include 'navbar.php';
session_start();

$conn = new mysqli("localhost", "root", "", "yemeksepetiDB");

if ($conn==false) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM CustomerTable WHERE email='$email' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $_SESSION["email"] = $email;
        header("Location: mainmenu.php");
    } else {
echo '<script>alert("Invalid email or password!") </script>';
        
        header("Location: index.html");
        
    }
}

$conn->close();
?>
