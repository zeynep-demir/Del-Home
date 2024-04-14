<?php
include "navbar.php";

session_start();

$conn = new mysqli("localhost", "root", "", "yemeksepetiDB");

if ($conn->connect_error) {
    die("Veritabanı bağlantısında hata: " . $conn->connect_error);
}

if (isset($_SESSION["email"])) {
    $email = $_SESSION["email"];

    $query = "SELECT money FROM CustomerTable WHERE email='$email'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $userMoney = $row["money"];
        $userId = $row["id"];
    } else {
        echo "Kullanıcı bilgileri bulunamadı!";
        exit();
    }
} else {
    echo "Kullanıcı oturumu bulunamadı!";
    exit();
}

if (isset($_POST['submit'])) {
    $totalPrice = $_POST['totalPrice'];

    if ($userMoney >= $totalPrice) {
        $newMoney = $userMoney - $totalPrice;
    

        $updateQuery = "UPDATE CustomerTable SET money='$newMoney' WHERE email='$email'";
        if ($conn->query($updateQuery) === TRUE) {
            $message = "İşlem onaylandı. Yeni bakiye: " . $newMoney;
            $deleteCartQuery = "DELETE FROM cartTable WHERE ordererEmail='$email'";
            if ($conn->query($deleteCartQuery) === TRUE) {
                $message = "Order Completed";
            } else {
                $message = "Error: " . $conn->error;
            }

        } else {
            $error = "Error: " . $conn->error;
        }
    } else {
        $error = "Insufficient Funds!" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<?php if (isset($message)) : ?>
            <div class="alert alert-success" role="alert">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        <?php if (isset($error)) : ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
    <div class="container mt-5" style="margin-bottom: 20px; display: flex; flex-direction: column; align-items: center;">
        <form method="post"action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <!-- <div class="form-group">
                <label for="userMoney">Bakiye:</label>
                <input type="text" class="form-control" id="userMoney" name="userMoney" value="<?php echo isset($userMoney) ? $userMoney : 0; ?>" readonly>
            </div> -->

            <div class="form-group">
                <label for="totalPrice">Total:</label>
                <input type="text" class="form-control" id="totalPrice" name="totalPrice" value="<?php echo isset($_POST['totalPrice']) ? $_POST['totalPrice'] : 0; ?>" readonly>
            </div>

            <button type="submit" name="submit" class="btn btn-primary">Confirm Order</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
