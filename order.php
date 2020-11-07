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

$orders = $orderFn->getOrderByMemberId($member['Member_id']);

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
            margin-right: 0.5rem;
        }
    </style>
</head>

<body>
    <?php include_once('./components/navbar.php'); ?>

    <div class="container pt-3 pb-5">
        <div class="form-inline mb-3">
            <h3>รายการสั่งซื้อ</h3>

            <div class="ml-auto">
                ติดต่อผู้ดูแล
                <a href="https://line.me/ti/p/~namploy_22" class="ml-2" target="_blank">
                    <img src="assets/line@.jpg" alt="" width="60" height="60"> </a>
            </div>
        </div>
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>รหัสใบสั่งซื้อ</th>
                    <th>ราคารวม</th>
                    <th width="30%">ที่อยู่</th>
                    <th>เบอร์โทร</th>
                    <th>สถานะ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $count = 0;
                while ($order = $orders->fetch_assoc()) {
                    $carts = json_decode($order['Order_products']);
                ?>
                    <tr>
                        <td class="text-center"> <?php echo $order['Order_id']; ?> </td>
                        <td class="text-right price"> <?php echo "฿" . number_format($order['Order_price']); ?> </td>
                        <td> <?php echo $order['Order_address']; ?> </td>
                        <td> <?php echo $order['Order_phone']; ?> </td>
                        <td class="text-center">
                            <?php if ($order['Order_status'] == 'waiting') { ?>
                                <span class="text-warning"> รอยืนยันการโอน </span>
                            <?php } else if ($order['Order_status'] == 'success') { ?>
                                <span class="text-success"> ยืนยันการโอนแล้ว </span>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="100%">
                            <a data-toggle="collapse" data-target="#collapse-<?php echo $count; ?>">
                                <button type="button" class="btn btn-primary"> <i class="fas fa-angle-double-down"></i> แสดง/ซ่อน รายการสินค้า </button> </a>
                            <div class="collapse" id="collapse-<?php echo $count; ?>">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th> ชื่อสินค้า </th>
                                            <th> รายละเอียด </th>
                                            <th> จำนวน </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($carts as $cart) {
                                            $products = $productFn->productGetById($cart->Product_id);
                                            $product = $products->fetch_assoc();

                                            $pictures = $pictureFn->pictureGetByProductId($cart->Product_id);
                                        ?>
                                            <tr>
                                                <td> <?php echo $product['Product_name'] ?> </td>
                                                <td> <?php echo $product['Product_description'] ?> </td>
                                                <td class="text-right"> <?php echo $cart->Cart_amount ?> ชิ้น </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>

                <?php
                    $count++;
                }
                ?>
            </tbody>
        </table>
    </div>

    <?php include_once('./assets/scripts.html'); ?>
</body>

</html>