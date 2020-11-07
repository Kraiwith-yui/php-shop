<?php

session_start();

$member = null;
if (isset($_SESSION['Member'])) {
    $member = $_SESSION['Member'];
} else {
    header('localtion: login.php');
}

include_once('functions/product-function.php');
include_once('functions/picture-function.php');
include_once('functions/cart-function.php');
include_once('functions/order-function.php');
$productFn = new productFunction();
$pictureFn = new pictureFunction();
$cartFn = new cartFunction();
$orderFn = new orderFunction();

$carts = $cartFn->cartGetByMemberId($member['Member_id']);

if (isset($_POST['submit'])) {
    $addr = $_POST['address'];
    $phone = $_POST['phone'];
    $totalPrice = $_POST['totalprice'];
    $products = $_POST['products'];

    $order = $orderFn->create($addr, $phone, $totalPrice, $member['Member_id'], $products);
    if ($order) {
        // Remove All Cart
        $rmCart = $cartFn->cartDeleteAll();

        // Update Decrease Product Amount
        $updateProducts = json_decode($products);
        foreach ($updateProducts as $cart) {
            $updateAmount = $productFn->updateAmount($cart['Product_id'], $cart['Cart_amount']);
        }

        echo "<script>window.location.href='./order.php';</script>";
    } else {
        echo "<script>alert('Create Order Failed!');</script>";
        echo "<script>window.location.href='./order.php';</script>";
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
            width: 50px;
            height: 50px;
            object-fit: cover;
            border: 1px solid #eee;
        }

        .total-price {
            font-size: 30px;
        }
    </style>
</head>

<body>
    <?php include_once('./components/navbar.php'); ?>

    <div class="container py-5">
        <div class="row">
            <div class="col-8">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th> สินค้า </th>
                            <th> ราคา </th>
                            <th width="100px"> จำนวน </th>
                            <th> รวม </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $totalPrice = 0;
                        $newCarts = array();
                        while ($cart = $carts->fetch_assoc()) {
                            $products = $productFn->productGetById($cart['Product_id']);
                            $pictures = $pictureFn->pictureGetByProductId($cart['Product_id']);
                            if ($products->num_rows > 0) {
                                $product = $products->fetch_assoc();
                                $picture = $pictures->fetch_assoc();
                                $totalPrice += ($cart['Cart_amount'] * $product['Product_price']);

                                array_push($newCarts, $cart);
                        ?>
                                <tr>
                                    <td>
                                        <?php if (isset($picture["Picture_name"])) { ?>
                                            <img class="product-img float-left mr-2" <?php echo "src='uploads/" . $picture["Picture_name"] . "'"; ?> alt="">
                                        <?php } else { ?>
                                            <img class="product-img float-left mr-2" src="assets/no-image.png" alt="">
                                        <?php } ?>
                                        <div class="" style="margin-left: 58px;">
                                            <div> <?php echo $product['Product_name'] ?> </div>
                                            <div class="text-muted"> <?php echo $product['Product_description'] ?> </div>
                                        </div>
                                    </td>
                                    <td class="text-right price"> <?php echo "฿" . number_format($product['Product_price']); ?> </td>
                                    <td class="text-right"> <?php echo $cart['Cart_amount'] ?> ชิ้น </td>
                                    <td class="text-right"> ฿<?php echo number_format($cart['Cart_amount'] * $product['Product_price']); ?> </td>
                                </tr>
                        <?php
                            }
                        }
                        $strCarts = json_encode($newCarts, JSON_UNESCAPED_UNICODE);
                        ?>
                    </tbody>
                </table>

                <?php
                echo $strCarts;
                ?>
            </div>
            <div class="col-4">
                <div class="card">
                    <div class="card-body">
                        <form method="POST">
                            <div class="form-group">
                                <i class="fas fa-fw fa-map-marker-alt text-info text-left"></i> <small class="text-muted">ถึง</small> <?php echo $member['Member_fullname'] ?>
                            </div>
                            <div class="form-group">
                                <label for="addr"><i class="fas fa-fw fa-truck text-info text-left"></i> <small class="text-muted">ที่อยู่การจัดส่ง</small></label>
                                <textarea id="addr" name="address" rows="3" class="form-control" required maxlength="100"><?php echo $member['Member_address'] ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="tel"> <i class="fas fa-fw fa-phone-alt text-info text-left"></i> <small class="text-muted">เบอร์โทร</small> </label>
                                <input type="text" id="tel" name="phone" class="form-control" required maxlength="30" value="<?php echo $member['Member_phone'] ?>">
                            </div>
                            <div class="form-group d-none">
                                <input type="text" name="totalprice" class="form-control" value="<?php echo $totalPrice; ?>">
                                <textarea name="products" class="form-control"><?php echo $strCarts; ?></textarea>
                            </div>
                            <div class="form-group form-inline">
                                <span class="mr-auto"> รวมทั้งสิ้น </span>
                                <span class="total-price price">
                                    <?php echo "฿" . number_format($totalPrice); ?>
                                </span>
                            </div>
                            <button type="submit" name="submit" class="btn btn-block btn-warning"> สั่งซื้อ </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include_once('./assets/scripts.html'); ?>
</body>

</html>