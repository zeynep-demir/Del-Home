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

    $sqlUpdate = "UPDATE menuTable SET menuName='$menuName', menuCategory='$menuCategory', menuPrice=$menuPrice WHERE menuId=$menuId";

    if ($conn->query($sqlUpdate) === TRUE) {
        $message = "Menu updated successfully.";
    } else {
        $message = "Error: " . $conn->error;
    }

   
}

$menuId = $_GET['id'];
$sqlSelect = "SELECT * FROM menuTable WHERE menuId=$menuId";
$resultSelect = $conn->query($sqlSelect);

if ($resultSelect === false) {
    die("Query failed: " . $conn->error);
}

$rowSelect = $resultSelect->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Del - Home - Menu Updating</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
<?php if (isset($message)) : ?>
            <div class="alert alert-success" role="alert">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
    <div class="container mt-5">
        <h2>Menu Updating</h2>
        <form action="" method="post">
            <input type="hidden" name="menuId" value="<?= $rowSelect['menuId'] ?>">
            <div class="form-group">
                <label for="menuName">Menu Name:</label>
                <input type="text" class="form-control" id="menuName" name="menuName" value="<?= $rowSelect['menuName'] ?>" required>
            </div>
            <div class="form-group">
                <label for="menuCategory">Category: :</label>
                <input type="text" class="form-control" id="menuCategory" name="menuCategory" value="<?= $rowSelect['menuCategory'] ?>" required>
            </div>
            <div class="form-group">
                <label for="menuPrice">Price: </label>
                <input type="number" class="form-control" id="menuPrice" name="menuPrice" value="<?= $rowSelect['menuPrice'] ?>" required>
            </div>
         
            <button type="submit" class="btn btn-primary">Update</button>
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