<?php
session_start();

$conn = new mysqli("localhost", "root", "", "yemeksepetiDB");

if ($conn->connect_error) {
    die("Veritabanı bağlantısında hata: " . $conn->connect_error);
}

if (!isset($_SESSION["email"])) {
    header("Location: login.php"); 
    exit();
}

$email = $_SESSION["email"];

$query = "SELECT * FROM CustomerTable WHERE email='$email'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $cardNumber = $row["cardNumber"]; 
    $cardHolderFirstName = $row["firstname"]; 
    $cardHolderLastName = $row["lastname"]; 
    $expirationDate = $row["expirationDate"]; 
    $cvv = $row["cvv"]; 
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5" style="margin-bottom: 20px; display: flex; flex-direction: column; align-items: center;">
        <form method="post" action="payment_process.php" style="min-width: 350px;">
            <div class="form-group">
                <label for="cardNumber">Credit Card Number:</label>
                <input type="text" class="form-control" id="cardNumber" name="cardNumber" value="<?php echo isset($cardNumber) ? $cardNumber : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="cardNumber">Name Surname:</label>
                <input type="text" class="form-control" id="cardHolderName" name="cardHolderName" value="<?php echo (isset($cardHolderFirstName) && isset($cardHolderLastName)) ? $cardHolderFirstName . " " . $cardHolderLastName : ''; ?>" required readonly>
                <input type="hidden" class="form-control" id="firstname" name="firstname" value="<?php echo (isset($cardHolderFirstName) ) ? $cardHolderFirstName : ''; ?>" required readonly>
                <input type="hidden" class="form-control" id="lastname" name="lastname" value="<?php echo ( isset($cardHolderLastName)) ? $cardHolderLastName : ''; ?>" required readonly>
            </div>
            <div class="form-group">
                <label for="expirationDate">Expration Date:</label>
                <input type="text" class="form-control" id="expirationDate" name="expirationDate" placeholder="MM/YYYY" value="<?php echo isset($expirationDate) ? $expirationDate : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="cvv">CVV:</label>
                <input type="text" class="form-control" id="cvv" name="cvv" value="<?php echo isset($cvv) ? $cvv : ''; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</body>
</html>
