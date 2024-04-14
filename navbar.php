<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">Del-Home</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ml-auto">
    <?php
            session_start();

            if(isset($_SESSION["email"]) && $_SESSION["email"] == "admin@gmail.com") {
                echo '<li class="nav-item active">';
                echo '<a class="nav-link" href="admin.php">Admin</a>';
                echo '</li>';
            }
            ?>
      <li class="nav-item active">
        <a class="nav-link" href="mainmenu.php">Main Menu</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="maincourse.php">Main Courses</a>
      </li>  
      <li class="nav-item">
        <a class="nav-link" href="desserts.php">Desserts</a>
      </li> 
      <li class="nav-item">
        <a class="nav-link" href="cart.php">My Cart</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="profile.php">My Profile</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="logout.php">Log Out</a>
      </li>
    </ul>
  </div>
</nav>
</body>
</html>