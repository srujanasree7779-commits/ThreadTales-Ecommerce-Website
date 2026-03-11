<?php
include 'db.php';
session_start();

$id = $_GET['id'];
$product = $conn->query("SELECT * FROM products WHERE id=$id")->fetch_assoc();

$rating_result = $conn->query("SELECT AVG(rating) as avg_rating FROM reviews WHERE product_id='$id'");
$rating_data = $rating_result->fetch_assoc();
$avg_rating = round($rating_data['avg_rating'], 1);
if(!$avg_rating) $avg_rating = 4.0;

if(isset($_POST['buy_now']) || isset($_POST['cart'])) {

    if(!isset($_SESSION['user_id'])) {
        echo "<script>alert('Please login first!'); window.location='login.php';</script>";
        exit();
    }

    $user_id = $_SESSION['user_id'];
    $size = $_POST['size'];

    if(isset($_POST['buy_now'])) {
        $conn->query("INSERT INTO orders (user_id, product_id, size)
                      VALUES ('$user_id', '$id', '$size')");
        echo "<script>alert('Order Placed Successfully!');</script>";
    }

    if(isset($_POST['cart'])) {
        $conn->query("INSERT INTO cart (user_id, product_id, size)
                      VALUES ('$user_id', '$id', '$size')");
        echo "<script>alert('Added to Cart Successfully!');</script>";
    }
}

if(isset($_POST['wishlist'])) {

    if(!isset($_SESSION['user_id'])) {
        echo "<script>alert('Please login first!'); window.location='login.php';</script>";
        exit();
    }

    $user_id = $_SESSION['user_id'];

   $check = $conn->query("SELECT * FROM wishlist 
                       WHERE user_id='$user_id' 
                       AND product_id='$id'");

if($check->num_rows > 0){
    echo "<script>alert('Already in Wishlist!');</script>";
} else {
    $conn->query("INSERT INTO wishlist (user_id, product_id)
                  VALUES ('$user_id', '$id')");
    echo "<script>alert('Added to Wishlist!');</script>";
}
    echo "<script>alert('Added to Wishlist!');</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $product['name']; ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="product-page">

    <div class="product-image">
        <img src="images/<?php echo $product['image']; ?>">
    </div>

    <div class="product-details">

        <h2><?php echo $product['name']; ?></h2>

        <div class="rating-box">
            <?php
            $full = floor($avg_rating);
            for($i=1; $i<=5; $i++){
                echo $i <= $full ? "⭐" : "☆";
            }
            ?>
            (<?php echo $avg_rating; ?>)
        </div>

        <p class="price">₹<?php echo $product['price']; ?></p>

        <form method="POST">

            <div class="size-section">
                <label>Select Size:</label>
                <select name="size" class="size-select">
                    <option>S</option>
                    <option>M</option>
                    <option>L</option>
                    <option>XL</option>
                </select>
            </div>

            <div class="button-group">
                <button name="buy_now" class="buy-btn">Buy Now</button>
                <button name="cart" class="cart-btn">Add to Bag</button>
                <button name="wishlist" class="wishlist-btn">❤</button>
            </div>

        </form>

    </div>

</div>

</body>
</html>