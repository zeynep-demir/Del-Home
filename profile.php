<?php
include "navbar.php";
session_start();

$conn = new mysqli("localhost", "root", "", "yemeksepetiDB");

if ($conn->connect_error) {
    die("Veritabanı bağlantısında hata: " . $conn->connect_error);
}
$email = $_SESSION["email"];
$query = "SELECT * FROM CustomerTable WHERE email='$email'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $firstName = $row["firstname"];
    $lastName = $row["lastname"];
    $password = $row["password"];

    
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST["firstname"];
    $lastName = $_POST["lastname"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "UPDATE CustomerTable SET firstname='$firstName', lastname='$lastName', password='$password' WHERE email='$email'";

    if ($conn->query($sql) === TRUE) {
        $message = "Profil bilgileri güncellendi.";
    } else {
        $message = "Hata: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Del - Home</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<?php if (isset($message)) : ?>
            <div class="alert alert-success" role="alert">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
    <div class="container mt-5" style="display: flex; flex-direction: row; align-items: center;">

        

        <form style="min-width: 350px; margin-left: 100px" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="firstName">Name:</label>
                <input type="text" class="form-control" name="firstname" value="<?php echo $firstName; ?>" required>
            </div>

            <div class="form-group">
                <label for="lastName">Surname:</label>
                <input type="text" class="form-control" name="lastname" value="<?php echo $lastName; ?>" required>
            </div>

            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="email" class="form-control" name="email" value="<?php echo $email; ?>" required readonly>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" name="password" value="<?php echo $password; ?>" required>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
        <?php
    include "cardInfo.php";
    ?>
    </div>
    

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
