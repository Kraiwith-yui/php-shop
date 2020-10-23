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
include_once('functions/order-function.php');
$productFn = new productFunction();
$pictureFn = new pictureFunction();
$orderFn = new orderFunction();

$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$parts = parse_url($actual_link);
parse_str($parts['query'], $query);
$pId = $query['pId'];
$amount = $query['amount'];

$product = $productFn->productGetById($pId)->fetch_assoc();
$picture = $pictureFn->pictureGetByProductId($pId)->fetch_assoc();

if (isset($_POST['submit'])) {
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $price = $product['Product_price'] * $amount;
    $amount = $amount;

    $result = $orderFn->create($address, $phone, $price, $amount, $member['Member_id'], $pId);
    if ($result) {
        echo "<script>window.location.href='order.php';</script>";
    } else {
        echo "<script>window.alert('Failed to create order.');</script>";
        echo "<script>window.location.href='product-detail.php?pId=$pId';</script>";
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
    </style>
</head>

<body>
    <?php include_once('./components/navbar.php'); ?>

    <div class="container py-5">
        <div class="row">
            <div class="col-8">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th> สินค้า </th>
                            <th width="180px"> ราคา </th>
                            <th width="120px"> จำนวน </th>
                        </tr>
                    </thead>
                    <tbody>
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
                            <td class="text-center price"> <?php echo "฿" . number_format($product['Product_price']); ?> </td>
                            <td class="text-center"> <?php echo $amount ?> </td>
                        </tr>
                    </tbody>
                </table>
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
                            <div class="form-group">
                                <div class="text-right">
                                    <span class="float-left"> รวมทั้งสิ้น </span>
                                    <span class="price">
                                        <?php echo "฿" . number_format($amount * $product['Product_price']); ?>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group sr-only">
                                <input type="text" name="totalPrice" <?php echo "value='" . $amount * $product['Product_price'] . "'" ?>>
                                <input type="text" name="amount" <?php echo "value='$amount'" ?>>
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