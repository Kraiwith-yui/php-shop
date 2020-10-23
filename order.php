<?php

session_start();
if (!isset($_SESSION['Member'])) {
    header('location: login.php');
}
$member = $_SESSION['Member'];

include_once('functions/order-function.php');
include_once('functions/product-function.php');
include_once('functions/picture-function.php');
$orderFn = new orderFunction();
$productFn = new productFunction();
$pictureFn = new pictureFunction();

$orders = $orderFn->getByMemberId($member['Member_id']);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Namploy Shop</title>
    <link rel="icon" href="assets/logo.ico" type="image/ico">

    <?php include_once('./assets/styles.html'); ?>
</head>

<body>
    <?php include_once('./components/navbar.php'); ?>

    <div class="container pt-3 pb-5">
        <h3>รายการสั่งซื้อ</h3>
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>รหัสใบสั่งซื้อ</th>
                    <th width="20%">สินค้า</th>
                    <th>ราคา</th>
                    <th>จำนวน</th>
                    <th width="30%">ที่อยู่</th>
                    <th>เบอร์โทร</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($order = $orders->fetch_assoc()) {
                    $product = $productFn->productGetById($order['Product_id'])->fetch_assoc();
                ?>
                    <tr>
                        <td class="text-center"> <?php echo $order['Order_id']; ?> </td>
                        <td> <?php echo $product['Product_name']; ?> </td>
                        <td class="text-right"> <?php echo "฿".number_format($order['Order_price']); ?> </td>
                        <td class="text-right"> <?php echo number_format($order['Order_amount']); ?> </td>
                        <td> <?php echo $order['Order_address']; ?> </td>
                        <td> <?php echo $order['Order_phone']; ?> </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <?php include_once('./assets/scripts.html'); ?>
</body>

</html>