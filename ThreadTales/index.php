<?php
include 'db.php';
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>ThreadTales</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>


<div class="luxury-header">
    <div class="logo-title">ThreadTales</div>
    <div class="logo-subtitle">ELEGANCE WOVEN IN EVERY THREAD</div>
    <div class="logo-line"></div>
</div>
<div class="navbar">
    <div class="logo">ThreadTales</div>

    <div class="nav-links">
        <a href="cart.php">Cart</a>
        <a href="wishlist.php">Wishlist</a>
        <a href="login.php">Login</a>
    </div>

    <div class="search-bar">
        <form method="GET" action="search.php">
            <input type="text" name="search" placeholder="Search products...">
            <button type="submit">Search</button>
        </form>
    </div>
</div>

<div class="category">
    <a href="index.php">All</a>
    <a href="index.php?gender=Men">Men</a>
    <a href="index.php?gender=Women">Women</a>
</div>

<div class="products">

<?php
if(isset($_GET['gender'])) {
    $gender = $_GET['gender'];
    $result = $conn->query("SELECT * FROM products WHERE gender='$gender'");
} else {
    $result = $conn->query("SELECT * FROM products");
}

while($row = $result->fetch_assoc()) {
?>
    <div class="product">
        <img src="images/<?php echo $row['image']; ?>" alt="">
        <h4><?php echo $row['name']; ?></h4>
        <p class="price">₹<?php echo $row['price']; ?></p>
        <a class="view-btn" href="product.php?id=<?php echo $row['id']; ?>">View</a>
    </div>
<?php
}
?>
</body>
</html>