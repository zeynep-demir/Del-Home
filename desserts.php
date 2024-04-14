<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Del - Home</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container mt-5">
    <h2>Desserts</h2>
    <?php
    $conn = new mysqli("localhost", "root", "", "yemeksepetiDB");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM menuTable WHERE menuCategory='Dessert'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
  
        echo '<div class="row">';
        $imageIndex = 1;
        while ($row = $result->fetch_assoc()) {
            $imageFileName = $row['menuName']  .".png";
        $imgSrc = "images/{$imageFileName}";

            echo '<div class="col-md-4">';
            echo '<div class="card"  style="margin-bottom: 15px;">';
            echo '<div class="card-body">';
            echo ' <div style="display: flex; justify-content: space-between;">';

            echo '<h5 class="card-title">' . $row["menuName"] . '</h5>';
            echo '<p class="card-text">Fiyat: $' . $row["menuPrice"] . '</p>';
            echo ' </div>';

            echo '<img src="images/' .$row['menuImg'] . '" alt="Resim" style="width: 90px; min-width:90px; min-height:90px; max-width:90px; max-height: 90px;">';

            echo '<div class="quantity-btns" style="display: flex; justify-content: end;">';
            echo '<button onclick="changeQuantity(-1, '. $row["menuId"] . ');" class="btn btn-sm btn-secondary">-</button>';
            echo '<span id="quantity-'. $row["menuId"] . '"  style="margin: 0 5px;"> 1 </span>';
            echo ' <button onclick="changeQuantity(1,'. $row["menuId"] . ');" class="btn btn-sm btn-secondary">+</button>';
            echo '<div class="add-to-cart-btn"  style="margin-left: 10px;">';
            echo ' </div>';
            echo '<form id="addToCartForm" method="post" action="addToCart.php">';
            echo '<input type="hidden" name="order_id" value="' . $row["menuId"] . '">';
            echo '<input type="hidden" name="order_name" value="' . $row["menuName"] . '">';
            echo '<input type="hidden" name="order_category" value="' . $row["menuCategory"] . '">';
            echo '<input type="hidden" name="quantity" id="quantityInput-'. $row["menuId"] . '" value=1>';
            echo '<input type="hidden" name="price" value="' . $row["menuPrice"] . '">';
            echo '<button type="submit" class="btn btn-success btn-sm">';
            echo '<i class="fas fa-shopping-cart"></i> Add to cart';
            echo '</button>';
            echo '</form>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            
            $imageIndex++;

        }
        echo '</div>';
    } else {
        echo "Menu is empty.";
    }

    $conn->close();
    ?>


</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="script.js"></script>

</body>
</html>
