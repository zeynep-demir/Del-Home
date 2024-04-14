<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include 'navbar.php';
$conn = new mysqli("localhost", "root", "", "yemeksepetiDB");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $menuId = $_POST['menuId'];
    $menuName = $_POST['menuName'];
    $menuCategory = $_POST['menuCategory'];
    $menuPrice = $_POST['menuPrice'];

    $sql = "INSERT INTO menuTable (menuId,menuName, menuCategory, menuPrice) VALUES ('$menuId','$menuName','$menuCategory','$menuPrice')";

    if ($conn->query($sql) === TRUE) {
        header("Location: admin.php");
    } else {
        echo "Error updating menu: " . $conn->error;
    }

   
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Del-Home Menu Update</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2>Menu Adding</h2>
        <form action="" method="post">
        <div class="form-group">
                <label for="menuId">Menu Id:</label>
                <input type="text" class="form-control" id="menuId" name="menuId"  required>
            </div>
            <div class="form-group">
                <label for="menuName">Menu Name:</label>
                <input type="text" class="form-control" id="menuName" name="menuName"  required>
            </div>
            <div class="form-group">
                <label for="menuCategory">Category:</label>
                <input type="text" class="form-control" id="menuCategory" name="menuCategory"  required>
            </div>
            <div class="form-group">
                <label for="menuPrice">Price:</label>
                <input type="number" class="form-control" id="menuPrice" name="menuPrice" required>
            </div>
         
            <button type="submit" class="btn btn-primary">Add</button>
        </form>

    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>

<?php
$conn->close();
?>