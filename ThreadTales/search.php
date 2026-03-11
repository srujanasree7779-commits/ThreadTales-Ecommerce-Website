<?php
include 'db.php';
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Results</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="navbar">
    <div class="logo">ThreadTales</div>
    <div class="nav-links">
        <a href="index.php">Home</a>
        <a href="cart.php">Cart</a>
        <a href="wishlist.php">Wishlist</a>
    </div>
</div>

<div class="products">

<?php
if(isset($_GET['search'])) {

    $search = $_GET['search'];

    $result = $conn->query("SELECT * FROM products 
                            WHERE name LIKE '%$search%' 
                            OR category LIKE '%$search%'");

    if($result->num_rows > 0) {

        while($row = $result->fetch_assoc()) {
?>
            <div class="product">
                <img src="images/<?php echo $row['image']; ?>">
                <h4><?php echo $row['name']; ?></h4>
                <p class="price">₹<?php echo $row['price']; ?></p>
                <a class="view-btn" href="product.php?id=<?php echo $row['id']; ?>">View</a>
            </div>
<?php
        }

    } else {
        echo "<h3 style='padding:40px;'>No products found.</h3>";
    }
}
?>

</div>

</body>
</html>