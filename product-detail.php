<?php

session_start();


$member = null;
if (isset($_SESSION['Member'])) {
    $member = $_SESSION['Member'];
}

include_once('functions/product-function.php');
include_once('functions/picture-function.php');
include_once('functions/cart-function.php');

$productFn = new productFunction();
$pictureFn = new pictureFunction();
$cartFn = new cartFunction();

$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$parts = parse_url($actual_link);
parse_str($parts['query'], $query);
$pId = $query['pId'];

$products = $productFn->productGetById($pId);
$product = $products->fetch_assoc();

$pictures = $pictureFn->pictureGetByProductId($pId);

if (isset($_POST['submit'])) {
    $amount = $_POST['amount'];

    $carts = $cartFn->cartGetMy($product['Product_id'], $member['Member_id']);
    if ($carts->num_rows > 0) {

        // Update 
        $cart = $carts->fetch_assoc();
        $calAmount = $cart['Cart_amount'] + $amount;
        $update = $cartFn->cartUpdateAmount($cart['Cart_id'], $calAmount);
        if ($update) {
            echo "<script>window.location.href='cart.php?cartId=" . $cart['Cart_id'] . "';</script>";
        } else {
            echo "<script>alert('Failed for add cart!');</script>";
            echo "<script>window.location.href='cart.php';</script>";
        }
    } else {

        // Create 
        $create = $cartFn->cartCreate($amount, $pId, $member["Member_id"]);
        if ($create) {
            echo "<script>window.location.href='cart.php';</script>";
        } else {
            echo "<script>alert('Failed for add cart!');</script>";
            echo "<script>window.location.href='cart.php';</script>";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Namploy Shop</title>
    <link rel="icon" href="assets/logo.ico" type="image/ico">

    <?php include_once('./assets/styles.html'); ?>
    <style>
        .product-img {
            width: 100%;
            height: 100px;
            object-fit: contain;
            cursor: pointer;
            transition: all 0.2 ease;
        }

        .product-img:hover {
            transform: scale(1.05);
        }

        .img-showing {
            width: 100%;
            object-fit: contain;
            object-position: top;
            height: 500px;
        }
    </style>
</head>

<body>
    <?php include_once('./components/navbar.php'); ?>

    <div class="container py-5">
        <div class="row">
            <div class="col-8">
                <div class="border shadow-sm p-3 bg-light">
                    <div class="show-img mb-4">
                        <img class="img-showing" src="assets/no-image.png" alt="" id="img-showing">
                    </div>

                    <div class="row">
                        <?php while ($picture = $pictures->fetch_assoc()) { ?>
                            <div class="col-3 mb-3">
                                <img class="product-img" <?php echo "src='uploads/" . $picture['Picture_name'] . "'"; ?> alt="" onclick="selectShowImage(this)">
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card">
                    <div class="card-body">
                        <h2> <?php echo $product['Product_name']; ?> </h2>
                        <h4 class="price"> <?php echo "฿" . number_format($product['Product_price']); ?> </h4>
                        <p class="text-secondary"> <?php echo $product['Product_description']; ?> </p>
                        <form method="POST">
                            <div class="form-group sr-only">
                                <input type="text" name="pId" class="form-control" <?php echo "value=$pId"; ?> required>
                            </div>
                            <div class="form-group">
                                มีสินค้าทั้งหมด <?php echo number_format($product['Product_amount']); ?> ชิ้น
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">จำนวน</span>
                                    </div>
                                    <input type="number" name="amount" class="form-control text-right" value="1" min="1" max="<?php echo $product['Product_amount']; ?>" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">ชิ้น</span>
                                    </div>
                                </div>
                            </div>
                            <?php if (isset($member)) { ?>
                                <button type="submit" name="submit" class="btn btn-block btn-warning"> <i class="fas fa-shopping-cart"></i> เพิ่มในตะกร้า </button>
                            <?php } else { ?>
                                <a href="login.php" class="btn btn-block btn-warning">
                                    <i class="fas fa-shopping-cart"></i> เพิ่มในตะกร้า </button> </a>
                            <?php } ?>

                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div>
    </div>

    <?php include_once('./assets/scripts.html'); ?>
    <script>
        window.document.body.onload = (event => {
            const elImages = document.getElementsByClassName('product-img');

            selectShowImage(elImages[0]);
        });

        function selectShowImage(event) {
            const elImgShowing = document.getElementById('img-showing');
            elImgShowing.src = event.src;
        }
    </script>
</body>

</html>