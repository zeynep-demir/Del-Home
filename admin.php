<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include 'navbar.php';

$conn = new mysqli("localhost", "root", "", "yemeksepetiDB");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$uploadDir = 'images/';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $file = $_FILES['file'];

    if ($file['error'] === UPLOAD_ERR_OK) {
        $fileInfo = pathinfo($file['name']);
        $fileExtension = $fileInfo['extension'];

        $menuName = $_POST['menuName'] ?? ''; 
        $fileName = $menuName . '.' . $fileExtension;

        $destination = $uploadDir . $fileName;
        $updateSql = "UPDATE menuTable SET menuImg='$fileName' WHERE menuName='$menuName'";

      
        if ($conn->query($updateSql) === TRUE) {
            $message = "Görsel başarıyla güncellendi.";
        } else {
            $message = "Hata: " . $conn->error;
        }
        if (move_uploaded_file($file['tmp_name'], $destination)) {
        } else {
        }
    } else {
        // echo 'Error: ' . $file['error'];
    }
}



$sql = "SELECT * FROM menuTable";
$result = $conn->query($sql);

if ($result === false) {
    die("Query failed: " . $conn->error);
}

$totalQuantity = 0;
$totalPrice = 0;


$rowsPerPage = 5; 
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;

$totalRows = $result->num_rows;
$totalPages = ceil($totalRows / $rowsPerPage);

$offset = ($page - 1) * $rowsPerPage;
$limit = $rowsPerPage;

$sql = "SELECT * FROM menuTable LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);

if ($result === false) {
    die("Query failed: " . $conn->error);
}
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
    <div class="container mt-5">
        <h2 style="text-align: center;">Menu</h2>
        <div style="text-align: end; margin-bottom: 20px;">
                    <a href="addMenu.php" class="btn btn-success">Add Menu</a>

        </div>
        <table class="table">
            <thead>
                <tr style="text-align: center;">
                    <th></th>
                    <th>Food Id</th>
                    <th>Food Image</th>
                    <th>Food Name</th>
                    <th class="menuCategory">Category</th>
                    <th class="menuPrice">Price</th>
                    <th class="menuImg">Choose Image</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php $result->data_seek(0);
                while ($row = $result->fetch_assoc()) { ?>
                    <tr style="text-align: center;">
                        <td>
                            <form action="deleteMenu.php" method="post" onsubmit="return confirm('Are you sure you want to delete?');">
                                <input type="hidden" name="menuId" value="<?= $row['menuId'] ?>">
                                <button type="submit" style="cursor: pointer; border: none; background-color: transparent;">Delete</button>
                            </form>
                        </td>
                        <td id="menuId" value="<?= $row['menuId'] ?>"><?= $row['menuId'] ?></td>
                        <?php
                       
                        echo '<td><img src="images/' . $row['menuImg'] . '" alt="Resim" style="width: 90px;"></td>';

                        ?>
                        </td>
                        <td id="menuName" value="<?= $row['menuName'] ?>"><?= $row['menuName'] ?></td>
                        <td class="menuCategory" value="<?= $row['menuCategory'] ?>"><?= $row['menuCategory'] ?></td>
                        <td class="menuPrice" value="<?= $row['menuPrice'] ?>"><?= $row['menuPrice'] ?></td>
                        <td>
                        <form action="" method="post" enctype="multipart/form-data" class="form-inline" style="flex-wrap: nowrap;">
                        <input type="hidden" name="menuName" value="<?= $row['menuName'] ?>">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="file" name="file" accept="image/*">
                            <label class="custom-file-label" for="file">Choose File</label>
                        </div>
                        <input type="submit" value="Upload" class="btn btn-primary ml-2">
                    </form>
                        </td>
                        <td> <a href="updateMenu.php?id=<?= $row['menuId'] ?>" class="btn btn-primary">Update</a> </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <div class="pagination" style="justify-content: center; margin-bottom:20px">
    <?php
    for ($i = 1; $i <= $totalPages; $i++) {
        echo "<button class='btn btn-primary' style='margin-left: 10px;'><a style='color:white' href='?page=$i'>$i</a></button>";
    }
    ?>
</div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>

<?php
$conn->close();
?>