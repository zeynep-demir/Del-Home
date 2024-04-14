<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

include "navbar.php";
$email = $_SESSION["email"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cardNumber = $_POST['cardNumber'];
    $expirationDate = $_POST['expirationDate'];
    $cvv = $_POST['cvv'];
    $cardHolderFirstName = $_POST['firstname'];
    $cardHolderLastName = $_POST['lastname'];

    $randomAmount = rand(100, 1000); 

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "yemeksepetiDB";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Bağlantı hatası: " . $conn->connect_error);
    }
    
    $sql = "UPDATE CustomerTable SET firstname= '$cardHolderFirstName',lastname= '$cardHolderLastName', cardNumber = '$cardNumber', expirationDate = '$expirationDate', cvv = '$cvv', money = $randomAmount WHERE email = '$email'";
if(strlen($cardNumber)==16){
    echo "okey";
}
    if ($conn->query($sql) === TRUE) {
        header("Location: profile.php");

    } else {
        echo "Hata oluştu: " . $conn->error;
    }

    $conn->close();
}
?>
