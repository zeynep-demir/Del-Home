<?php
session_start();
$email=$_SESSION['email'];
include 'navbar.php';
$conn = new mysqli("localhost", "root", "", "yemeksepetiDB");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM cartTable where ordererEmail='$email'";
$result = $conn->query($sql);

if ($result === false) {
    die("Query failed: " . $conn->error);
}
$totalQuantity = 0;
$totalPrice = 0;

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

<div class="container mt-5">
    <h2>My Cart</h2>
    <table class="table">
        <thead>
            <tr style="text-align: center;">
                <th></th>
                <th>Order Id</th>
                <th>Order Name</th>
                <th class="orderQuantity">Quantity</th>
                <th class="orderPrice">Price</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = $result->fetch_assoc()) {
                echo '<tr style="text-align: center;">';
                echo '<td>';
                echo     '<form action="deleteOrder.php" method="post"  onsubmit="return confirm(`Are you sure you want to delete?`);">';
                echo   '<input type="hidden" name="orderId" value="' . $row['orderId'] . '">';
                echo      ' <button type="submit" style="cursor: pointer; border: none; background-color: transparent;">Delete</button>';
                echo  ' </form>  '      ;
                echo      ' </td>';
                echo '<td id="orderId" value="' . $row['orderId'] . '">' . $row['orderId'] . '</td>';
                echo '<td id="orderName" value="' . $row['orderName'] . '">' . $row['orderName'] . '</td>';
                echo '<td id="orderQuantity" value="' . $row['orderId'] . '">' . $row['orderQuantity'] . '</td>';
                echo '<td class="orderPrice" value="' . $row['orderQuantity'] . '">' . $row['orderPrice'] . '</td>';
                echo '</tr>';

                // Calculate total quantity and total price
                $totalQuantity += $row['orderQuantity'];
                $totalPrice += $row['orderQuantity'] * $row['orderPrice'];
            }

            echo '<tr style="text-align: center;">';
            echo '<th></th>';
            echo '<th></th>';
            echo '<th></th>';
            echo '<th id="quantity">' . $totalQuantity . '</th>';
            echo '<th id="price">' . $totalPrice . '</th>';
            echo '</tr>';
            ?>
        </tbody>
    </table>
    <div style="display: flex; justify-content: end;">
        <form id="buyForm" action="payment.php" method="post">
            <input type="hidden" name="totalPrice" id="totalPrice" value="<?php echo $totalPrice; ?>">
            <button type="submit" class="btn btn-success">Buy</button>
        </form>
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
