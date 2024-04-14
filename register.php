<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include 'navbarLoginRegister.php';

$conn = new mysqli("localhost", "root", "", "yemeksepetiDB");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "INSERT INTO CustomerTable (firstName, lastName, email, password) VALUES ('$firstName','$lastName','$email', '$password')";
    if ($conn->query($sql) === TRUE) {
        echo "Registration successful";
        header("Location: login.php");

    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
