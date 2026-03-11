<?php
include 'db.php';
session_start();
if(isset($_GET['remove'])){
    $remove_id = $_GET['remove'];

    $conn->query("DELETE FROM cart 
                  WHERE product_id='$remove_id' 
                  AND user_id='".$_SESSION['user_id']."'");

    echo "<script>window.location='cart.php';</script>";
}
if(!isset($_SESSION['user_id'])){
    echo "<script>alert('Please login first!'); window.location='login.php';</script>";
    exit();
}

$user_id = $_SESSION['user_id'];

$query = $conn->query("
    SELECT products.*, cart.size 
    FROM cart
    JOIN products ON cart.product_id = products.id
    WHERE cart.user_id = '$user_id'
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Cart</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<h2 style="text-align:center;">Your Shopping Cart</h2>

<div class="products">

<?php
if($query->num_rows == 0){
    echo "<p style='text-align:center;'>Your cart is empty.</p>";
}

while($row = $query->fetch_assoc()){
?>

<div class="product">
    <img src="images/<?php echo $row['image']; ?>">
    <h4><?php echo $row['name']; ?></h4>
    <p>Size: <?php echo $row['size']; ?></p>
    <p class="price">₹<?php echo $row['price']; ?></p>
    <a href="cart.php?remove=<?php echo $row['id']; ?>" 
   style="color:red;">Remove</a>
</div>

<?php } ?>

</div>

</body>
</html>