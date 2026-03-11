<?php 
include 'db.php';
session_start();

if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/* REMOVE ITEM */
if(isset($_GET['remove'])){
    $remove_id = $_GET['remove'];

    $conn->query("DELETE FROM wishlist 
                  WHERE product_id='$remove_id' 
                  AND user_id='$user_id'");

    echo "<script>window.location='wishlist.php';</script>";
    exit();
}

/* FETCH WISHLIST ITEMS */
$result = $conn->query("
    SELECT products.id, products.name, products.price, products.image
    FROM wishlist
    JOIN products ON wishlist.product_id = products.id
    WHERE wishlist.user_id = '$user_id'
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Wishlist</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<h2 style="text-align:center;">My Wishlist</h2>

<div class="products">

<?php
if($result->num_rows > 0) {

    while($row = $result->fetch_assoc()) {
?>
        <div class="product">
            <img src="images/<?php echo $row['image']; ?>">
            <h4><?php echo $row['name']; ?></h4>
            <p class="price">₹<?php echo $row['price']; ?></p>

            <a href="wishlist.php?remove=<?php echo $row['id']; ?>" 
               style="color:red; text-decoration:none;">
               Remove
            </a>
        </div>
<?php
    }

} else {
    echo "<h3 style='padding:40px;'>Your wishlist is empty.</h3>";
}
?>

</div>

</body>
</html>